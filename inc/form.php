<?php

add_action( 'wp_ajax_nopriv_load_form', 'load_form' );
add_action( 'wp_ajax_load_form', 'load_form' ); 


function load_form() {
	check_ajax_referer( 'MY_NONCE_VAR', 'submitted_nonce' ); 

    ob_start();
    get_template_part('template-parts/connect', 'page');
    wp_send_json_success(ob_get_clean());
    
    wp_die();
}