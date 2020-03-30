<?php namespace plouffed\ldap;

use plouffed\ldap\exception\LdapAccountDisabled;
use plouffed\ldap\exception\LdapAccountExpired;
use plouffed\ldap\exception\LdapConnectionFailed;
use plouffed\ldap\exception\LdapException;
use plouffed\ldap\exception\LdapInvalidCredentials;
use plouffed\ldap\exception\LdapInvalidPassword;
use plouffed\ldap\exception\LdapInvalidUserName;
use plouffed\ldap\exception\LdapNotPermittedToLogOnAtThisTime;
use plouffed\ldap\exception\LdapPasswordExpired;
use plouffed\ldap\exception\LdapUserMustResetPassword;

class LdapBase {

  private static $userAttributes =  ["samaccountname","givenname","sn","employeenumber","mail","department","st","title","memberof"];
  protected $config;
  protected $conn;

  public function __construct($config) {
    if(is_string($config)) $this->config = json_decode(file_get_contents($config), true);
    else $this->config = $config;
    $this->tryConnect();
    $this->setOptions();
  }

  public function __destruct() {
    @ldap_close($this->conn);
  }

  protected function tryConnect() {
    $host = $this->config['protocol'].'://'.$this->config['server'];
    $this->conn = @ldap_connect($host, $this->config['port']);
    if(!$this->conn)
      throw new LdapConnectionFailed();
  }

  protected function tryBind($user, $password) {
    $rdn = $user.'@'.$this->config['server'];
    $r = @ldap_bind($this->conn, $rdn, $password);
    if(!$r) $this->throwInvalidCredentialError();
  }

  protected function setOptions() {
    @ldap_set_option($this->conn, LDAP_OPT_PROTOCOL_VERSION, 3);
    @ldap_set_option($this->conn, LDAP_OPT_REFERRALS, 0);
  }

  protected function validateUser($user) {
    $isValid = preg_match('/\A[a-z0-9_]{3,}\Z/ui', $user);
    if(!$isValid)
      throw new LdapInvalidUserName();
  }

  protected function validatePassword($password) {
    if(mb_strlen($password) < 7)
      throw new LdapInvalidPassword();
  }


  public function getUser($user) {
    $result = @ldap_search($this->conn, $this->config['domain'], "samaccountname=".ldap_escape($user,'',LDAP_ESCAPE_FILTER), self::$userAttributes);
    $result = @ldap_get_entries($this->conn, $result);
    return $this->makeLdapUser($this->formatAttributes($result, self::$userAttributes)[0]);
  }

  private function makeLdapUser($attributes) {
    $user = new LdapUser();
    $user->matricule = $attributes['employeenumber']??'';
    $user->firstname = $attributes['givenname'];
    $user->lastname = $attributes['sn'];
    $user->username = $attributes['samaccountname'];
    $user->title = $attributes['title']??'';
    $user->department = $attributes['department']??'';
    $user->email = $attributes['mail'];
    $user->groups = $attributes['memberof']??[];
    return $user;
  }

  public function formatAttributes($result, $attributes) {
    $N = $result['count'];
    $J = count($attributes);
    $formattedResult = [];
    for ($n = 0; $n < $N; $n++) {
      $formatted = [];
      for ($j = 0; $j < $J; $j++) {
        $attribute = $attributes[$j];
        if (($result[$n][$attribute]['count']??1) === 1) {
          $formatted[$attribute] = $result[$n][$attribute][0] ?? '';
        } else {
          $formatted[$attribute] = $this->extractGroups($result[$n][$attribute]);
        }
      }
      $formattedResult[] = $formatted;
    }
    return $formattedResult;
  }

  private function extractGroups($ldapGroupArray) {
    $N = $ldapGroupArray['count'];
    $extractedGroups = [];
    for($i=0; $i<$N; $i++) {
      $cn = $ldapGroupArray[$i];
      $extractedGroups[$i] = mb_strtolower(substr($cn, 3, strpos($cn,',OU')-3));
    }
    return $extractedGroups;
  }

  protected function throwInvalidCredentialError() {
    switch ($this->getErrorCode()) {
      case LdapAccountDisabled::code: throw new LdapAccountDisabled();
      case LdapAccountExpired::code: throw new LdapAccountExpired();
      case LdapInvalidPassword::code: throw new LdapInvalidPassword();
      case LdapInvalidUserName::code: throw new LdapInvalidUserName();
      case LdapNotPermittedToLogOnAtThisTime::code: throw new LdapNotPermittedToLogOnAtThisTime();
      case LdapPasswordExpired::code: throw new LdapPasswordExpired();
      case LdapUserMustResetPassword::code: throw new LdapUserMustResetPassword();
    }
    throw new LdapInvalidCredentials();
  }

  protected function getErrorCode() {
    $errorMsg = $this->getErrorMessage();
    if($errorMsg) {
      $regex = '/AcceptSecurityContext error, data (.*?),/m';
      preg_match_all($regex, $errorMsg, $matches, PREG_SET_ORDER, 0);
      return $matches[0][1];
    }
    return 0;
  }

  protected function getErrorMessage() {
    @ldap_get_option($this->conn, LDAP_OPT_DIAGNOSTIC_MESSAGE, $errorMsg);
    return $errorMsg;
  }

  protected function throwLdapError() {
    $errorCode = ldap_errno($this->conn);
    if($errorCode !== 0) {
      throw new LdapException($this->getErrorMessage(), $errorCode);
    }
  }

}
