<?php
declare(strict_types=1);
/**
 * Canary - A PSR-6 compliant cache library.
 *
 * @link <https://github.com/Auvipev/Canary> Github Repository.
 * @link <https://www.php-fig.org/psr/psr-6> PSR-6: Caching Interface.
 */

namespace Canary\Cache\Exception;

use Throwable;

/**
 * @interface ExceptionInterface.
 * @extends   Throwable.
 */
interface ExceptionInterface extends Throwable
{
}
