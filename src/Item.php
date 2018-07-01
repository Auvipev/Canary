<?php
declare(strict_types=1);
/**
 * Canary - A PSR-6 compliant cache library.
 */

namespace Canary\Cache;

use Psr\Cache\CacheItemPoolInterface;
use Canary\Cache\Exception\AdapterException;
use Canary\Cache\Exception\KeyException;

/**
 * @class      ItemPool.
 * @implements CacheItemPoolInterface.
 */
class ItemPool implements CacheItemPoolInterface
{

    /**
     * @var AdapterInterface $adapter The cache adapter.
     */
    private $adapter;

    /**
     * Initialize a new cache pool with the intended cache adapter.
     *
     * @param AdapterInterface $adapter The cache adapter.
     *
     * @throws AdapterException If the intended adapter is not avaliable.
     *
     * @return void Returns nothing.
     */
    public function __construct(AdapterInterface $adapter)
    {
        if (!$adapter->isAvaliable()) {
            throw new AdapterException('The intended adapter is not avaliable.');
        }
        $this->adapter = $adapter;
    }
}
