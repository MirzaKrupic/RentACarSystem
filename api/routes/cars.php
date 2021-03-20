<?php

Flight::route('GET /cars', function(){
  $owner_id = Flight::query('owner_id');
  $limit = Flight::query('limit', 10);
  $offset = Flight::query('offset', 0);
  $search = Flight::query('search');

  Flight::json(Flight::carservice()->get_cars($owner_id, $offset, $limit, $search));
});

Flight::route('POST /cars', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::carservice()->add($data));
});


?>
