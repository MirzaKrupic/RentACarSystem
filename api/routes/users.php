<?php

Flight::route('GET /users', function(){
  Flight::json(Flight::userdao()->get_all(0,10));
});

Flight::route('GET /users/@id', function($id){
  Flight::json(Flight::userdao()->get_by_id($id));
});

Flight::route('POST /users', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userdao()->add($data));
});

Flight::route('PUT /users/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::userdao()->update($id, $data);
  print_r(Flight::userdao()->get_by_id($id));
});

?>
