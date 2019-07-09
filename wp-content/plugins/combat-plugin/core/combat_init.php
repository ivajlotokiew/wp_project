<?php
/**
 * Created by PhpStorm.
 * User: ivaylo
 * Date: 19.4.2019 г.
 * Time: 17:13
 */

function combat_render_view($path, $params){
    ob_start();
    include($path);
    $view = ob_get_contents();
    ob_end_clean();
    return $view;
}

function combatplugin_files() {
    wp_enqueue_style('combat_custom_css', plugin_dir_url( __FILE__ ) . '../public/css/combat-custom.css');
    wp_enqueue_style('bootbox_css', plugin_dir_url( __FILE__ ) . '../public/css/bootstrap.min.css');
    wp_enqueue_style('datepicker_css', plugin_dir_url( __FILE__ ) . '../public/css/bootstrap-datepicker.standalone.min.css');
    wp_enqueue_script( 'jquery_script', plugin_dir_url( __FILE__ ) . '../public/js/jquery-3.4.1.min.js', array ( 'jquery' ), '3.4.1', true);
    wp_enqueue_script( 'popper_script', plugin_dir_url( __FILE__ ) . '../public/js/popper.js', array ('poop'), '1.15.0', true);
    wp_enqueue_script( 'bootstrap_script', plugin_dir_url( __FILE__ ) . '../public/js/bootstrap.min.js', array (), 'v4.1.3', true);
    wp_enqueue_script( 'bootbox-min_script', plugin_dir_url( __FILE__ ) . '../public/js/bootbox.min.js', array (), '5.1.1', true);
    wp_enqueue_script('datepicker_js', plugin_dir_url( __FILE__ ) . '../public/js/bootstrap-datepicker.min.js');

}

function my_script_enqueuer()
{
    wp_register_script("ajaxHandle", WP_PLUGIN_URL . '/combat-plugin/public/js/combat-custom.js', array(), null, true);
    wp_enqueue_script('ajaxHandle');
    wp_localize_script('ajaxHandle', 'ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
}