<?php
  require_once dirname(__FILE__)."/dao/UserDao.class.php";

  $user_dao = new UserDao();

  $user1 = [
    "password" => "password123",
    "first_name" => "Naida",
    "last_name" => "Fatic",
    "mail" => "naida.fatic@gmail.com",
    "dob" => "2000-03-23"
  ];

  $user = $user_dao->add_user($user1);

  print_r($user);

?>
