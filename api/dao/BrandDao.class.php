<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class BrandDao extends BaseDao{

  public function add_brand($brand){
    $this->insert("brands", $brand);
  }

  public function update_brand($id, $brand){
    $this->update("brands", $id, $brand);
  }

  public function get_brand_by_id($id){
    return $this->query_unique("SELECT * FROM brands WHERE id = :id", ["id" => $id]);
  }

  public function get_all_brands(){
    return $this->query("SELECT * FROM brands", []);
  }
}

?>
