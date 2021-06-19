<?php
require_once dirname(__FILE__)."/dao/BaseDao.class.php";

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(__FILE__).'/services/UserService.class.php';
require_once dirname(__FILE__).'/services/CarService.class.php';
require_once dirname(__FILE__).'/services/CompanyService.class.php';
require_once dirname(__FILE__).'/services/BrandService.class.php';
require_once dirname(__FILE__).'/services/RentingService.class.php';

use \Firebase\JWT\JWT;

/*/Error handling for API
Flight::map('error', function(Exception $ex){
  Flight::json(["message" => $ex->getMessage()], $ex->getCode());
});*/

Flight::map('query', function($name, $default_value = NULL){
    $request = Flight::request();

    $query_param = @$request->query->getData()[$name];
    $query_param = $query_param ? $query_param : $default_value;
    return urldecode($query_param);
});

/* utility function for getting header parameters */
Flight::map('header', function($name){
  $headers = getallheaders();
  return @$headers[$name];
});

Flight::route('GET /swagger', function(){
  $openapi = @\OpenApi\scan(dirname(__FILE__).'/routes');
  header('Content-Type: application/json');
  echo $openapi->toJson();
});

Flight::route('GET /', function(){
  Flight::redirect('/docs/index.php');
});


Flight::register('userservice', 'UserService');
Flight::register('carservice', 'CarService');
Flight::register('companyservice', 'CompanyService');
Flight::register('brandservice', 'BrandService');
Flight::register('rentingservice', 'RentingService');


require_once dirname(__FILE__).'/routes/middleware.php';
require_once dirname(__FILE__).'/routes/users.php';
require_once dirname(__FILE__).'/routes/cars.php';
require_once dirname(__FILE__).'/routes/companies.php';
require_once dirname(__FILE__).'/routes/brands.php';
require_once dirname(__FILE__).'/routes/rentings.php';


Flight::start();
?>
