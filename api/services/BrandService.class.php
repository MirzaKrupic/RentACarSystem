<?php

require_once dirname(__FILE__).'/BaseService.class.php';
require_once dirname(__FILE__).'/../dao/BrandDao.class.php';

class BrandService extends BaseService{

  protected $dao;

  public function __construct(){
    $this->dao = new BrandDao();
  }

  public function get_all_brands($offset, $limit, $order){
    return $this->dao->get_all($offset, $limit, $order);
  }

}

?>
