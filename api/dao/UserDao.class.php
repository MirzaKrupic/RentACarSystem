<?php
require_once dirname(__FILE__)."/BaseDao.class.php";
class UserDao extends BaseDao{

  public function __construct(){
    parent::__construct("users");
  }

  public function get_users($search, $offset, $limit, $order ="-id"){
    switch(substr($order, 0, 1)){
      case '-': $order_direction = "ASC"; break;
      case '+': $order_direction = "DESC"; break;
      default: throw new Exception("Invalid order format. First character should be either + or -"); break;
    };

    $order_column =  substr($order,1);

    //     $order_column = $this->connection->quote(substr($order,1));

    return $this->query("SELECT * FROM users
                        WHERE LOWER(name) LIKE CONCAT('%', :name, '%')
                        ORDER BY ${order_column} ${order_direction}
                        LIMIT ${limit} OFFSET ${offset}", ["name" => strtolower($search)]);
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
}
?>
