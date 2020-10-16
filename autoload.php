<?php
function app_autoloader($class){

    require_once 'app/' . $class . '.inc.php';

}
spl_autoload_register('app_autoloader');