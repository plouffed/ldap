<?php namespace plouffed\ldap\exception;

use Throwable;

/**
 * 49 / 52e -	AD_INVALID CREDENTIALS
 *
 * Indicates an Active Directory (AD) AcceptSecurityContext error, which is returned when the username
 * is valid but the combination of password and user credential is invalid.
 * This is the AD equivalent of LDAP error code 49.
 *
 * https://docs.servicenow.com/bundle/newyork-platform-administration/page/administer/reference-pages/reference/r_LDAPErrorCodes.html
 */
class LdapInvalidPassword extends LdapException {
  const code = 52;
  public function __construct($message = "Nom d'usager ou mot de passe invalide.", $code = LdapInvalidPassword::code, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
  }
}
