<?php
/**
 * Created by PhpStorm.
 * User: ivaylo
 * Date: 19.4.2019 г.
 * Time: 17:13
 */

function combat_ajax_error_response($message = 'Invalid or missing parameters.') {
    http_response_code(400);
    echo json_encode(array('status' => 'error', 'message' => $message));
    die();
}


//add_action('wp_ajax_get_product', 'combat_ajax_get_product');
function combat_ajax_get_product() {
    $product_id = $_REQUEST['id'];
    if(isset($product_id) && !is_null($product_id = filter_var($product_id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE))) {
        $result = combat_call_api("product/getProduct", array('id' => $product_id));
        echo json_encode($result['body']);
    } else {
        combat_ajax_error_response();
    }

    die();
}

//add_action('wp_ajax_edit_product', 'combat_ajax_edit_product');
function combat_ajax_edit_product() {
    $params = [];
    $params += ['id' => $_REQUEST['id']];
    $params += ['name' => $_REQUEST['name']];
    $params += ['price' => $_REQUEST['price']];
    $params += ['category_id' => $_REQUEST['category_id']];
    $result = combat_call_api("product/editProduct", $params);
    echo json_encode($result['body']);

    die();
}

//add_action('wp_ajax_upload_image', 'combat_ajax_upload_image');
function combat_ajax_upload_image() {
    $params = [];
    $params['file'] = $_REQUEST['file'];
    $result = combat_call_api("product/uploadImage", $params);
    echo json_encode($result['body']);

    die();
}