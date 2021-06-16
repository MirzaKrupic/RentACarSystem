<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/CarDao.class.php';

class CarService extends BaseService{

  protected $dao;

  public function __construct(){
    $this->dao = new CarDao();
  }

  public function get_cars($owner_id,$offset, $limit, $search, $order, $total = FALSE){
    return $this->dao->get_cars($owner_id, $offset, $limit, $search, $order, $total);
  }

  public function get_all_cars($offset, $limit, $order){
    return $this->dao->get_all($offset, $limit, $order);
  }

  public function get_car_by_owner_and_id($owner_id, $id){
    return $this->dao->get_car_by_owner_and_id($owner_id, $id);
  }

  public function add($car){
    $car['created_at'] = date(Config::DATE_FORMAT);
    return parent::add($car);
  }

  public function add_cars($owner, $car){
   try {
     // TODO: VALIDATION LAYER OF FIELDS

     // whitelist fields
     $data = [
       "model" => $car["model"],
       "brand_id" => $car["brand_id"],
       "owner_id" => $owner["id"],
       "created_at" => date(Config::DATE_FORMAT),
       "number_of_seats" => $car["number_of_seats"],
       "number_of_gears" => $car["number_of_gears"],
       "number_of_doors" => $car["number_of_doors"],
       "licence_plate" => $car["licence_plate"]
     ];
     return parent::add($data);
   } catch (\Exception $e) {
      throw new Exception($e->getMessage(), 400, $e);
   }
  }

  public function update_car($owner, $id, $car){
    $db_template = $this->dao->get_by_id($id);
    if ($db_template['owner_id'] != $owner['id']){
      throw new Exception("Invalid car", 403);
    }
    return $this->update($id, $car);
  }

  public function update_car_status($id){
    $db_template = $this->dao->get_by_id($id);
    if($db_template['status'] == "RENTED") $car['status'] = "FOR RENT";
    else $car['status'] = "RENTED";
    return $this->update($id, $car);
  }

}
?>
