<?php
  require_once dirname(__FILE__)."/dao/UserDao.class.php";
  require_once dirname(__FILE__)."/dao/CompanyDao.class.php";
    require_once dirname(__FILE__)."/dao/BrandDao.class.php";

  $user_dao = new BrandDao();

  $user1 = [
    "name"=> "Audi"
  ];

  $user = $user_dao->get_all_brands();

  print_r($user);

?>
