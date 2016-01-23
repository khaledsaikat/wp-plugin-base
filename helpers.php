<?php

namespace PluginBase\Helpers;



/**
 * Get list of files from a directory.
 *
 * @param strings $directory full path of the directory
 * @param strings $filter    Filter return list (e.g: php)
 *
 * @return array
 */
function get_files_list($directory, $filter = null)
{
    $files = array();
    if (file_exists($directory)) {
        foreach (scandir($directory) as $item) {
            if ((in_array($item, ['.', '..'])) || ($filter && !preg_match("/\.$filter$/i", $item))) {
                continue;
            }

            $files[] = $item;
        }
    }

    return $files;
}

/**
 * Dumping data.
 *
 * @param mixed $data Data to dump
 * @param bool  $dump true for using var_dump
 */
function dump($data, $dump = false)
{
    echo '<pre>';
    if (is_array($data) or is_object($data)) {
        if ($dump) {
            var_dump($data);
        } else {
            print_r($data);
        }
    } else {
        var_dump($data);
    }
    echo '</pre>';
}
