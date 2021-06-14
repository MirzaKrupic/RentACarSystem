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

  Flight::json(Flight::brandservice()->get_all_brands($offset, $limit, $order));
});

?>
