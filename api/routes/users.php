<?php


/**
 * @OA\Info(title="Rent a car API", version="0.1")
 * @OA\OpenApi(
 *   @OA\Server(
 *       url="http://localhost/rentacarsystem/api/",
 *       description="Development Enviroment"
 *   )
 * ),
 * @OA\SecurityScheme(securityScheme="ApiKeyAuth", type="apiKey", in="header", name="Authentication" )
 */

/**
 * @OA\Get(
 *     path="/users", tags={"user"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="search", description="Search string for accounts. Case insensitive search."),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List users from database")
 * )
 */

Flight::route('GET /users', function(){

  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 10);

  $search = Flight::query('search');
  $order = Flight::query('order', "-id");

  Flight::json(Flight::userservice()->get_users($search, $offset, $limit, $order));
});

/**
*
 * @OA\Get(
 *     path="/users/{id}",tags={"user"}, security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1, description="Id of account"),
 *     @OA\Response(response="200", description="List users from database by ID")
 * )
 */

Flight::route('GET /users/@id', function($id){
    if(Flight::get('user')['id'] != $id) throw new Exception("This user is not for you");
    Flight::json(Flight::userservice()->get_by_id($id));

});

/**
 * @OA\Post(path="/users/register", tags={"user"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="name", required="true", type="string", example="My name",	description="Name of the user" ),
 *    				 @OA\Property(property="mail", required="true", type="string", example="myemail@gmail.com",	description="User's email address" ),
 *    				 @OA\Property(property="dob", required="true", type="date", example="My date of birth",	description="Date of birth of the user" ),
 *             @OA\Property(property="password", required="true", type="string", example="12345",	description="Password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has been created.")
 * )
 */

Flight::route('POST /users/register', function(){
  $data = Flight::request()->data->getData();
  Flight::userservice()->register($data);
  Flight::json(["mssage" => "Confirmation email has been sent. Please confirm your account"]);
});

/**
 * @OA\Post(path="/users/login", tags={"user"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic user info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *    				 @OA\Property(property="mail", required="true", type="string", example="myemail@gmail.com",	description="User's email address" ),
 *             @OA\Property(property="password", required="true", type="string", example="12345",	description="Password" )
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Message that user has been created.")
 * )
 */

Flight::route('POST /users/login', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userservice()->login($data));
});

/**
 * @OA\Post(path="/users/forgot", tags={"user"}, description="Send recovery URL to users email address", security={{"ApiKeyAuth": {}}},
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
  Flight::userservice()->forgot($data);
  Flight::json(["message" => "Recovery link has been sent to your email"]);
});

/**
 * @OA\Post(path="/users/reset", tags={"user"}, description="Reset users password using recovery token", security={{"ApiKeyAuth": {}}},
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
  Flight::userservice()->reset($data);
  Flight::json(["message" => "Your password has been changed"]);
});

/**
*
 * @OA\Get(
 *     path="/users/confirm/{token}",tags={"user"}, security={{"ApiKeyAuth": {}}},
 * @OA\Parameter(@OA\Schema(type="string"), in="path", name="token",  description="Token of user"
 * ),
 *     @OA\Response(response="200", description="Confirm registred user")
 * )
 */

Flight::route('GET /users/confirm/@token', function($token){
  Flight::userservice()->confirm($token);
  Flight::json(["message" => "Your account has been activated."]);
});

/**

 * @OA\Put(
 *     path="/users/{id}",tags={"user"}, security={{"ApiKeyAuth": {}}},
 * @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
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
  Flight::json(Flight::userservice()->update($id, $data));
});

?>
