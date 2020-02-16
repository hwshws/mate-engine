<?php
spl_autoload_register("ClassLoader::Loader");
class ClassLoader{
    static function Loader($className)
    {
        $dir = dirname(__DIR__);
        $path = $dir . DIRECTORY_SEPARATOR ."php" . DIRECTORY_SEPARATOR ;
        $extension = ".php";
        $fullPath = $path . $className . $extension;
        if (!file_exists($fullPath)) return;
        include_once $fullPath;
    }
}
