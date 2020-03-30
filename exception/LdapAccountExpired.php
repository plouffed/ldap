<?php namespace plouffed\ldap\exception;

use Throwable;

/**
 * 49 / 701	- ACCOUNT_EXPIRED
 *
 * Indicates an Active Directory (AD) AcceptSecurityContext data error that is a logon failure.
 * The user's account has expired. Returns only when presented with valid username and password credential.
 *
 * https://docs.servicenow.com/bundle/newyork-platform-administration/page/administer/reference-pages/reference/r_LDAPErrorCodes.html
 */
class LdapAccountExpired extends LdapException {
  const code = 701;
  public function __construct($message = 'Votre compte est expiré. Veuillez contacter votre technicien informatique.', $code = LdapAccountExpired::code, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
  }
}
