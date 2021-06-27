<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/CompanyDao.class.php';
require_once dirname(__FILE__).'/../clients/SMTPClient.class.php';

class CompanyService extends BaseService{

  protected $dao;
  private $smtpClient;

  public function __construct(){
    $this->dao = new CompanyDao();
    $this->smtpClient = new SMTPClient();
  }

  public function get_companies($id, $offset, $limit, $search, $order, $total = FALSE){
    return $this->dao->get_companies($id, $offset, $limit, $search, $order, $total);
  }

  public function login($company){
      $db_user = $this->dao->get_company_by_email($company['mail']);
      if(!isset($db_user['id'])) throw new Exception("User doesn't exist", 400);

      if($db_user['password'] != md5($company['password'])) throw new Exception("Invalid password", 400);

      if($db_user['status'] != 'ACTIVE') throw new Exception("Account is not active", 400);

      $jwt = \Firebase\JWT\JWT::encode(["exp" => (time() + Config::JWT_TOKEN_TIME), "id" => $db_user["id"],"name" => $db_user["name"] , "r" => "company"] , Config::JWT_SECRET);

      return ["token" => $jwt];
  }

  public function add($company){
    if (!isset($company['name'])) throw new Exception("Name is missing");

    try{
      $company = parent::add([
        "name" => $company['name'],
        "mail" => $company['mail'],
        "address" => $company['address'],
        "created_at" => date(Config::DATE_FORMAT),
        "token" => md5(random_bytes(16))
      ]);
    }catch(\Exception $e){
      if(strpos($e->getMessage(), 'companies.uq_mail')){
        throw new Exception("Company with same email exists in the database", 400, $e);
      }else{
        throw $e;
      }
    }
    return $company;
  }

  public function register($company){
  // validation of account data
  if (!isset($company['name'])) throw new Exception("Name is missing");

  try{

  $company = [
    "name" => $company['name'],
    "mail" => $company['mail'],
    "address" => $company['address'],
    "password" => md5($company['password']),
    "status" => "PENDING",
    "created_at" => date(Config::DATE_FORMAT),
    "token" => md5(random_bytes(16))
  ];

  parent::add($company);

}catch(\Exception $e){
  if(strpos($e->getMessage(), 'companies.uq_company_email')){
    throw new Exception("Company with same email exists in the database", 400, $e);
  }else{
    throw $e;
  }
}
  //send token
  $this->smtpClient->send_register_company_token($company);
  return $company;
  }

  public function confirm($token){
    $company = $this->dao->get_company_by_token($token);

    if(!isset($company['id'])) throw Exception("Invalid token");

    $this->dao->update($company['id'], ["status" => "ACTIVE"]);

    //send email
  }

  public function forgot($user){
    $db_user = $this->dao->get_company_by_email($user['mail']);


    if (!isset($db_user['id'])) throw new Exception("User doesn't exists", 400);

    // generate token - and save it to db
    $db_user = $this->update($db_user['id'], ['token' => md5(random_bytes(16))]);

    // send email
    $this->smtpClient->send_user_recovery_token($db_user, "company");
  }

  public function reset($user){
    $db_user = $this->dao->get_company_by_token($user['token']);

    if (!isset($db_user['id'])) throw new Exception("Invalid token", 400);

    $this->dao->update($db_user['id'], ['password' => md5($user['password']), 'token' => NULL]);
  }

}

?>
