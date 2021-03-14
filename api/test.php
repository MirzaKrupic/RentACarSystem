<?php
  require_once dirname(__FILE__)."/dao/UserDao.class.php";
  require_once dirname(__FILE__)."/dao/CompanyDao.class.php";
  require_once dirname(__FILE__)."/dao/BrandDao.class.php";
  require_once dirname(__FILE__)."/dao/CarDao.class.php";
  require_once dirname(__FILE__)."/dao/RentingDao.class.php";

  $dao = new CarDao();

  $user1 = [
    "car_id" => 1,
    "user_id" => 1,
    "rented_on_date" => "2021-03-12",
    "return_date" => "2021-03-26"
  ];

  $user = $dao->get_by_id(1);

  print_r($user);

?>
