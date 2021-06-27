<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/BrandDao.class.php';

class BrandService extends BaseService{

  protected $dao;

  public function __construct(){
    $this->dao = new BrandDao();
  }

  public function get_brands($offset, $limit, $search, $order, $total = FALSE){
    return $this->dao->get_brands($offset, $limit, $search, $order, $total);
  }

  public function add_brand($brand){
   try {
     // TODO: VALIDATION LAYER OF FIELDS

     // whitelist fields
     $data = [
       "name" => $brand["name"]
     ];
     return parent::add($data);
   } catch (\Exception $e) {
      throw new Exception($e->getMessage(), 400, $e);
   }
  }

}

?>
