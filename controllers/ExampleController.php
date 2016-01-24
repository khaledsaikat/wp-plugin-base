<?php

namespace PluginBase;

/**
 * @author Khaled Hossain
 *
 * @since 1.0
 */
class ExampleController
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'admin_menu']);

        add_action('wp_enqueue_scripts', [$this, 'enque_scripts']);
        add_action('admin_footer', [$this, 'enque_scripts']);
        add_action('wp_print_scripts', [$this, 'print_ajaxurl']);

        register_activation_hook(Base::plugin_data('file'), [$this, 'plugin_activate']);
        register_deactivation_hook(Base::plugin_data('file'), [$this, 'plugin_deactivate']);
    }

    public function admin_menu()
    {
        add_submenu_page('options-general.php', 'Plugin Base', 'Plugin Base', 'manage_options', 'plugin-base', [$this, 'admin_menu_page']);
    }

    public function admin_menu_page()
    {
        echo '<div class="wrap">Hello World!</div>';
    }

    public function enque_scripts()
    {
        Base::enque_script('sample.js');
    }

    /**
     * Set javascript ajaxurl variable.
     */
    public function print_ajaxurl()
    {
        echo '<script>ajaxurl="'.admin_url('admin-ajax.php').'"</script>';
    }

    public function plugin_activate()
    {
    }

    public function plugin_deactivate()
    {
    }
}
