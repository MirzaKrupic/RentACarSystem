<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/CarDao.class.php';

class CarService extends BaseService{

  protected $dao;

  public function __construct(){
    $this->dao = new CarDao();
  }

  public function get_cars($owner_id, $offset, $limit, $search, $order){
    return $this->dao->get_cars($owner_id, $offset, $limit, $search, $order);
  }

  public function add($car){
    $car['created_at'] = date(Config::DATE_FORMAT);
    return parent::add($car);
  }

}
?>
