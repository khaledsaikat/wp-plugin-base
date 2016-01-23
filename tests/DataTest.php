<?php

use Jazel\GF\ADF\Data;

class DataTest extends TestCase
{

    /**
     * @dataProvider mapskeys
     */
    public function testMaps($key)
    {
        $this->assertFalse(empty(Data::maps($key)));
    }

    public function mapskeys()
    {
        return [
            ['settings'],
            ['make_model'],
            ['schedule_hook'],
            ['make_class'],
            ['model_class'],
        ];
    }

    private static function dummySettings()
    {
        return [
            'gform_ids' => '1:2:3, 2:2:3'
        ];
    }

    /**
     * @depends testMaps
     */
    public function testUpdateGetData()
    {
        Data::update_data('settings', '');
        $this->assertEmpty(Data::get_data('settings'));

        Data::update_data('settings', self::dummySettings());
        $this->assertFalse(empty(Data::get_data('settings')));
    }

    /**
     * @depends testUpdateGetData
     */
    public function testGformValidForms()
    {
        Data::update_data('settings', [
            'gform_ids' => '1:2:3, 2:2:3'
        ]);

        $data = Data::gform_valid_forms();

        $this->assertFalse(empty($data));

        foreach ($data as $form) {
            $this->assertFalse(empty($form['id']));
            $this->assertFalse(empty($form['make']));
            $this->assertFalse(empty($form['model']));
        }
    }

    public function testStartSchedule()
    {
        Data::start_schedule();

        $hook = Data::maps('schedule_hook');
        $schedule = wp_get_schedule($hook);

        $this->assertEquals('daily', wp_get_schedule($hook));
    }

    public function testRemoveSchedule()
    {
        Data::remove_schedule();

        $hook = Data::maps('schedule_hook');
        $schedule = wp_get_schedule($hook);

        $this->assertFalse(wp_get_schedule($hook));
    }

}
