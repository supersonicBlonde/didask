<?php

/*
	
@package didask

/*
	
	========================
		FRONT-END ENQUEUE FUNCTIONS
	========================
*/

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

function didask_load_scripts(){

	wp_enqueue_style( 'lato-font', 'https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap', array(), '', 'all'); 


	wp_enqueue_style( 'didask-style', get_stylesheet_uri(), array(), _S_VERSION );

	//wp_enqueue_style( 'main-css', get_template_directory_uri().'/dist/css/styles.min.css', array(), _S_VERSION );
	

	wp_enqueue_script( 'matchheight', '//cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.0/jquery.matchHeight-min.js', array('jquery'), '', true );


	//wp_enqueue_script( 'js', get_template_directory_uri().'/dist/js/scripts.min.js', array('slickjs','jquery'), '', true );

	wp_localize_script( 'js', 'ajax_js_obj', array(
                      'ajax_url' => admin_url( 'admin-ajax.php' ),
                      'the_nonce' => wp_create_nonce('MY_NONCE_VAR')
     ));
	
}
add_action( 'wp_enqueue_scripts', 'didask_load_scripts' );

	
	