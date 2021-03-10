<?php
  require_once dirname(__FILE__)."/dao/UserDao.class.php";

  $user_dao = new UserDao();

  $user1 = [
    "first_name" => "Nedim",
    "last_name" => "Bandzovic",
    "mail" => "nedim.bandzovic@gmail.com",
    "dob" => "2000-01-19",
    "password" => "malcolmduerod"
  ];
  $user = $user_dao->add_user($user1);
  print_r($user);
?>
