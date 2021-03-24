<?php


/**
 * @OA\Info(title="Rent a car API", version="0.1")
 * @OA\OpenApi(
 *   @OA\Server(
 *       url="http://localhost/rentacarsystem/api/",
 *       description="Development Enviroment"
 *   )
 * )
 */

/**
 * @OA\Get(
 *     path="/users",
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
* @OA\Parameter(
*    @OA\Schema(type="integer"),
*    in="path",
*    allowReserved=true,
*    name="id"
* ),
*
 * @OA\Get(
 *     path="/users/{id}",
 *     @OA\Response(response="200", description="List users from database by ID")
 * )
 */

Flight::route('GET /users/@id', function($id){
  Flight::json(Flight::userservice()->get_by_id($id));
});

/**
 * @OA\Post(
 *     path="/users/register",
 *     @OA\Response(response="200", description="Register a new user")
 * )
 */

Flight::route('POST /users/register', function(){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userservice()->register($data));
});

/**
* @OA\Parameter(
*    @OA\Schema(type="integer"),
*    in="path",
*    allowReserved=true,
*    name="token"
* ),
*
 * @OA\Get(
 *     path="/users/register/{token}",
 *     @OA\Response(response="200", description="Confirm registred user")
 * )
 */

Flight::route('GET /users/confirm/@token', function($token){
  Flight::userservice()->confirm($token);
  Flight::json(["message" => "Your account has been activated."]);
});

/**
* @OA\Parameter(
*    @OA\Schema(type="integer"),
*    in="path",
*    allowReserved=true,
*    name="id",
*    parameter="file_path"
* ),
*
 * @OA\Put(
 *     path="/users/register/{token}",
 *     @OA\Response(response="200", description="Update user in database")
 * )
 */

Flight::route('PUT /users/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userservice()->update($id, $data));
});

?>
