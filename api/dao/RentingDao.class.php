<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class RentingDao extends BaseDao{

  public function __construct(){
    parent::__construct("rentings");
  }

  public function get_rent_by_rent_date($date){
    return $this->query("SELECT * FROM rentings WHERE rented_on_date = :rdate", ["rdate" => $date]);
  }

  public function get_rent_by_user_id($user_id){
    return $this->query("SELECT * FROM rentings WHERE user_id = :user_id", ["user_id" => $user_id]);
  }

  public function get_rent_by_return_date($date){
    return $this->query("SELECT * FROM rentings WHERE return_date = :rdate", ["rdate" => $date]);
  }

  public function cron_renting($date){
    return $this->query("UPDATE rentings r, cars c SET r.status = 'DONE', c.status = 'FOR RENT' WHERE r.return_date <= :rdate AND c.id = r.car_id", ["rdate" => $date]);
  }

  public function get_rentings($user_id, $offset, $limit, $search, $order, $total=FALSE){
    list($order_column, $order_direction) = self::parse_order($order);
    $params = ["user_id" => $user_id];
    if ($total){
       $query = "SELECT COUNT(*) AS total ";
     }else{
       $query = "SELECT r.*, c.model as model ";
     }
    $query .= "FROM rentings r, cars c
               WHERE user_id = :user_id AND r.car_id=c.id ";
    if(isset($search)){
      $query .= "AND LOWER(model) LIKE CONCAT('%', :search, '%') ";
      $params['search'] = strtolower($search);
    }
    if ($total){
       return $this->query_unique($query, $params);
     }else{
      $query .="ORDER BY ${order_column} ${order_direction} ";
      $query .="LIMIT ${limit} OFFSET ${offset}";

      return $this->query($query, $params);
     }
  }

  public function get_chart_all(){
    $no = 1;
    return $this->query("SELECT DATE_FORMAT(rented_on_date, '%Y-%m-%d') dat, COUNT(*) cn FROM rentings GROUP BY DATE_FORMAT(rented_on_date, '%Y-%m-%d')", ["no" => $no]);
  }
}
?>
