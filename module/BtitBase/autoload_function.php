<?php
set_include_path(dirname(dirname(dirname(__FILE__))).'/vendor/imagine/imagine/lib/Imagine' . PATH_SEPARATOR . get_include_path());
function imagineLoader($class) {
    $path = $class;
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $path) . '.php';
    if (file_exists($path)) {
        include $path;
    }
}
