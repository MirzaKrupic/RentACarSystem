<?php
require_once dirname(__FILE__)."/BaseDao.class.php";

class CompanyDao extends BaseDao{

  public function add_company($company){
    $this->insert("companies", $company);
  }

  public function update_company($id, $company){
    $this->update("companies", $id, $company);
  }

  public function get_company_by_id($id){
    return $this->query_unique("SELECT * FROM companies WHERE id = :id", ["id" => $id]);
  }

  public function get_all_companies(){
    return $this->query("SELECT * FROM companies", []);
  }
}

?>
