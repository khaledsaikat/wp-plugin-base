<?php

namespace PluginBase;

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
