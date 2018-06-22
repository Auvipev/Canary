<?php
declare(strict_types=1);
/**
 * Canary - A PSR-6 compliant cache library.
 *
 * @author Nicholas English <nenglish6657@gmail.com>.
 *
 * @license <https://github.com/Auvipev/Canary/blob/master/LICENSE> GNU General Public License v3.0.
 *
 * Permissions of this strong copyleft license are conditioned on making available complete
 * source code of licensed works and modifications, which include larger works using a licensed work,
 * under the same license. Copyright and license notices must be preserved. Contributors provide
 * an express grant of patent rights.
 *
 * @link <https://www.php-fig.org/psr/psr-6/>.
 *
 * A common interface for caching systems will solve these problems. Library and framework developers
 * can count on the caching systems working the way they're expecting, while the developers of caching systems
 * will only have to implement a single set of interfaces rather than a whole assortment of adapters.
 *
 * @package Auvipev/Canary.
 */

namespace Canary\Cache\Exception;

use Throwable;

/**
 * The exception interface.
 *
 * @interface ExceptionInterface.
 * @extends   Throwable.
 */
interface ExceptionInterface extends Throwable
{
}
