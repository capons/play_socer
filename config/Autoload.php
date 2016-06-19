<?php


function __autoload($class_name) {
    $path = array(
        './models/',
        './config/',
        '../models/',
        '../config/'
    );
    foreach ($path as $f_path) {
        if (file_exists($f_path . $class_name . '.php')) {
            require_once($f_path . $class_name . '.php');
            return;
        }
    }

}
