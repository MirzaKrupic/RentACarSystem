<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/RentingDao.class.php';

class RentingService extends BaseService{

  protected $dao;

  public function __construct(){
    $this->dao = new RentingDao();
  }

  public function get_all_rentings($offset, $limit, $order){
    return $this->dao->get_all($offset, $limit, $order);
  }

  public function add_renting($user, $renting){

    $param = [
      "user_id" => $user,
      "car_id"=> "33",
      "rented_on_date"=> date(Config::DATE_FORMAT),
      "return_date"=> $renting['return_date']
    ];


    return $this->dao->add($param);
  }

}

?>
