<?php namespace plouffed\ldap\exception;

use Throwable;

/**
 * 49 / 773 - USER MUST RESET PASSWORD
 *
 * Indicates an Active Directory (AD) AcceptSecurityContext data error.
 * The user's password must be changed before logging on the first time.
 * Returns only when presented with valid user-name and password credential.
 *
 * https://docs.servicenow.com/bundle/newyork-platform-administration/page/administer/reference-pages/reference/r_LDAPErrorCodes.html
 */
class LdapUserMustResetPassword extends LdapException {
  const code = 773;
  public function __construct($message = 'Votre mot de passe est expiré. Veuillez le changer via le centre d\'identité.', $code = LdapUserMustResetPassword::code, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
  }
}
