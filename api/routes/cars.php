<?php

/**
 * @OA\Get(
 *     path="/users", tags={"cars"},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for accounts. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="NOT FINISHED")
 * )
 */

Flight::route('GET /cars', function(){
  $owner_id = Flight::query('owner_id');
  $limit = Flight::query('limit', 10);
  $offset = Flight::query('offset', 0);
  $search = Flight::query('search');
  $order = Flight::query('order', '-id');

  Flight::json(Flight::carservice()->get_cars($owner_id, $offset, $limit, $search, $order));
});

/**
 * @OA\Post(path="/cars", tags={"cars"},
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="model", required="true", type="string", example="My name",	description="Car model" ),
 *    				 @OA\Property(property="brand_id", required="true", type="integer", example="myemail@gmail.com",	description="ID number of brand" ),
 *    				 @OA\Property(property="owner_id", required="true", type="date", example="My date of birth",	description="ID number of car's owner" ),
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has been created.")
 * )
 */

Flight::route('POST /cars', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::carservice()->add($data));
});


?>
