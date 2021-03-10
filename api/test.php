<?php
  require_once dirname(__FILE__)."/dao/UserDao.class.php";

  $user_dao = new UserDao();

  $user1 = [
    "password" => "password123"
  ];

  $user = $user_dao->update_user_by_email("bandzovic.nedim@gmail.com", $user1);

?>
