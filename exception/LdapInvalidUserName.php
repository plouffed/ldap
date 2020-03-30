<?php namespace plouffed\ldap\exception;

use Throwable;

/**
 * 49 / 525 -	USER NOT FOUND
 * Indicates an Active Directory (AD) AcceptSecurityContext
 * data error that is returned when the username is invalid.
 *
 * https://docs.servicenow.com/bundle/newyork-platform-administration/page/administer/reference-pages/reference/r_LDAPErrorCodes.html
 */
class LdapInvalidUserName extends LdapException {
  const code = 525;
  public function __construct($message = 'Nom d\'usager ou mot de passe invalide.', $code = LdapInvalidUserName::code, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
  }
}
