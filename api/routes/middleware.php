<?php

function startsWith ($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

Flight::before('start', function(&$params, &$output){
  if(Flight::request()->url == '/swagger') return TRUE;
  if(startsWith(Flight::request()->url, '/users/')) return TRUE;

  $headers = getallheaders();
  $token = @$headers['Authentication'];
  try {
      $decoded = (array)\Firebase\JWT\JWT::decode($token, 'JWT SECRET', array('HS256'));
      Flight::set('user', $decoded);
      return TRUE;
  } catch (\Exception $e) {
      Flight::json(["messsage" => $e->getMessage()], 401);
      die;
  }
});

?>
