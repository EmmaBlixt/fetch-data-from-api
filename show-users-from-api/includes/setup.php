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

/**
* Find and call plugin page template
*/
function display_users_template( $template) {

    $file_name = 'show-users.php';

    if ( locate_template( $file_name ) ) :
      $template = locate_template( $file_name );
    else :
      $template = dirname( __FILE__ ) . '/../templates/' . $file_name;
    endif;

    if ( $template ) :
      load_template( $template, false );
    endif;
}
