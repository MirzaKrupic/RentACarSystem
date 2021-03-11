<?php
  require_once dirname(__FILE__)."/dao/UserDao.class.php";
  require_once dirname(__FILE__)."/dao/CompanyDao.class.php";

  $user_dao = new CompanyDao();

  $user1 = [
    "name"=> "Burch",
    "address" => "Francuske Revolucije BB",
    "mail" => "ibu@gmail.com"
  ];

  $user = $user_dao->get_all_companies();

  print_r($user);

?>
