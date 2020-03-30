<?php namespace plouffed\ldap\exception;

use Throwable;

/**
 * 49 / 532 - PASSWORD_EXPIRED
 *
 * Indicates an Active Directory (AD) AcceptSecurityContext data error that is a logon failure.
 * The specified account password has expired. Returns only when presented with
 * valid username and password credential.
 *
 * https://docs.servicenow.com/bundle/newyork-platform-administration/page/administer/reference-pages/reference/r_LDAPErrorCodes.html
 */
class LdapPasswordExpired extends LdapException {
  const code = 532;
  public function __construct($message = 'Votre mot de passe est expiré. Veuillez le changer via le centre d\'identité.', $code = LdapPasswordExpired::code, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
  }
}
