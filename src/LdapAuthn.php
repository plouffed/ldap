<?php namespace plouffed\ldap;

class LdapAuthn extends LdapBase {

  public function authenticate($user, $password) {
    $this->validateUser($user);
    $this->validatePassword($password);
    $this->tryBind($user, $password);
    return $this->getUser($user);
  }

}