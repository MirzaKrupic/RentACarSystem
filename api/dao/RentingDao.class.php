<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class RentingDao extends BaseDao{

  public function add_renting($rent){
    $this->insert("rentings", $rent);
  }

  public function get_rent_by_id($id){
    return $this->query_unique("SELECT * FROM rentings WHERE id = :id", ["id" => $id]);
  }

  public function get_rent_by_car_id($id){
    return $this->query("SELECT * FROM rentings WHERE car_id = :id", ["id" => $id]);
  }

  public function get_rent_by_user_id($id){
    return $this->query("SELECT * FROM rentings WHERE user_id = :id", ["id" => $id]);
  }

  public function get_rent_by_rent_date($date){
    return $this->query("SELECT * FROM rentings WHERE rented_on_date = :rdate", ["rdate" => $date]);
  }

  public function get_rent_by_return_date($date){
    return $this->query("SELECT * FROM rentings WHERE return_date = :rdate", ["rdate" => $date]);
  }

  public function get_all_rentings(){
    return $this->query("SELECT * FROM rentings", []);
  }
}
?>
