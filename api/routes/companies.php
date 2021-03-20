<?php

Flight::route('GET /companies', function(){
  $id = Flight::query('id');
  $limit = Flight::query('limit', 10);
  $offset = Flight::query('offset', 0);
  $search = Flight::query('search');
  $order = Flight::query('order', '-id');

  Flight::json(Flight::companyservice()->get_companies($id, $offset, $limit, $search, $order));
});

Flight::route('POST /companies', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::companyservice()->add($data));
});

Flight::route('GET /companies/confirm/@token', function($token){
  Flight::companyservice()->confirm($token);
  Flight::json(["message" => "Your account has been activated."]);
});

?>
