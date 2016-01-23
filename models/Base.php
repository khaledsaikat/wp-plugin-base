<?php

namespace PluginBase;

/**
 * Base class for loading the plugin.
 *
 * @author Khaled Hossain
 *
 * @since 1.0
 */
class Base
{
    /**
     * an array to hold plugin's data.
     */
    private static $plugin_data = array();

    /**
     * Assign $plugin_data.
     *
     * @param string __FILE__
     */
    public static function init($file_path)
    {
        $plugin_headers = array(
            'name' => 'Plugin Name',
            'version' => 'Version',
        );
        self::$plugin_data = get_file_data($file_path, $plugin_headers);
        self::$plugin_data['file'] = $file_path;
        self::$plugin_data['slug'] = plugin_basename($file_path);
        self::$plugin_data['path'] = dirname($file_path);
        self::$plugin_data['url'] = plugins_url('', $file_path);
    }

    /**
     * Get plugin's Data.
     *
     * @param string $key: name, version, file, slug, path, url
     *
     * @return [array|string] array when $key is null otherwise string
     */
    public static function plugin_data($key = null)
    {
        if (!empty($key)) {
            return isset(self::$plugin_data[$key]) ? self::$plugin_data[$key] : '';
        }

        return self::$plugin_data;
    }

    /**
     * Get base directory of the plugin.
     *
     * @return string
     */
    public static function base_path()
    {
        return self::plugin_data('path');
    }

    /**
     * Get base url of the plugin.
     *
     * @return string
     */
    public static function base_url()
    {
        return self::plugin_data('url');
    }

    /**
     * Get base namespace of the plugin.
     *
     * @return string: Current namespace
     */
    public static function base_namespace()
    {
        return __NAMESPACE__;
    }

    /**
     * Get path of resources directory.
     *
     * @return string
     */
    public static function resource_path()
    {
        return self::base_path().'/resources';
    }

    /**
     * make instance of each controller class.
     */
    public static function load_controllers()
    {
        foreach (scandir(self::base_path().'/controllers') as $file) {
            if (strpos($file, 'Controller.php') !== false) {
                $class = __NAMESPACE__.'\Controllers\\'.rtrim($file, '.php');
                new $class();
            }
        }
    }

    /**
     * Get the evaluated view contents for the given view.
     *
     * @param string $view
     * @param array  $data
     * @param array  $mergeData
     *
     * @return string
     */
    public static function view($view = null, $data = [], $mergeData = [])
    {
        $path = self::base_path().'/resources/views';
        $path .= '/'.str_replace('.', '/', $view).'.php';
        if ($data) {
            extract($data);
        }
        ob_start();
        include $path;
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }

    /**
     * Enque javascript or css file.
     *
     * @param string  $subdir   (optionl)
     * @param strings $filename Filename with extension
     */
    public function enque_script($filename, $subdir = null)
    {
        $file = \pathinfo($filename);
        $handle = $file['filename'];
        $part_path = !empty($subdir) ? $subdir.'/' : '';
        $part_path .= $filename;
        if ($file['extension'] == 'js') {
            \wp_enqueue_script($handle, Self::base_url().'/js/'.$part_path, array('jquery'), self::plugin_data('version'), true);
        } elseif ($file['extension'] == 'css') {
            \wp_enqueue_style($handle, Self::base_url().'/css/'.$part_path, array(), self::plugin_data('version'));
        }
    }
}
