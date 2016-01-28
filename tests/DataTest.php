<?php

namespace PluginBase;

class DataTest extends \TestCase
{
    public function test_cache()
    {
        Data::$cache['test'] = 'temp';
        $this->assertEquals(Data::$cache['test'], 'temp');
    }

    /**
     * @dataProvider maps_keys
     */
    public function test_maps($key)
    {
        $this->assertTrue(!empty(Data::maps($key)));
    }

    public function maps_keys()
    {
        return [
            ['sample'],
        ];
    }

    public function test_maps_all()
    {
        $this->assertTrue(!empty(Data::maps()));
        $this->assertTrue(is_array(Data::maps()));
    }

    public function test_get_data_update_data()
    {
        $data = rand();
        Data::update_data('sample', $data);
        $this->assertEquals(Data::get_data('sample'), $data);
    }

    public function test_filter_data()
    {
        $data = Data::filter_data(['a' => 'A', 'b' => 'B'], ['b']);
        $this->assertTrue(!isset($data['a']));
    }
}
