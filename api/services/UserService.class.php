<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/UserDao.class.php';

class UserService extends BaseService{

  protected $dao;

  public function __construct(){
    $this->dao = new UserDao();
  }

  public function get_users($search, $offset, $limit, $order){
    if($search){
      return $this->dao->get_users($search, $offset, $limit, $order);
    }else{
      return $this->dao->get_all($offset, $limit, $order);
    }
  }

  public function register($user){
  // validation of account data
  if (!isset($user['name'])) throw new Exception("Name is missing");

  try{

  $user = parent::add([
    "name" => $user['name'],
    "mail" => $user['mail'],
    "dob" => $user['dob'],
    "password" => $user['password'],
    "status" => "PENDING",
    "role" => "USER",
    "created_at" => date(Config::DATE_FORMAT),
    "token" => md5(random_bytes(16))
  ]);

}catch(\Exception $e){
  if(strpos($e->getMessage(), 'users.uq_user_email')){
    throw new Exception("Account with same email exists in the database", 400, $e);
  }else{
    throw $e;
  }
}
  //send token

  return $user;
  }

  public function confirm($token){
    $user = $this->dao->get_user_by_token($token);

    if(!isset($user['id'])) throw Exception("Invalid token");

    $this->dao->update($user['id'], ["status" => "ACTIVE"]);

    //send email
  }
}
?>
