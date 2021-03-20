<?php


Flight::route('POST /cars', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::carservice()->add($data));
});


?>
