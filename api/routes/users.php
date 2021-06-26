<?php


/**
 * @OA\Info(title="Rent a car API", version="0.1")
 * @OA\OpenApi(
 *   @OA\Server(
 *       url="http://localhost/rentacarsystem/api/",
 *       description="Development Enviroment"
 *   ),
 *    @OA\Server(url="https://rent-a-car-system-iinfw.ondigitalocean.app/api/", description="Production Environment" )
 * ),
 * @OA\SecurityScheme(securityScheme="ApiKeyAuth", type="apiKey", in="header", name="Authentication" )
 */

/**
 * @OA\Get(
 *     path="/admin/users", tags={"admin", "users"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for users. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List users from database")
 * )
 */

Flight::route('GET /admin/users', function(){

  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 10);

  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  Flight::json(Flight::userService()->get_users($search, $offset, $limit, $order));
});

/**
*
 * @OA\Get(
 *     path="/admin/users/{id}",tags={"admin","users"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1, description="Id of user"),
 *     @OA\Response(response="200", description="List users from database by ID")
 * )
 */

Flight::route('GET /admin/users/@id', function($id){
    Flight::json(Flight::userService()->get_by_id($id));
});

/**
 * @OA\Post(path="/users/register", tags={"users"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", required="true", type="string", example="My name",	description="Name of the user" ),
 *    				 @OA\Property(property="mail", required="true", type="string", example="myemail@gmail.com",	description="User's email address" ),
 *    				 @OA\Property(property="dob", required="false", type="date", example="xxxx-xx-xx",	description="Date of birth of the user" ),
 *             @OA\Property(property="password", required="true", type="string", example="12345",	description="Password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has been created.")
 * )
 */

Flight::route('POST /users/register', function(){
  $data = Flight::request()->data->getData();
  Flight::userService()->register($data);
  Flight::json(["mssage" => "Confirmation email has been sent. Please confirm your account"]);
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
 * @OA\Post(path="/users/forgot", tags={"users"}, description="Send recovery URL to users email address", security={{"ApiKeyAuth": {}}},
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

Flight::route('POST /users/forgot', function(){
  $data = Flight::request()->data->getData();
  Flight::userService()->forgot($data);
  Flight::json(["message" => "Recovery link has been sent to your email"]);
});

/**
 * @OA\Post(path="/users/reset", tags={"users"}, description="Reset users password using recovery token", security={{"ApiKeyAuth": {}}},
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
Flight::route('POST /users/reset', function(){
  $data = Flight::request()->data->getData();
  Flight::userService()->reset($data);
  Flight::json(["message" => "Your password has been changed"]);
});

/**
 * @OA\Get(path="/users/confirm/{token}", tags={"users"},
 *     @OA\Parameter(type="string", in="path", name="token", default=123, description="Temporary token for activating account"),
 *     @OA\Response(response="200", description="Message upon successfull activation.")
 * )
 */

Flight::route('GET /users/confirm/@token', function($token){
  Flight::userService()->confirm($token);
  Flight::json(["message" => "Your account has been activated."]);
});

/**

 * @OA\Put(
 *     path="/users/update",tags={"admin","users"}, security={{"ApiKeyAuth": {}}},
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

Flight::route('PUT /users/update', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->update(Flight::get('user')['id'], $data));
});

/**
 * @OA\Put(
 *     path="/users/{id}",tags={"users"}, security={{"ApiKeyAuth": {}}},
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

Flight::route('PUT /users/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->update(Flight::get('user')['id'], $data));
});

/**
 * @OA\Post(path="/admin/users", tags={"admin", "users"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic account info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *             @OA\Property(property="name", required="true", type="string", example="My name",	description="Name of the user" ),
 *    				 @OA\Property(property="mail", required="true", type="string", example="myemail@gmail.com",	description="User's email address" ),
 *    				 @OA\Property(property="dob", required="true", type="date", example="xxxx-xx-xx",	description="Date of birth of the user" ),
 *             @OA\Property(property="password", required="true", type="string", example="12345",	description="Password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="User that has been added into database with ID assigned.")
 * )
 */

Flight::route('POST /admin/users', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->add($data));
});

/**
*
 * @OA\Get(
 *     path="/users/profile",tags={"users"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(),
 *     @OA\Response(response="200", description="List users from database by ID")
 * )
 */

Flight::route('GET /users/profile', function(){
    Flight::json(Flight::userService()->get_by_id(Flight::get('user')['id']));
});

/**
 * @OA\Put(path="/admin/users/{id}", tags={"admin"}, security={{"ApiKeyAuth": {}}},
 *   @OA\Parameter(type="integer", in="path", name="id", default=1),
 *   @OA\RequestBody(description="Basic emiail template info that is going to be updated", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="model", required="true", type="string", example="audi",	description="Model of the car" ),
 *    				 @OA\Property(property="brand_id", required="true", type="integer", example="subject",	description="10" ),
 *          )
 *       )
 *     ),
 *     @OA\Response(response="200", description="Update email template")
 * )
 */

Flight::route('PUT /admin/users/@id', function($id){
  Flight::json(Flight::userService()->update($id, Flight::request()->data->getData()));
});

?>
