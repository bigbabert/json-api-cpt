<?php

/*
  Controller name: cpt
  Controller description: JSON API - CPT RESTful Allow to manage custom post type from API: get from type,id,name,slug; delete, update, pubblish,
  Controller Author: Alberto Cocchiara
  8 Aug, 2014
 */

class JSON_API_cpt_Controller {

    public function cpt_info() {
        return array(
            'version' => 'v1.0'
        );
    }

    public function cpt_query() {
        //Get all Posts from Posts type name
        global $json_api;
        global $post;
        global $wp_post_types;
        if (isset($_GET["cpt_name"])) {

            $posts_name_cpt_api = $_GET["cpt_name"];

            if (isset($_GET["cpt_status"])) {
                $posts_status_cpt_api = $_GET["cpt_status"];
            } else {
                $posts_status_cpt_api = "publish";
            }
            $query = new WP_Query(array(
                'post_type' => $posts_name_cpt_api, 
                'post_status' => $posts_status_cpt_api,
                'meta_query' => array(
		array(
			'compare'   => '!=',
			'type'      => 'UNSIGNED',
		),
	),
                ));
            $results = $query->get_posts();

            if ($results) {

            return array(
                    'description' => 'post type:' . $posts_name_cpt_api,
                    'post' => $results,
                    );
            // Restore original post data.
            wp_reset_postdata();
            } else {
                $json_api->error("Please insert valid Post Type Name");
            // Restore original post data.
            wp_reset_postdata();
            }
        } else {
            $json_api->error("Please format your api like '?cpt_name=your_post_type' and optionally you can select the status with '&cpt_status=draft'");
        }
    }

    public function cpt_get() {
        //Get Post from ID or from slug
        global $json_api;
        global $post;
        global $wp_post_types;

        //Get post from ID
        if (isset($_GET["cpt_id"])) {

            $posts_id_cpt_api = $_GET["cpt_id"];

            $results_id = get_post($posts_id_cpt_api);
           if ($results_id) {
            $result_id_meta =  get_post_meta($results_id->ID);
            $result_id_image = get_the_post_thumbnail($results_id->ID);
            
            return array(
                    'description' => 'post type:' . $results_id->post_type,
                    'post' => $results_id,
                    'post_data' => $result_id_meta,
                    'post_image' => $result_id_image
                );
            // Restore original post data.
            wp_reset_postdata();
            } else {
                $json_api->error("Please insert valid ID");
            // Restore original post data.
            wp_reset_postdata();
            }
        }  else {
            $json_api->error("Please format your api like '?cpt_id=your_post_id'");
        }
    }
}
