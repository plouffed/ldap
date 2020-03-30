<?php namespace plouffed\ldap\exception;

use Throwable;

/**
 * 49 / 533 -	ACCOUNT_DISABLED
 *
 * Indicates an Active Directory (AD) AcceptSecurityContext data error that is a logon failure.
 * The account is currently disabled. Returns only when presented with valid username and password credential.
 *
 * https://docs.servicenow.com/bundle/newyork-platform-administration/page/administer/reference-pages/reference/r_LDAPErrorCodes.html
 */
class LdapAccountDisabled extends LdapException {
  const code = 533;
  public function __construct($message = 'Votre compte est désactivé. Veuillez contacter votre technicien informatique.', $code = 533, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
  }
}
