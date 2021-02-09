<?php

/*
	
@package didask
	
	========================
		THEME CUSTOM POST TYPES
	========================
*/




	
add_action( 'init', 'didask_parcours' );
add_action( 'init', 'didask_parcours_tax' );
add_action( 'init', 'didask_episode' );
add_action( 'init', 'didask_episode_tax' );





function didask_parcours() {
	$labels = array(
		'name' 				=> 'Parcours',
		'singular_name' 	=> 'Parcours',
		'menu_name'			=> 'Parcours',
		'name_admin_bar'	=> 'Parcours'
	);
	
	$args = array(
		'labels'			=> $labels,
		'show_ui'			=> true,
		'show_in_menu'		=> true,
		'capability_type'	=> 'post',
		'hierarchical'		=> true,
		'has_archive'		=> true,
		'menu_position'		=> 10,
		'public'			=> true,
		'menu_icon'			=> 'dashicons-clipboard',
		'supports'			=> array( 'title' ,  'thumbnail' )
	);
	
	register_post_type( 'parcours', $args );
	
}


function didask_parcours_tax() {
	
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

	register_taxonomy( 'parcours-category', array( 'parcours' ), $args );
}


function didask_episode() {
	$labels = array(
		'name' 				=> 'Activités',
		'singular_name' 	=> 'Activité',
		'menu_name'			=> 'Activités',
		'name_admin_bar'	=> 'Activités'
	);
	
	$args = array(
		'labels'			=> $labels,
		'show_ui'			=> true,
		'show_in_menu'		=> true,
		'capability_type'	=> 'post',
		'hierarchical'		=> true,
		'has_archive'		=> true,
		'menu_position'		=> 10,
		'menu_icon'			=> 'dashicons-nametag',
		'supports'			=> array( 'title', 'author', 'thumbnail' )
	);
	
	register_post_type( 'episodes', $args );
	
}

function didask_episode_tax() {
	
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => __( 'Themes' ),
		'singular_name'     => __( 'Theme' ),
		'menu_name'         => __( 'Theme'),
	);

	$args = array(
		'hierarchical'      => false,
		'public'			=> true,	
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
	);

	register_taxonomy( 'episode-category', array( 'episodes' ), $args );
}

