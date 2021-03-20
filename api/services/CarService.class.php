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
    $car['token'] = md5(random_bytes(16));
    return parent::add($car);
  }

  public function confirm($token){
    $company = $this->dao->get_company_by_token($token);

    if(!isset($company['id'])) throw Exception("Invalid token");

    $this->dao->update($company['id'], ["status" => "ACTIVE"]);

    //send email
  }

}
?>
