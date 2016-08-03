<?php
namespace PluginBase;

/**
 * Autoload models classes
 */
spl_autoload_register(function ($class) {
    if (strpos($class, __NAMESPACE__) !== 0)
        return false;
    
    $class = substr($class, strlen(__NAMESPACE__) + 1);
    $class = str_replace('\\', '/', $class);
    $path = dirname(__FILE__) . '/models/' . $class . '.php';
    if (is_readable($path)) {
        require_once $path;
    }
});