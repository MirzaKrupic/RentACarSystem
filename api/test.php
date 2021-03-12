<?php
  require_once dirname(__FILE__)."/dao/UserDao.class.php";
  require_once dirname(__FILE__)."/dao/CompanyDao.class.php";
  require_once dirname(__FILE__)."/dao/BrandDao.class.php";
  require_once dirname(__FILE__)."/dao/CarDao.class.php";
  require_once dirname(__FILE__)."/dao/RentingDao.class.php";

  $user_dao = new RentingDao();

  $user1 = [
    "car_id" => 1,
    "user_id" => 1,
    "rented_on_date" => "2021-03-12",
    "return_date" => "2021-03-26"
  ];

  $user = $user_dao->get_rent_by_return_date("2021-03-26");

  print_r($user);

?>
