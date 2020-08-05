<?php

/*
	
@package didask
	
	========================
		THEME CUSTOM POST TYPES
	========================
*/




	
add_action( 'init', 'didask_video' );
add_action( 'init', 'didask_port_tax' );

add_action( 'init', 'didask_team' );
add_action( 'init', 'didask_team_tax' );

	


/* portfolio CPT */
function didask_video() {
	$labels = array(
		'name' 				=> 'Portfolios',
		'singular_name' 	=> 'Portfolio',
		'menu_name'			=> 'Portfolios',
		'name_admin_bar'	=> 'Portfolio'
	);
	
	$args = array(
		'labels'			=> $labels,
		'show_ui'			=> true,
		'show_in_menu'		=> true,
		'capability_type'	=> 'post',
		'hierarchical'		=> true,
		'has_archive'		=> true,
		'menu_position'		=> 10,
		'menu_icon'			=> 'dashicons-video-alt2',
		'supports'			=> array( 'title', 'author', 'thumbnail' )
	);
	
	register_post_type( 'portfoliovideo', $args );
	
}

function didask_team() {
	$labels = array(
		'name' 				=> 'Teams',
		'singular_name' 	=> 'Team',
		'menu_name'			=> 'Teams',
		'name_admin_bar'	=> 'Team'
	);
	
	$args = array(
		'labels'			=> $labels,
		'show_ui'			=> true,
		'show_in_menu'		=> true,
		'capability_type'	=> 'post',
		'hierarchical'		=> true,
		'has_archive'		=> true,
		'menu_position'		=> 10,
		'menu_icon'			=> 'dashicons-universal-access-alt',
		'supports'			=> array( 'title', 'author', 'thumbnail' )
	);
	
	register_post_type( 'team', $args );
	
}

function didask_port_tax() {
	
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => __( 'Categories' ),
		'singular_name'     => __( 'Categorie' ),
		'menu_name'         => __( 'Catégorie'),
	);

	$args = array(
		'hierarchical'      => false,
		'public'			=> true,	
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
	);

	register_taxonomy( 'videos-category', array( 'portfoliovideo' ), $args );
}


function didask_team_tax() {
	
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => __( 'Categories' ),
		'singular_name'     => __( 'Categorie' ),
		'menu_name'         => __( 'Catégorie'),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'team-category' ),
	);

	register_taxonomy( 'team-category', array( 'team' ), $args );
}
