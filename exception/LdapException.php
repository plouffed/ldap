<?php namespace plouffed\ldap\exception;

use Throwable;

class LdapException extends \RuntimeException {
  public function __construct($message = '', $code = 0, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
  }
}
