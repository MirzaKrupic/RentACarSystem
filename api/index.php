<?php
require_once dirname(__FILE__)."/dao/BaseDao.class.php";

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(__FILE__).'/dao/UserDao.class.php';

Flight::register('userdao', 'UserDao');

require_once dirname(__FILE__).'/routes/users.php';

Flight::start();
?>
