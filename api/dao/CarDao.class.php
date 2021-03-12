<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class CarDao extends BaseDao{

  public function add_car($car){
    $this->insert("cars", $car);
  }

  public function update_car($id, $car){
    $this->update("cars", $id, $car);
  }

  public function get_car_by_id($id){
    return $this->query_unique("SELECT * FROM cars WHERE id = :id", ["id" => $id]);
  }

  public function get_car_by_brand_id($id){
    return $this->query("SELECT * FROM cars WHERE brand_id = :id", ["id" => $id]);
  }

  public function get_car_by_owner_id($id){
    return $this->query("SELECT * FROM cars WHERE owner_id = :id", ["id" => $id]);
  }

  public function get_all_cars(){
    return $this->query("SELECT * FROM cars", []);
  }
}
?>
