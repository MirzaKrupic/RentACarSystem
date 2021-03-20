<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/CompanyDao.class.php';

class CompanyService extends BaseService{

  protected $dao;

  public function __construct(){
    $this->dao = new CompanyDao();
  }

  public function get_companies($id, $offset, $limit, $search, $order){
    return $this->dao->get_companies($id, $offset, $limit, $search, $order);
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

  public function confirm($token){
    $company = $this->dao->get_company_by_token($token);

    if(!isset($company['id'])) throw Exception("Invalid token");

    $this->dao->update($company['id'], ["status" => "ACTIVE"]);

    //send email
  }

}

?>
