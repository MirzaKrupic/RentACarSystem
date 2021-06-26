<?php

/**
 * @OA\Get(
 *     path="/admin/companies", tags={"admin","companies"},security={{"ApiKeyAuth": {}}},
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

  Flight::json(Flight::companyService()->get_companies($id, $offset, $limit, $search, $order));
});

/**
 * @OA\Post(path="/admin/companies", tags={"admin","companies"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic company info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", required="true", type="string", example="Companies name",	description="Name of the company" ),
 *    				 @OA\Property(property="address", required="false", type="string", example="My address",	description="Address of company" ),
 *    				 @OA\Property(property="mail", required="true", type="string", example="myemail@gmail.com",	description="Company's email address" ),
 *    				 @OA\Property(property="address", required="true", type="string", example="Address 22",	description="Company's address" ),
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that company has been created.")
 * )
 */

Flight::route('POST /admin/companies', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::companyService()->add($data));
});

/**
 * @OA\Post(path="/companies/register", tags={"companies"},
 *   @OA\RequestBody(description="Basic company info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", required="true", type="string", example="My name",	description="Name of the company" ),
 *    				 @OA\Property(property="mail", required="true", type="string", example="myemail@gmail.com",	description="Company's email address" ),
 *    				 @OA\Property(property="address", required="false", type="string", example="My address",	description="Address of company" ),
 *             @OA\Property(property="password", required="true", type="string", example="12345",	description="Password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that company has been created.")
 * )
 */

Flight::route('POST /companies/register', function(){
  $data = Flight::request()->data->getData();
  Flight::companyService()->register($data);
  Flight::json(["mssage" => "Confirmation email has been sent. Please confirm your account"]);
});

/**
 * @OA\Post(path="/companies/login", tags={"companies"},
 *   @OA\RequestBody(description="Basic company info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="mail", required="true", type="string", example="myemail@gmail.com",	description="Company's email address" ),
 *             @OA\Property(property="password", required="true", type="string", example="12345",	description="Password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Logged in")
 * )
 */

Flight::route('POST /companies/login', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::companyService()->login($data));
});

/**
*
 * @OA\Get(
 *     path="/companies/confirm/{token}",tags={"companies"},
 * @OA\Parameter(@OA\Schema(type="string"), in="path", name="token",  description="Token of company"
 * ),
 *     @OA\Response(response="200", description="Confirm registred company")
 * )
 */

Flight::route('GET /companies/confirm/@token', function($token){
  Flight::companyService()->confirm($token);
  Flight::json(["message" => "Your account has been activated."]);
});

/**
*
 * @OA\Get(
 *     path="/companies/profile",tags={"companies"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(),
 *     @OA\Response(response="200", description="List users from database by ID")
 * )
 */

Flight::route('GET /companies/profile', function(){
    Flight::json(Flight::companyService()->get_by_id(Flight::get('company')['id']));

});

/**

 * @OA\Put(
 *     path="/companies/update",tags={"companies"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    			@OA\Property(property="name", required="true", type="string", example="My Test Account",	description="Name of the account" ),
 *    				 @OA\Property(property="status", type="string", example="ACTIVE",	description="Account status" ))
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update user in database")
 * )
 */

Flight::route('PUT /companies/update', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::companyService()->update(Flight::get('company')['id'], $data));
});

/**
 * @OA\Post(path="/users/login", tags={"users"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="mail", required="true", type="string", example="myemail@gmail.com",	description="User's email address" ),
 *             @OA\Property(property="password", required="true", type="string", example="12345",	description="Password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has been logged in.")
 * )
 */

Flight::route('POST /users/login', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->login($data));
});

/**
 * @OA\Post(path="/companies/forgot", tags={"companies"}, description="Send recovery URL to users email address", security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="mail", required="true", type="string", example="myemail@gmail.com",	description="User's email address" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that recovery link has been sent.")
 * )
 */

Flight::route('POST /companies/forgot', function(){
  $data = Flight::request()->data->getData();
  Flight::companyService()->forgot($data);
  Flight::json(["message" => "Recovery link has been sent to your email"]);
});

/**
 * @OA\Post(path="/companies/reset", tags={"companies"}, description="Reset users password using recovery token", security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="token", required="true", type="string", example="123",	description="Recovery token" ),
 *    				 @OA\Property(property="password", required="true", type="string", example="123",	description="New password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has changed password.")
 * )
 */
Flight::route('POST /companies/reset', function(){
  $data = Flight::request()->data->getData();
  Flight::companyService()->reset($data);
  Flight::json(["message" => "Your password has been changed"]);
});

?>
