<?php
/*
Plugin Name: WintersportQuiz
Description: Quiz voor het aanbevelen van skiegebieden
Author: Dintify
Author URI: https://floris999.github.io
*/

if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . 'controllers/FormController.php';

function my_plugin_activate()
{
    require_once plugin_dir_path(__FILE__) . 'database/custom_table.php';
    create_custom_tables();
}
register_activation_hook(__FILE__, 'my_plugin_activate');

function my_plugin_init()
{
    $form_controller = new FormController();
}
add_action('plugins_loaded', 'my_plugin_init');
