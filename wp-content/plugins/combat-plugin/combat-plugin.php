<?php
/*
 Plugin Name: Combat Plugin
 Author: Ivaylo Tokiev
 Version: 1.0.0
 */

require_once( dirname( __FILE__ ) .  '/core/combat_init.php' );
require_once( dirname( __FILE__ ) .  '/core/combat_page_methods.php' );
require_once( dirname( __FILE__ ) .  '/core/combat_page_ajax_methods.php' );
require_once( dirname( __FILE__ ) .  '/core/combat_shortcode_methods.php' );


add_action('wp_enqueue_scripts', 'combatplugin_files');
add_action( 'init', 'my_script_enqueuer' );


add_shortcode('combat_home_page', 'combat_home_page');
add_shortcode('combat_products_page', 'combat_products_page');


add_action('wp_ajax_nopriv_get_product', 'combat_ajax_get_product');
add_action('wp_ajax_get_product', 'combat_ajax_get_product');

add_action('wp_ajax_nopriv_edit_product', 'combat_ajax_edit_product');
add_action('wp_ajax_edit_product', 'combat_ajax_edit_product');


add_action('wp_ajax_nopriv_edit_product', 'combat_ajax_upload_image');
add_action('wp_ajax_upload_image', 'combat_ajax_upload_image');

