<?php
  require_once dirname(__FILE__)."/dao/UserDao.class.php";

  $user_dao = new UserDao();

  $user1 = [
    "first_name" => "Nedim",
    "last_name" => "Bandzovic",
    "mail" => "bandzovic.nedim@gmail.com",
    "dob" => "2000-01-19",
    "password" => "malcolmduerod"
  ];
  $user = $user_dao->update_user(3, $user1);
  print_r($user);
?>
