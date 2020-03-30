<?php namespace plouffed\ldap\exception;

use Throwable;

/**
 * 10302 - LDAP_ERROR_CONNECTION_REFUSED
 *
 * https://docs.servicenow.com/bundle/newyork-platform-administration/page/administer/reference-pages/reference/r_LDAPErrorCodes.html
 */
class LdapConnectionFailed extends LdapException {
  public function __construct($message = 'La connexion LDAP a échoué.', $code = 10302, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
  }
}
