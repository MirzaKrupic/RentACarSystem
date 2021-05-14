<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class CarDao extends BaseDao{

  public function __construct(){
    parent::__construct("cars");
  }

  public function get_cars($owner_id, $offset, $limit, $search, $order){
    list($order_column, $order_direction) = self::parse_order($order);
    $params = ["owner_id" => $owner_id];
    $query = "SELECT *
              FROM cars
              WHERE owner_id = :owner_id ";
    if(isset($search)){
        $query .= "AND LOWER(model) LIKE CONCAT('%', :search, '%') ";
        $params['search'] = strtolower($search);
    }
    $query .= "ORDER BY ${order_column} ${order_direction} ";
    $query .= "LIMIT ${limit} OFFSET ${offset}";
    return $this->query($query, $params);
  }

  public function get_car_by_owner_and_id($owner_id, $id){
    return $this->query_unique("SELECT * FROM cars WHERE owner_id = :owner_id AND id = :id", ["owner_id" => $owner_id, "id" => $id]);
  }
}
?>
