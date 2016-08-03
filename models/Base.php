<?php
namespace PluginBase;

/**
 * Base class for loading the plugin.
 * Base class version 1.0.1
 *
 * @author Khaled Hossain
 */
class Base
{

    /**
     * an array to hold plugin's data.
     */
    private static $plugin_data = array();

    /**
     * Populate $plugin_data.
     * This method should called by plugin's main file right before loading controllers.
     *
     * @param
     *            string __FILE__ : Path of the plugin main file
     */
    public static function init($file_path)
    {
        $plugin_headers = array(
            'name' => 'Plugin Name',
            'version' => 'Version'
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
     * @param string $key:
     *            name, version, file, slug, path, url
     *            
     * @return [array|string] array when $key is null otherwise string
     */
    public static function plugin_data($key = null)
    {
        if (! empty($key)) {
            return isset(self::$plugin_data[$key]) ? self::$plugin_data[$key] : '';
        }
        
        return self::$plugin_data;
    }

    /**
     * Get base directory of the plugin.
     *
     * @return string
     */
    public static function base_path($path = null)
    {
        return self::plugin_data('path') . $path;
    }

    /**
     * Get base url of the plugin.
     *
     * @return string
     */
    public static function base_url($path = null)
    {
        return self::plugin_data('url') . $path;
    }

    /**
     * Get path of resources directory.
     *
     * @return string
     */
    public static function resource_path($path = null)
    {
        return self::base_path() . '/resources' . $path;
    }

    /**
     * Get resources url.
     *
     * @return string
     */
    public static function resource_url($path = null)
    {
        return self::base_url() . '/resources' . $path;
    }

    /**
     * Get list of files from a directory.
     *
     * @param strings $directory
     *            full path of the directory
     * @param strings $filter
     *            Filter return list (e.g: php)
     *            
     * @return array
     */
    public static function get_files_list($directory, $filter = null)
    {
        $files = array();
        if (file_exists($directory)) {
            foreach (scandir($directory) as $item) {
                if ((in_array($item, [
                    '.',
                    '..'
                ])) || ($filter && ! preg_match("/\.$filter$/i", $item))) {
                    continue;
                }
                
                $files[] = $item;
            }
        }
        
        return $files;
    }

    /**
     * make instance of each controller class.
     */
    public static function load_controllers()
    {
        $files = self::get_files_list(self::base_path() . '/controllers', 'php');
        foreach ($files as $file) {
            if (strpos($file, 'Controller.php') !== false) {
                require_once self::base_path() . '/controllers/' . $file;
                $class = __NAMESPACE__ . '\\' . rtrim($file, '.php');
                new $class();
            }
        }
    }

    /**
     * Get the evaluated view contents for the given view.
     *
     * @param string $view
     *            allows subdirectory as . or / notation
     * @param array $data            
     * @param array $mergeData            
     *
     * @return string
     */
    public static function view($view = null, $data = [])
    {
        $path = self::base_path() . '/resources/views';
        $path .= '/' . str_replace('.', '/', $view) . '.php';
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
     * @param string $subdir
     *            (optionl)
     * @param strings $filename
     *            Filename with extension
     * @param string $handle            
     */
    public static function enque_script($filename, $subdir = null, $handle = null)
    {
        $file = \pathinfo($filename);
        $handle = ! empty($handle) ? $handle : $file['filename'];
        $part_path = ! empty($subdir) ? $subdir . '/' : '';
        $part_path .= $filename;
        if ($file['extension'] == 'js') {
            \wp_enqueue_script($handle, Self::base_url() . '/js/' . $part_path, array(
                'jquery'
            ), self::plugin_data('version'), true);
        } elseif ($file['extension'] == 'css') {
            \wp_enqueue_style($handle, Self::base_url() . '/css/' . $part_path, array(), self::plugin_data('version'));
        }
    }
}
