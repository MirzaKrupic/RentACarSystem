<?php
/**
 * @OA\Post(path="/users/rentings/add", tags={"rentings"}, security={{"ApiKeyAuth": {}}},
 *   @OA\RequestBody(description="Basic company info", required=true,
 *       @OA\MediaType(mediaType="application/json",
 *    			@OA\Schema(
 *             @OA\Property(property="car_id", required="true", type="string", example="1",	description="Password" ),
 *    				 @OA\Property(property="return_date", required="false", type="date", example="xxxx-xx-xx",	description="Date of birth of the user" ),
 *          )
 *       )
 *     ),
 *  @OA\Response(response="200", description="Car added")
 * )
 */

Flight::route('POST /users/rentings/add', function(){
  Flight::json(Flight::rentingservice()->add_renting(Flight::get('user')['id'], Flight::request()->data->getData()));
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
Flight::route('PUT /user/rent/@id', function($id){
  Flight::json(Flight::carservice()->update_car_status(intval($id)));
});

?>
