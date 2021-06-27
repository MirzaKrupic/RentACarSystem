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

  public function get_rent_by_user_id($id){
    return $this->dao->get_rent_by_user_id($id);
  }

  public function cron_renting($date){
    $date = date(Config::DATE_FORMAT);
    return $this->dao->cron_renting($date);
  }

  public function get_rentings($user_id,$offset, $limit, $search, $order, $total = FALSE){
    return $this->dao->get_rentings($user_id, $offset, $limit, $search, $order, $total);
  }

  public function add_renting($user, $renting){

    $param = [
      "user_id" => $user,
      "car_id"=> $renting['car_id'],
      "rented_on_date"=> date(Config::DATE_FORMAT),
      "return_date"=> $renting['return_date']
    ];


    return $this->dao->add($param);
  }

}

?>
