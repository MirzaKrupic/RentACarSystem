<?php

/**
 * @OA\Get(
 *     path="/admin/companies", tags={"admin","companies"},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for companies. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List companies from database")
 * )
 */

Flight::route('GET /admin/companies', function(){
  $id = Flight::query('id');
  $limit = Flight::query('limit', 10);
  $offset = Flight::query('offset', 0);
  $search = Flight::query('search');
  $order = Flight::query('order', '-id');

  Flight::json(Flight::companyservice()->get_companies($id, $offset, $limit, $search, $order));
});


/**
 * @OA\Post(path="/admin/companies", tags={"admin","companies"},
 *   @OA\RequestBody(description="Basic company info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", required="true", type="string", example="My name",	description="Name of the company" ),
 *    				 @OA\Property(property="mail", required="true", type="string", example="myemail@gmail.com",	description="Company's email address" ),
 *    				 @OA\Property(property="address", required="true", type="string", example="Address 22",	description="Company's address" ),
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has been created.")
 * )
 */

Flight::route('POST /admin/companies', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::companyservice()->add($data));
});

/**
*
 * @OA\Get(
 *     path="/companies/confirm/{token}",tags={"companies"},
 * @OA\Parameter(@OA\Schema(type="string"), in="path", name="token",  description="Token of company"
 * ),
 *     @OA\Response(response="200", description="Confirm registred user")
 * )
 */

Flight::route('GET /companiesconfirm/@token', function($token){
  Flight::companyservice()->confirm($token);
  Flight::json(["message" => "Your account has been activated."]);
});

?>
