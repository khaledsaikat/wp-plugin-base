<?php

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
