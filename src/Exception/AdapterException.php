<?php
declare(strict_types=1);
/**
 * Canary - A PSR-6 compliant cache library.
 */

namespace Canary\Cache\Exception;

use Exception;

/**
 * @class      AdapterException.
 * @extends    Exception.
 * @implements ExceptionInterface.
 */
class AdapterException extends Exception implements ExceptionInterface
{
}
