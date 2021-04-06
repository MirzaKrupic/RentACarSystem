<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class CompanyDao extends BaseDao{

  public function __construct(){
    parent::__construct("companies");
  }

  public function get_company_by_token($token){
    return $this->query_unique("SELECT * FROM companies WHERE token = :token", ["token" => $token]);
  }

  public function get_companies($id, $offset, $limit, $search, $order){

    $query = "SELECT *
              FROM companies
              WHERE LOWER(name) LIKE CONCAT('%', :search, '%')" ;

            $params['search'] = strtolower($search);
    return $this->query($query, $params);
  }

  public function get_company_by_email($mail){
    return $this->query_unique("SELECT * FROM companies WHERE mail = :mail", ["mail" => $mail]);
  }
}

?>
