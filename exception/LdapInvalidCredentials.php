<?php namespace plouffed\ldap\exception;

use Throwable;

/**
 * 49	- LDAP_INVALID_CREDENTIALS
 *
 * Indicates that during a bind operation one of the following occurred:
 *  The client passed either an incorrect DN or password,
 *  or the password is incorrect because it has expired,
 *  intruder detection has locked the account,
 *  or another similar reason.
 * See the data code for more information.
 *
 * https://docs.servicenow.com/bundle/newyork-platform-administration/page/administer/reference-pages/reference/r_LDAPErrorCodes.html
 */
class LdapInvalidCredentials extends LdapException {
  public function __construct($message = 'Nom d\'usager ou mot de passe invalide.', $code = 49, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
  }
}
