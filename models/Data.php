<?php

namespace PluginBase;

/**
 * Base class for storing and retriving data.
 *
 * @author Khaled Hossain
 *
 * @since 1.0
 */
class Data
{
    /**
     * Store temporary data.
     *
     * @var array
     */
    public static $cache = array();

    /**
     * Maps array to store key => value.
     */
    private static $maps = array(
        'sample' => 'maped_sample'
    );

    /**
     * Maps array to store key => value.
     * $optionMaps used for get_option() and update_option().
     */
    private static $option_maps = array(
        'sample' => 'sample_option'
    );

    /**
     * Referer for _wpnonce.
     */
    private static $referer = '_wpnonce';

    /**
     * Maps from key to value.
     *
     * @param string: $key
     *
     * @return string|array: mapped value
     */
    public static function maps($key = null)
    {
        if (!empty($key)) {
            return self::$maps[$key];
        }

        return self::$maps;
    }

    /**
     * Get date from databse.
     *
     * @param string: $key
     *
     * @return mixed: value
     */
    public static function get_data($key, $default = null)
    {
        return get_option(self::$option_maps[$key], $default);
    }

    /**
     * Store date to databse.
     *
     * @param string: $key
     * @param mixed:  $data
     *
     * @return mixed: value
     */
    public static function update_data($key, $data)
    {
        update_option(self::$option_maps[$key], $data);
    }

    /**
     * Store settings by admin menu.
     */
    public static function save()
    {
        if (!empty($_POST) && check_admin_referer(self::$referer)) {
            self::update_settings();
        }
    }

    /**
     * Store settings by admin menu.
     */
    private static function update_settings()
    {
        if (isset($_POST['update_settings'])) {
            $data = self::filter_data($_POST, array('sample1'));

            self::update_data('settings', $data);

            echo Base::view('message', array(
                'message' => __('Settings saved.'),
            ));
        }
    }

    /**
     * Filter data for allowed key.
     *
     * @param array: $data
     * @param array: $valid_attr
     *
     * @return array: filtered data
     */
    private static function filter_data(array $data, array $valid_attr)
    {
        foreach ($data as $key => $itm) {
            if (!in_array($key, $valid_attr)) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}
