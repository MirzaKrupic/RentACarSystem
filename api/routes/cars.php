<?php

/**
 * @OA\Get(path="/companies/cars", tags={"companies", "cars"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for cars. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List cars for company")
 * )
 */
Flight::route('GET /companies/cars', function(){
  $account_id = Flight::get('company')['id'];
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', '-id');

  $total = Flight::carService()->get_cars($account_id, $offset, $limit, $search, $order, TRUE);
  header('total-records: ' . $total['total']);

  Flight::json(Flight::carService()->get_cars($account_id, $offset, $limit, $search, $order));
});

/**
 * @OA\Get(path="/cars/all", tags={"cars"},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List all cars from database")
 * )
 */
Flight::route('GET /cars/all', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $order = Flight::query('order', '-id');

  Flight::json(Flight::carService()->get_all_cars($offset, $limit, $order));
});

/**
 * @OA\Get(path="/companies/cars/{id}", tags={"companies", "cars"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", name="id", default=1, description="Id of a car"),
 *     @OA\Response(response="200", description="Fetch individual car from company by ID")
 * )
 */
Flight::route('GET /companies/cars/@id', function($id){
  /*$template = Flight::emailTemplateService()->get_by_id($id);
  if ($template['account_id'] != Flight::get('user')['aid']){
    Flight::json([]);
  }else{
    Flight::json($template);
  }*/
  Flight::json(Flight::carService()->get_car_by_owner_and_id(Flight::get('company')['id'], $id));
});

/**
 * @OA\Get(path="/cars/{id}", tags={"cars"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", name="id", default=9, description="Id of a car"),
 *     @OA\Response(response="200", description="Fetch cars by ID")
 * )
 */
Flight::route('GET /cars/@id', function($id){
  Flight::json(Flight::carService()->get_car_by_id($id));
});

/**
 * @OA\Post(path="/companies/cars/add", tags={"companies", "cars"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic company info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="model", required="true", type="string", example="gold",	description="Car's model" ),
 *             @OA\Property(property="brand_id", required="true", type="integer", example="1",	description="ID of car's brand" ),
 *    				 @OA\Property(property="number_of_seats", required="true", type="integer", example="4",	description="Number of seats in a car" ),
 *    				 @OA\Property(property="number_of_gears", required="true", type="integer", example="4",	description="Number of gears in a car" ),
 *    				 @OA\Property(property="number_of_doors", required="true", type="integer", example="4",	description="Number of doors on a car" ),
 *    				 @OA\Property(property="licence_plate", required="true", type="string", example="xxx-xxx-xxx",	description="Licence plate of car" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Car added")
 * )
 */

Flight::route('POST /companies/cars/add', function(){
  Flight::json(Flight::carService()->add_cars(Flight::get('company'), Flight::request()->data->getData()));
});

/**
 * @OA\Put(path="/companies/cars/{id}", tags={"companies", "cars"}, security={{"ApiKeyAuth": {}}},
 *   @OA\Parameter(type="integer", in="path", name="id", default=1),
 *   @OA\RequestBody(description="Basic emiail template info that is going to be updated", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="model", required="true", type="string", example="gold",	description="Car's model" ),
 *             @OA\Property(property="brand_id", required="true", type="integer", example="1",	description="ID of car's brand" ),
 *    				 @OA\Property(property="number_of_seats", required="true", type="integer", example="4",	description="Number of seats in a car" ),
 *    				 @OA\Property(property="number_of_gears", required="true", type="integer", example="4",	description="Number of gears in a car" ),
 *    				 @OA\Property(property="number_of_doors", required="true", type="integer", example="4",	description="Number of doors on a car" ),
 *    				 @OA\Property(property="licence_plate", required="true", type="string", example="xxx-xxx-xxx",	description="Licence plate of car" )
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Car updated")
 * )
 */

Flight::route('PUT /companies/cars/@id', function($id){
  Flight::json(Flight::carService()->update_car(Flight::get('company'), intval($id), Flight::request()->data->getData()));
});

?>
