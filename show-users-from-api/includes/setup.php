<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
* Enqueue the plugin styling
*/
function register_display_user_styles()
{
    wp_register_style('style', plugins_url('../css/style.css',__FILE__));
}

add_action('wp_enqueue_scripts','register_display_user_styles');
