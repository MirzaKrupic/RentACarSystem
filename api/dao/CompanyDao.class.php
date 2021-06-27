<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class CompanyDao extends BaseDao{

  public function __construct(){
    parent::__construct("companies");
  }

  public function get_company_by_token($token){
    return $this->query_unique("SELECT * FROM companies WHERE token = :token", ["token" => $token]);
  }

  public function get_companies($offset, $limit, $search, $order, $total=FALSE){
    list($order_column, $order_direction) = self::parse_order($order);
    if ($total){
       $query = "SELECT COUNT(*) AS total ";
     }else{
       $query = "SELECT * ";
     }
    $query .= "FROM companies ";
    if(isset($search)){
      $query .= "WHERE LOWER(name) LIKE CONCAT('%', :search, '%') ";
      $params['search'] = strtolower($search);
    }
    if ($total){
      return $this->query_unique($query, $params);
    }else{
      $query .="ORDER BY ${order_column} ${order_direction} ";
      $query .="LIMIT ${limit} OFFSET ${offset}";
      return $this->query($query, $params);
    }
  }

  public function get_company_by_email($mail){
    return $this->query_unique("SELECT * FROM companies WHERE mail = :mail", ["mail" => $mail]);
  }
}

?>
