<?php

/* middleware for users */
Flight::route('/companies/*', function(){
  if(Flight::request()->url == '/companies/register' || Flight::request()->url == '/companies/forgot' || Flight::request()->url == '/companies/login' || Flight::request()->url == '/companies/reset') return TRUE;
  if(startsWith(Flight::request()->url, '/companies/confirm/')) return TRUE;
  try {
    $company = @(array)\Firebase\JWT\JWT::decode(Flight::header("Authentication"), Config::JWT_SECRET, ["HS256"]);
    Flight::set('company', $company);
    return TRUE;
  } catch (\Exception $e) {
    Flight::json(["message" => $e->getMessage()], 401);
    die;
  }
});

/* middleware for users */
Flight::route('/users/*', function(){
  if(Flight::request()->url == '/user/reset' || Flight::request()->url == '/user/register' || Flight::request()->url == '/user/forgot' || Flight::request()->url == '/user/login' || Flight::request()->url == '/user/confirm/@token') return TRUE;

  try {
    $user = @(array)\Firebase\JWT\JWT::decode(Flight::header("Authentication"), Config::JWT_SECRET, ["HS256"]);
    Flight::set('user', $user);
    return TRUE;
  } catch (\Exception $e) {
    Flight::json(["message" => $e->getMessage()], 401);
    die;
  }
});

/* middleware for admin users */
Flight::route('/admin/*', function(){
  try {
    $user = @(array)\Firebase\JWT\JWT::decode(Flight::header("Authentication"), Config::JWT_SECRET, ["HS256"]);
    if ($user['r'] != "ADMIN"){
      throw new Exception("Admin access required", 403);
    }
    Flight::set('user', $user);
    return TRUE;
  } catch (\Exception $e) {
    Flight::json(["message" => $e->getMessage()], 401);
    die;
  }
});

/*
Flight::before('start', function(&$params, &$output){
  if(Flight::request()->url == '/swagger') return TRUE;
  if(startsWith(Flight::request()->url, '/users/')) return TRUE;

  $headers = getallheaders();
  $token = @$headers['Authentication'];
  //print_r($token); die;
  try {
      $decoded = (array)\Firebase\JWT\JWT::decode($token, 'JWT SECRET', array('HS256'));
      Flight::set('user', $decoded);
      return TRUE;
  } catch (\Exception $e) {
      Flight::json(["messsage" => $e->getMessage()], 401);
      die;
  }
});*/

function startsWith ($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

?>
