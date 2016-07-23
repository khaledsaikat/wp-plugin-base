<?php

/**
 * Remove empty lines from string.
 *
 * @param strings $text
 *
 * @return strings
 */
function remove_empty_lines($text)
{
    $lines = explode("\n", $text);
    foreach ($lines as $key => $line) {
        if (empty(trim($line))) {
            unset($lines[$key]);
        }
    }

    return implode("\n", $lines);
}

/**
 * Add more data to an add_to_array.
 *
 * @param array $base     Base array in which data shall be added
 * @param array $provided New data to added
 * @param array $keys     valid keys of array
 */
function add_to_array(array &$base, array $provided, array $keys)
{
    foreach ($keys as $key) {
        if (isset($provided[$key])) {
            $base[$key] = $provided[$key];
        }
    }
}

/**
 * Get json file from path
 *
 * @param string $file
 * @return json
 */
function get_json($file)
{
    try {
        $path = Base::resource_path() . '/json/' . $file;
        return json_decode(file_get_contents($path), true);
    } catch (Exception $e) {
        echo 'Exception: ',  $e->getMessage(), "\n";
    }
}

/**
 * Generate key, value array
 *
 * @param array $input_array
 * @param string $first
 * @return array
 */
function key_value_array($input_array, $first='')
{
    $data = [];
    if ($first) $data[''] = $first;

    foreach ($input_array as $value)
        $data[$value] = $value;

    return $data;
}
