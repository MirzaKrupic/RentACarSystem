<?php
  require_once dirname(__FILE__)."/dao/UserDao.class.php";
  require_once dirname(__FILE__)."/dao/CompanyDao.class.php";
  require_once dirname(__FILE__)."/dao/BrandDao.class.php";
  require_once dirname(__FILE__)."/dao/CarDao.class.php";

  $user_dao = new CarDao();

  $user1 = [
    "model" => "A6",
    "brand_id" => "1",
    "owner_id" => "1"
  ];

  $user = $user_dao->get_car_by_owner_id(1);

  print_r($user);

?>
