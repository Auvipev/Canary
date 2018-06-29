<?php
declare(strict_types=1);
/**
 * Canary - A PSR-6 compliant cache library.
 */

namespace Canary\Cache\Exception;

use Exception;
use Psr\Cache\InvalidArgumentException;

/**
 * @class      KeyException.
 * @extends    InvalidArgumentException.
 * @implements ExceptionInterface.
 */
class KeyException extends Exception implements ExceptionInterface, InvalidArgumentException
{
}
