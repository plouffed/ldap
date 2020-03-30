<?php namespace plouffed\ldap;

class LdapSearch extends LdapBase {

  public function __construct($config) {
    parent::__construct($config);
    $this->validateUser($this->config['user']);
    $this->validatePassword($this->config['password']);
    $this->tryBind($this->config['user'], $this->config['password']);
  }

  public function search($dn, $query, $attributes) {
    $result = @ldap_search($this->conn, $dn, $query, $attributes);
    if($result===false) $this->throwLdapError();
    $result = @ldap_get_entries($this->conn, $result);
    return $this->formatAttributes($result, $attributes);
  }

  public function searchUser($user, $attributes) {
    if(empty($user)) return ['count'=>0];
    $user =  ldap_escape($user,'',LDAP_ESCAPE_FILTER);
    $query =  '(|'
      .'(&(objectCategory=User)(cn=*'.$user.'*))'
      .'(&(objectCategory=User)(samaccountname=*'.$user.'*))'
      .'(&(objectCategory=User)(employeeID='.$user.'*))'
      .')';
    return $this->search($this->config['domain'], $query, $attributes);
  }

  public function searchEmployes($user, $attributes) {
    if(empty($user)) return ['count'=>0];
    $user =  ldap_escape($user,'',LDAP_ESCAPE_FILTER);
    $query =  '(|'
      .'(&(objectCategory=User)(cn=*'.$user.'*))'
      .'(&(objectCategory=User)(samaccountname=*'.$user.'*))'
      .'(&(objectCategory=User)(employeeID='.$user.'*))'
      .')';
    return $this->search('OU=EMPLOYES,'.$this->config['domain'], $query, $attributes);
  }

  public function fetchDistributionMembers($distribution, $attributes) {
    if(empty($distribution)) return ['count'=>0];
    $distribution =  ldap_escape($distribution,'',LDAP_ESCAPE_FILTER);
    $query = '(&'
      .'(objectCategory=User)'
      .'(memberOf:1.2.840.113556.1.4.1941:=cn='.$distribution.',ou=Groupes de distribution,dc=vd,dc=cerfs)'
      .')';
    return $this->search($this->config['domain'], $query, $attributes);
  }

}
