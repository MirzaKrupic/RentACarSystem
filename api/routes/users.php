<?php
Flight::route('GET /users', function(){

  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 10);

  $search = Flight::query('search');

  Flight::json(Flight::userservice()->get_users($search, $offset, $limit));
});

Flight::route('GET /users/@id', function($id){
  Flight::json(Flight::userservice()->get_by_id($id));
});

Flight::route('POST /users/register', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userservice()->register($data));
});

Flight::route('GET /users/confirm/@token', function($token){
  Flight::userservice()->confirm($token);
  Flight::json(["message" => "Your account has been activated."]);
});

Flight::route('PUT /users/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userservice()->update($id, $data));
});

?>
