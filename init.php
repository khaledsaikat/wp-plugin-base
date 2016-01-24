<?php
/*
Plugin Name: WP Plugin Base
Plugin URI: http://khaledsaikat.com
Description: Base files for creating new WordPress plugin
Author: Khaled Hossain
Version: 1.0-alpha
Author URI: http://khaledsaikat.com
*/

namespace PluginBase;

require __DIR__.'/vendor/autoload.php';

Base::init(__FILE__);
Base::load_controllers();
