<?php
declare(strict_types=1);
/**
 * Canary - A PSR-6 compliant cache library.
 *
 * @link <https://github.com/Auvipev/Canary> Github Repository.
 * @link <https://www.php-fig.org/psr/psr-6> PSR-6: Caching Interface.
 */

namespace Canary\Cache\Adapter;

use Traversable;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Canary\Cache\Exception\KeyException;
use Canary\Cache\StatisticsInterface;
use Canary\Cache\ExtendedPSR6Interface;
use Canary\Cache\Item as CacheItem;

use function is_string;
use function wincache_ucache_get;
use function wincache_ucache_info;
use function wincache_ucache_exists;
use function wincache_ucache_clear;
use function wincache_ucache_set;

/**
 * Windows Cache Extension for PHP is a PHP accelerator that is used to increase the speed
 * of PHP applications running on Windows and Windows Server. Once the Windows Cache Extension
 * for PHP is enabled and loaded by the PHP engine, PHP applications can take advantage of the
 * functionality without any code modifications.
 *
 * @class      WinCache.
 * @implements CacheItemPoolInterface.
 */
class WinCache implements CacheItemPoolInterface, StatisticsInterface, ExtendedPSR6Interface
{

    /**
     * @var array $this->deferredItems
     */
    private $deferredItems = [];

    public function __construct()
    {
    }

    /**
     * Returns a Cache Item representing the specified key.
     *
     * This method must always return a CacheItemInterface object, even in case of
     * a cache miss. It MUST NOT return null.
     *
     * @param string $key The key for which to return the corresponding Cache Item.
     *
     * @throws KeyException If the $key string is not a legal value.
     *
     * @return CacheItemInterface The corresponding Cache Item.
     */
    public function getItem($key)
    {
        if (!is_string($key)) {
            throw new KeyException('The $key string is not a legal value.');
        }
        $value = wincache_ucache_get($key, $success);
        if ($success) {
            $info = wincache_ucache_info(false, $key);
            return new CacheItem($key, $value, $info['ttl']);
        }
        return new CacheItem();
    }

    /**
     * Returns a traversable set of cache items.
     *
     * @param string[] $keys An indexed array of keys of items to retrieve.
     *
     * @throws KeyException If the $key string is not a legal value.
     *
     * @return array|Traversable A traversable collection of Cache Items keyed by the cache keys of
     *                           each item. A Cache item will be returned for each key, even if that
     *                           key is not found. However, if no keys are specified then an empty
     *                           traversable MUST be returned instead.
     */
    public function getItems(array $keys = array())
    {
        $items = [];
        foreach ($keys as $key) {
            $items[] = $this->getItem($key);
        }
        if (empty($items)) {
            return yield Traversable;
        }
        return $items;
    }

    /**
     * Confirms if the cache contains specified cache item.
     *
     * Note: This method MAY avoid retrieving the cached value for performance reasons.
     * This could result in a race condition with CacheItemInterface::get(). To avoid
     * such situation use CacheItemInterface::isHit() instead.
     *
     * @param string $key The key for which to check existence.
     *
     * @throws KeyException If the $key string is not a legal value.
     *
     * @return bool True if item exists in the cache, false otherwise.
     */
    public function hasItem($key)
    {
        if (!is_string($key)) {
            throw new KeyException('The $key string is not a legal value.');
        }
        return wincache_ucache_exists($key);
    }

    /**
     * Deletes all items in the pool.
     *
     * @return bool True if the pool was successfully cleared. False if there was an error.
     */
    public function clear()
    {
        return wincache_ucache_clear();
    }

    /**
     * Removes the item from the pool.
     *
     * @param string $key The key to delete.
     *
     * @throws KeyException If the $key string is not a legal value.
     *
     * @return bool True if the item was successfully removed. False if there was an error.
     */
    public function deleteItem($key)
    {
        if (!is_string($key)) {
            throw new KeyException('The $key string is not a legal value.');
        }
        return wincache_ucache_delete($key);
    }

    /**
     * Removes multiple items from the pool.
     *
     * @param string[] $keys An array of keys that should be removed from the pool.
     *
     * @throws KeyException If the $key string is not a legal value.
     *
     * @return bool True if the items were successfully removed. False if there was an error.
     */
    public function deleteItems(array $keys)
    {
        foreach ($keys as $key) {
            if (!$this->deleteItem($key)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Persists a cache item immediately.
     *
     * @param CacheItemInterface $item The cache item to save.
     *
     * @return bool True if the item was successfully persisted. False if there was an error.
     */
    public function save(CacheItemInterface $item)
    {
        return wincache_ucache_set($item->getKey(), $item->getKey(), $item->ttl)
    }

    /**
     * Sets a cache item to be persisted later.
     *
     * @param CacheItemInterface $item The cache item to save.
     *
     * @return bool False if the item could not be queued or if a commit was attempted and failed. True otherwise.
     */
    public function saveDeferred(CacheItemInterface $item)
    {
        $this->deferredItems[] = $item;
    }

    /**
     * Persists any deferred cache items.
     *
     * @return bool True if all not-yet-saved items were successfully saved or there were none. False otherwise.
     */
    public function commit()
    {
        foreach ($this->deferredItems as $item) {
            if (!$this->save($item)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Output the cache pool statistics.
     *
     * @return array Returns an array full of info.
     */
    public function statistics()
    {
        return [
            'main' => wincache_ucache_info(true),
            'memory' => wincache_ucache_meminfo()
        ];
    }
}
