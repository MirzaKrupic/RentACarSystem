<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/UserDao.class.php';
require_once dirname(__FILE__).'/../clients/SMTPClient.class.php';


class UserService extends BaseService{

  protected $dao;
  private $smtpClient;

  public function __construct(){
    $this->dao = new UserDao();
    $this->smtpClient = new SMTPClient();
  }

  public function reset($user){
  $db_user = $this->dao->get_user_by_token($user['token']);

  if (!isset($db_user['id'])) throw new Exception("Invalid token", 400);

  $this->dao->update($db_user['id'], ['password' => md5($user['password']), 'token' => NULL]);
}

  public function get_users($search, $offset, $limit, $order, $total = FALSE){
      return $this->dao->get_users($search, $offset, $limit, $order, $total);
  }

  public function forgot($user){
    $db_user = $this->dao->get_user_by_email($user['mail']);


    if (!isset($db_user['id'])) throw new Exception("User doesn't exists", 400);

    // generate token - and save it to db
    $db_user = $this->update($db_user['id'], ['token' => md5(random_bytes(16))]);

    // send email
    $this->smtpClient->send_user_recovery_token($db_user, "user");
  }

  public function login($user){
    $db_user = $this->dao->get_user_by_email($user['mail']);
    if(!isset($db_user['id'])) throw new Exception("User doesn't exist", 400);

    if($db_user['status'] != 'ACTIVE') throw new Exception("Account is not active", 400);

    if($db_user['password'] != md5($user['password'])) throw new Exception("Invalid password", 400);

    $jwt = \Firebase\JWT\JWT::encode(["exp" => (time() + Config::JWT_TOKEN_TIME),"id" => $db_user["id"] ,"name" => $db_user["name"] , "r" => $db_user["role"]], Config::JWT_SECRET);
    return ["token" => $jwt];
  }

  public function register($user){
  // validation of account data
  if (!isset($user['name'])) throw new Exception("Name is missing");

  try{

  $user = [
    "name" => $user['name'],
    "mail" => $user['mail'],
    "address" => $user['address'],
    "password" => md5($user['password']),
    "status" => "PENDING",
    "role" => "USER",
    "created_at" => date(Config::DATE_FORMAT),
    "token" => md5(random_bytes(16))
  ];

  parent::add($user);

}catch(\Exception $e){
  if(strpos($e->getMessage(), 'users.uq_user_email')){
    throw new Exception("Account with same email exists in the database", 400, $e);
  }else{
    throw $e;
  }
}
  //send token
  $this->smtpClient->send_register_user_token($user);
  return $user;
  }



  public function add($user){
  // validation of account data
  if (!isset($user['name'])) throw new Exception("Name is missing");
  if (!isset($user['mail'])) throw new Exception("Mail is missing");
  if (!isset($user['password'])) throw new Exception("Password is missing");
  $user['created_at'] = date(Config::DATE_FORMAT);
  $user['token'] = md5(random_bytes(16));
  return parent::add($user);
}

public function confirm($token){
  $user = $this->dao->get_user_by_token($token);

  if(!isset($user['id'])) throw Exception("Invalid token");

  $this->dao->update($user['id'], ["status" => "ACTIVE"]);

  //send email
}
}
?>
