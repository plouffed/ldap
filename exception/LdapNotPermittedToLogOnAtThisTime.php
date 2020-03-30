<?php namespace plouffed\ldap\exception;

use Throwable;

/**
 * 49 / 530 -	NOT_PERMITTED_TO_LOGON_AT_THIS_TIME
 *
 * Indicates an Active Directory (AD) AcceptSecurityContext data error that is logon failure
 * caused because the user is not permitted to log on at this time.
 * Returns only when presented with a valid username and valid password credential.
 *
 * https://docs.servicenow.com/bundle/newyork-platform-administration/page/administer/reference-pages/reference/r_LDAPErrorCodes.html
 */
class LdapNotPermittedToLogOnAtThisTime extends LdapException {
  const code = 530;
  public function __construct($message = 'Vous n\'avez pas les droits d\'accès en ce moment. Veuillez contacter votre technicien informatique.', $code = LdapNotPermittedToLogOnAtThisTime::code, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
  }
}
