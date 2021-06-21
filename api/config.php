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
    return Config::get_env("SMTP_PORT", "465");
  }
  public static function SMTP_USER(){
    return Config::get_env("SMTP_USER", "mirza.krupic@stu.ibu.edu.ba");
  }
  public static function SMTP_PASSWORD(){
    return Config::get_env("SMTP_PASSWORD", NULL);
  }

  const JWT_SECRET = "y4KvQcZVqn3F7uxQvcFk";
  const JWT_TOKEN_TIME = 604800;
}

?>
