<?php


declare(strict_types = 1);

date_default_timezone_set("Africa/Lagos");


include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php';


spl_autoload_register(function ($classname) {
    
    $filename = dirname(__FILE__).DIRECTORY_SEPARATOR.str_replace('imagegallery\\', '', $classname).'.php';

    $filename = str_replace('\\', DIRECTORY_SEPARATOR,  $filename);

    //echo $filename.'-----';

    if (is_readable($filename)) {
        include_once $filename;
    }
});




