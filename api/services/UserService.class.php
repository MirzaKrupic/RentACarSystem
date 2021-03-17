<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/UserDao.class.php';

class UserService extends BaseService{

  protected $dao;

  public function __construct(){
    $this->dao = new UserDao();
  }

  public function get_users($search, $offset, $limit){
    if($search){
      return ($this->dao->get_users($search, $offset, $limit));
    }else{
      return ($this->dao->get_all($offset, $limit));
    }
  }

  public function add($user){
  // validation of account data
  if (!isset($user['name'])) throw new Exception("Name is missing");
  return parent::add($user);
  }
}
?>
