<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
* Enqueue the plugin styling
*/
function register_user_styles()
{
    wp_register_style('display-users-style', plugins_url('../css/display-users-style.css',__FILE__));
    wp_enqueue_style('display-users-style');
}

add_action('wp_enqueue_scripts','register_user_styles');
