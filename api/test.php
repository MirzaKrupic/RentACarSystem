<?php
  require_once dirname(__FILE__)."/dao/UserDao.class.php";

  $user_dao = new UserDao();

  $user1 = [
    "first_name" => "Nedim",
    "last_name" => "Bandzovic",
    "password" => "malco"
  ];

  $user = $user_dao->update_user(3, $user1);
  
?>
