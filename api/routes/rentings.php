<?php
/**
 * @OA\Post(path="/users/rentings/add", tags={"rentings"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic company info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *             @OA\Property(property="car_id", required="true", type="string", example="1",	description="ID of car" ),
 *    				 @OA\Property(property="return_date", required="false", type="date", example="xxxx-xx-xx",	description="Return date of renting" ),
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Renting added")
 * )
 */

Flight::route('POST /users/rentings/add', function(){
  Flight::json(Flight::rentingService()->add_renting(Flight::get('user')['id'], Flight::request()->data->getData()));
});

/**
 * @OA\Post(path="/cron", tags={"rentings"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic company info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="return_date", required="false", type="date", example="xxxx-xx-xx",	description="Return date of renting" ),
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Renting added")
 * )
 */

Flight::route('POST /cron', function(){
    Flight::rentingService()->cron_renting(Flight::request()->data->getData());
    Flight::json(["message" => "Cron job successfull."]);
});

/**
 * @OA\Put(path="/user/rent/{id}", tags={"users", "cars"}, security={{"ApiKeyAuth": {}}},
 *   @OA\Parameter(type="integer", in="path", name="id", default=1),
 *   @OA\RequestBody(description="Basic emiail template info that is going to be updated", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update car rental status")
 * )
 */

Flight::route('PUT /users/rent/@id', function($id){
  Flight::json(Flight::carService()->update_car_status(intval($id)));
});

/**
 * @OA\Get(path="/users/rentings/", tags={"users", "rentings"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(),
 *     @OA\Response(response="200", description="Fetch all rentings of logged user")
 * )
 */

Flight::route('GET /users/rentings/', function(){

  Flight::json(Flight::rentingService()->get_rent_by_user_id(Flight::get('user')['id']));
});

/**
 * @OA\Get(path="/users/rentings/all/", tags={"users", "rentings"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for rentings. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List all rentings of a logged in user")
 * )
 */

Flight::route('GET /users/rentings/all/', function(){
  $account_id = Flight::get('user')['id'];
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $search = Flight::query('search');
  $order = Flight::query('order', '-id');

  $total = Flight::rentingService()->get_rentings($account_id, $offset, $limit, $search, $order, TRUE);
  header('total-records: ' . $total['total']);

  Flight::json(Flight::rentingService()->get_rentings($account_id, $offset, $limit, $search, $order));
});


/**
 * @OA\Get(path="/admin/rentings/chart", tags={"purchases", "admin"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Response(response="200", description="Get purchase chart data")
 * )
 */
Flight::route('GET /admin/rentings/chart', function(){
  $res=Flight::rentingService()->getChart();
  Flight::json($res);
});

?>
