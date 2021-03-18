<?php
require_once dirname(__FILE__)."/BaseDao.class.php";
class UserDao extends BaseDao{

  public function __construct(){
    parent::__construct("users");
  }

  public function get_users($search, $offset, $limit){
    return $this->query("SELECT * FROM users
                        WHERE LOWER(name) LIKE CONCAT('%', :name, '%')
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
