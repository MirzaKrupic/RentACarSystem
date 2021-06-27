<?php
require_once dirname(__FILE__)."/BaseDao.class.php";
class UserDao extends BaseDao{

  public function __construct(){
    parent::__construct("users");
  }

  public function get_users($offset, $limit, $search = "aaa", $order, $total = FALSE){
    list($order_column, $order_direction) = self::parse_order($order);
    if ($total){
       $query = "SELECT COUNT(*) AS total ";
     }else{
       $query = "SELECT * ";
     }
    $query .= "FROM users ";
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

  public function get_user_by_email($mail){
    return $this->query_unique("SELECT * FROM users WHERE mail = :mail", ["mail" => $mail]);
  }

  public function update_user_by_email($mail, $user){
    $this->update("users", $mail, $user, "mail");
  }

  public function get_user_by_token($token){
    return $this->query_unique("SELECT * FROM users WHERE token = :token", ["token" => $token]);
  }

  public function get_user_by_id($id){
    return $this->get_by_id($id);
  }
}
?>
