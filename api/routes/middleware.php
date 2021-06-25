<?php

/* middleware for companies */
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
  if(Flight::request()->url == '/users/reset' || Flight::request()->url == '/users/register' || Flight::request()->url == '/users/forgot' || Flight::request()->url == '/users/login') return TRUE;
  if(startsWith(Flight::request()->url, '/users/confirm/')) return TRUE;
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

function startsWith ($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}

?>
