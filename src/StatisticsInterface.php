<?php
declare(strict_types=1);
/**
 * Canary - A PSR-6 compliant cache library.
 *
 * @link <https://github.com/Auvipev/Canary> Github Repository.
 * @link <https://www.php-fig.org/psr/psr-6> PSR-6: Caching Interface.
 */

namespace Canary\Cache;

/**
 * @interface StatisticsInterface.
 */
interface StatisticsInterface
{

    /**
     * Output the cache pool statistics.
     *
     * @return array Returns an array full of info.
     */
    public function statistics();
}
