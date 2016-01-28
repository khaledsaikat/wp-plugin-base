<?php

namespace PluginBase;

class BaseTest extends \TestCase
{
    public function test_plugin_data()
    {
        $this->assertTrue(!empty(Base::plugin_data('name')));
        $this->assertTrue(!empty(Base::plugin_data('version')));
        $this->assertTrue(!empty(Base::plugin_data('file')));
        $this->assertTrue(!empty(Base::plugin_data('slug')));
        $this->assertTrue(!empty(Base::plugin_data('path')));
        $this->assertTrue(!empty(Base::plugin_data('url')));
    }

    public function test_plugin_data_all()
    {
        $this->assertFalse(empty(Base::plugin_data()));
        $this->assertTrue(is_array(Base::plugin_data()));
    }

    public function test_base_path()
    {
        $this->assertEquals(Base::base_path(), dirname(dirname(__FILE__)));
    }

    public function test_base_url()
    {
        $this->assertTrue(!empty(Base::base_url()));
    }

    public function test_resource_path()
    {
        $this->assertEquals(Base::resource_path(), dirname(dirname(__FILE__)).'/resources');
    }

    public function test_resource_url()
    {
        $this->assertTrue(!empty(Base::resource_url()));
    }

    public function test_get_files_list()
    {
        $files = Base::get_files_list(__DIR__, 'php');
        $this->assertTrue(!empty($files));
        $this->assertFalse(array_search('.', $files));
        $this->assertFalse(array_search('..', $files));
    }

    public function test_get_files_list_with_filter()
    {
        $files = Base::get_files_list(__DIR__, 'php');
        foreach ($files as $file) {
            $this->assertContains('.php', $file);
        }
    }

    public function test_view()
    {
        $this->assertFalse(empty(Base::view('message', [
            'message' => 'updated',
        ])));
    }
}
