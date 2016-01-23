<?php

use Jazel\GF\ADF\Base;
use Jazel\GF\ADF\Helpers;

class HelpersTest extends TestCase
{
    public function test_get_files_list()
    {
        $files = Helpers\get_files_list(Base::base_dir());
        $this->assertTrue(!empty($files));
    }

    public function test_get_files_list_with_filter()
    {
        $files = Helpers\get_files_list(Base::base_dir(), 'php');
        foreach ($files as $file) {
            $this->assertContains('.php', $file);
        }
    }
}
