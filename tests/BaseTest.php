<?php

use Jazel\GF\ADF\Base;

class BaseTest extends TestCase
{

    public function testInit()
    {
        $this->assertFalse(empty(Base::$plugin_data['name']));
        $this->assertFalse(empty(Base::$plugin_data['version']));
        $this->assertFalse(empty(Base::$plugin_data['file']));
        $this->assertFalse(empty(Base::$plugin_data['slug']));
        $this->assertFalse(empty(Base::$plugin_data['path']));
        $this->assertFalse(empty(Base::$plugin_data['url']));
    }

    public function testBaseDir()
    {
        $this->assertEquals(Base::base_dir(), rtrim(__DIR__, '/tests'));
    }

    public function testView()
    {
        $this->assertFalse(empty(Base::view('message', [
            'message' => 'updated'
        ])));
    }

}
