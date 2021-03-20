<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class CarDao extends BaseDao{

  public function __construct(){
    parent::__construct("cars");
  }

  public function get_cars($owner_id, $offset, $limit, $search){
    $params = ["owner_id" => $owner_id];
    $query = "SELECT *
              FROM cars
              WHERE owner_id = :owner_id ";
    if(isset($search)){
        $query .= "AND LOWER(model) LIKE CONCAT('%', :search, '%') ";
        $params['search'] = strtolower($search);
    }
    $query .= "LIMIT ${limit} OFFSET ${offset}";
    return $this->query($query, $params);
  }
}
?>
