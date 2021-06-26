<?php

class Config {
  const DATE_FORMAT = "Y-m-d H:i:s";

  public static function DB_HOST(){
  return Config::get_env("DB_HOST", "localhost");
  }
  public static function DB_USERNAME(){
    return Config::get_env("DB_USERNAME", "rentacarsystem");
  }
  public static function DB_PASSWORD(){
    return Config::get_env("DB_PASSWORD", "rentacarsystem");
  }
  public static function DB_SCHEME(){
    return Config::get_env("DB_SCHEME", "rentacarsystem");
  }
  public static function DB_PORT(){
    return Config::get_env("DB_PORT", "3306");
  }
  public static function SMTP_HOST(){
    return Config::get_env("SMTP_HOST", "smtp.googlemail.com");
  }
  public static function SMTP_PORT(){
    return Config::get_env("SMTP_PORT", 465);
  }
  public static function SMTP_USER(){
    return Config::get_env("SMTP_USER", "mirza.krupic@stu.ibu.edu.ba");
  }
  public static function SMTP_PASSWORD(){
    return Config::get_env("SMTP_PASSWORD", "%JwDuX");
  }

    /** CDN config */
  public static function CDN_KEY(){
    return Config::get_env("CDN_KEY", "FWM4MO75KONTL2U4WU7J");
  }
  public static function CDN_SECRET(){
    return Config::get_env("CDN_SECRET", "9Ribz39COCQ8uy9c0hQnHWnxYV/ePmjhOomeHphmYww");
  }
  public static function CDN_SPACE(){
    return Config::get_env("CDN_SPACE", "cdn.rentacar.ba");
  }
  public static function CDN_BASE_URL(){
    return Config::get_env("CDN_BASE_URL", "https://fra1.digitaloceanspaces.com");
  }
  public static function CDN_REGION(){
    return Config::get_env("CDN_REGION", "fra1");
  }

  const JWT_SECRET = "y4KvQcZVqn3F7uxQvcFk";
  const JWT_TOKEN_TIME = 604800;

  public static function get_env($name, $default){
    return isset($_ENV[$name]) && trim($_ENV[$name]) != '' ? $_ENV[$name] : $default;
  }
}

?>
