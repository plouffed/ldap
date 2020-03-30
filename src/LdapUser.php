<?php namespace plouffed\ldap;

class LdapUser {

  public $matricule;
  public $username;
  public $firstname;
  public $lastname;
  public $email;
  public $department;
  public $title;
  public $groups;

  function getFullName() {
    return $this->firstname.' '.$this->lastname;
  }
}
