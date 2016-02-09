<?php

/*

  Plugin Name: JSON API - CPT

  Plugin URI: http://www.parorrey.com/solutions/json-api-cpt/

  Description: Extends the JSON API for RESTful CPT get

  Version: 1.0
  
  Author: Alberto Cocchiara

  Author URI: http://altertech.it

  License: GPLv3

 */

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

define('JSON_API_cpt_HOME', dirname(__FILE__));


if (!is_plugin_active('json-api/json-api.php')) {

    add_action('admin_notices', 'pim_draw_notice_json_api_cpt');

    return;

}

add_filter('json_api_controllers', 'pimJsonApicptController');

add_filter('json_api_cpt_controller_path', 'setcptControllerPath');


function pim_draw_notice_json_api_cpt() {

    echo '<div id="message" class="error fade"><p style="line-height: 150%">';

    _e('<strong>JSON API cpt</strong> requires the JSON API plugin to be activated. Please <a href="http://wordpress.org/plugins/json-api/‎">install / activate JSON API</a> first.', 'json-api-cpt');

    echo '</p></div>';

}

function pimJsonApicptController($aControllers) {

    $aControllers[] = 'cpt';

    return $aControllers;

}



function setcptControllerPath($sDefaultPath) {

    return dirname(__FILE__) . '/controllers/CptCont_api.php';

}