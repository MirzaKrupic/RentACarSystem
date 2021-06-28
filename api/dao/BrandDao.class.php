<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class BrandDao extends BaseDao{

    public function __construct(){
      parent::__construct("brands");
    }

    public function get_brands($offset, $limit, $search, $order, $total=FALSE){
      list($order_column, $order_direction) = self::parse_order($order);
      if ($total){
         $query = "SELECT COUNT(*) AS total ";
       }else{
         $query = "SELECT * ";
       }
      $query .= "FROM brands ";
      if(isset($search)){
        $query .= "WHERE LOWER(name) LIKE CONCAT('%', :search, '%') ";
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

    public function get_chart_brand(){
      return $this->query("SELECT b.name label, COUNT(c.brand_id) value FROM brands b, cars c WHERE b.id = c.brand_id GROUP BY b.name", null);
    }
}

?>
