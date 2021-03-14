<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class RentingDao extends BaseDao{

  public function __construct(){
    parent::__construct("rentings");
  }

  public function get_rent_by_rent_date($date){
    return $this->query("SELECT * FROM rentings WHERE rented_on_date = :rdate", ["rdate" => $date]);
  }

  public function get_rent_by_return_date($date){
    return $this->query("SELECT * FROM rentings WHERE return_date = :rdate", ["rdate" => $date]);
  }
}
?>
