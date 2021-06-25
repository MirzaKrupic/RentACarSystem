<?php
/**
 * @OA\Get(path="/brands/all", tags={"brands"},
 *     @OA\Parameter(type="integer", in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(type="integer", in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(type="string", in="query", name="order", default="-id", description="Sorting for return elements. -column_name ascending order by column_name or +column_name descending order by column_name"),
 *     @OA\Response(response="200", description="List email templates for user")
 * )
 */

Flight::route('GET /brands/all', function(){
  $offset = Flight::query('offset', 0);
  $limit = Flight::query('limit', 25);
  $order = Flight::query('order', '-id');

  Flight::json(Flight::brandService()->get_all_brands($offset, $limit, $order));
});

/**
 * @OA\Get(path="/brands/{id}", tags={"brands"},
 *     @OA\Parameter(type="integer", in="path", name="id", default=1, description="Brand ID"),
 *     @OA\Response(response="200", description="List brands by ID")
 * )
 */
 
Flight::route('GET /brands/@id', function($id){
  Flight::json(Flight::brandService()->get_by_id($id));
});

?>
