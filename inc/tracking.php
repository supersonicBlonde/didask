<?php


// get parcours principal
function get_parcours_principal() {
	global $wpdb;
	$id_user = get_current_user_id();

	$results = $wpdb->get_row("SELECT * FROM parcours_user WHERE id_user = $id_user AND principal = 1", ARRAY_A);
	return $results;

}

// return the status of progress (percent, completed, number of episodes achieved)
function get_status_progression( $id_parcours) {

	global $wpdb;

	$completed = 0;

	$episodes = get_field('episodes' , $id_parcours);

	$episodes_number = count($episodes);
	// init the array to be returned
	$progress_ar = [];

	$id_user = get_current_user_id();

	$rowcount = $wpdb->get_var("SELECT COUNT(*) FROM tracking WHERE id_user = $id_user AND id_parcours = $id_parcours");

	$achieved = $rowcount;
	
	if($achieved == $episodes_number) {
		$completed = 1;
	}


	$percent = round(($achieved * 100) / $episodes_number);

	$progress_ar['completed'] = $completed;
	$progress_ar['percent'] = $percent;
	$progress_ar['achieved'] = $achieved;
	$progress_ar['episodes_number'] = $episodes_number;

	return $progress_ar;
}

// check if given parcours existe
function is_parcours($id_parcours) {

	$id_user = get_current_user_id();
	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM parcours_user WHERE id_user = $id_user AND id_parcours = $id_parcours", ARRAY_A);
	if(!empty($results)) return false;
	return true;	
}

// check if the record of user / episode / parcours so we know if we insert a record or update a record
function check_record_exists($id_user , $id_episode , $id_parcours) {
	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM tracking WHERE id_user = $id_user AND id_parcours = $id_parcours AND id_episode = $id_episode", ARRAY_A);
	return $results;
}


// so we know if the parcours is completed
function is_current_parcours_completed($id_user , $id_episode , $id_parcours) {

	$completed = false;

	global $wpdb;

	$episodes = get_field('episodes' , $id_parcours); 
	$episodes_number = count($episodes); 

	$rowcount = $wpdb->get_var("SELECT COUNT(*) FROM tracking WHERE id_user = $id_user AND id_parcours = $id_parcours");

	if($rowcount == $episodes_number) $completed = true;

	return $completed;

}

//Save a record in parcours_user table
function save_parcours($id_parcours, $principal, $completed) {

	$id_user = get_current_user_id();
	global $wpdb;

	$results = $wpdb->get_results("SELECT * FROM parcours_user WHERE id_user = $id_user and id_parcours = $id_parcours", ARRAY_A);

	// check if record exists
	// save parcours for the first time
	if(empty($results)) {
		$db = $wpdb->insert( 
			    'parcours_user', 
			    array( 
			    	'id_user' => $id_user, 
			        'id_parcours' => $id_parcours,
			        'principal' => $principal,
			        'completed' => $completed
			    ), 
			    array( 
			        '%d',
			        '%d',
			        '%d',
			        '%d'
			    ) 
			);
	}
	else {
		$db = $wpdb->update( 
		    'parcours_user', 
		    array( 
		        'principal' => $principal
		    ), 
		    array( 'id_user' => $id_user , 'id_parcours' => $id_parcours ), 
		    array( 
		        '%d'
		    ), 
		    array( '%d' , '%d' ) 
		);
	}
}


// check if at least a parcours is completed
function is_any_parcours_completed() {
	
	$id_user = get_current_user_id();
	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM parcours_user WHERE id_user = $id_user AND completed = 1", ARRAY_A);
	if(!empty($results)) return true;	
	return false;
}

// set all parcours principal to 0
function delete_all_principal() {
	$id_user = get_current_user_id();
	global $wpdb;
	$db = $wpdb->update( 
		    'parcours_user', 
		    array( 
		        'principal' => 0
		    ),
		    array( 'id_user' => $id_user ), 
		    array( 
		        '%d'
		    ), 
		    array( 
		        '%d'
		    )
		);
}


// save a record in tracking tables
function save_episode($id_user, $id_parcours, $id_episode) {

	// check if activity has been already done one time
	$exists = check_record_exists($id_user , $id_episode , $id_parcours);

	global $wpdb;

	if(empty($exists)) {
   
		$db = $wpdb->insert( 
		    'tracking', 
		    array( 
		    	'id_user' => $id_user, 
		        'id_episode' => $id_episode,
		        'id_parcours' => $id_parcours,
		        'date_last_done' => date( "Y-m-d h:i:s", time() )
		    ), 
		    array( 
		        '%d',
		        '%d',
		        '%d', 
		        '%s',
		        '%d'
		    ) 
		);
		
	}
	/*else {
		$db = $wpdb->update( 
		    'tracking', 
		    array( 
		        'status' => 1
		    ), 
		    array( 'id_user' => $id_user , 'id_episode' => $id_episode , 'id_parcours' => $id_parcours ), 
		    array( 
		        '%s'
		    ), 
		    array( '%d' ) 
		);
	}*/

	return $db;
}

// delete a record if cancelled
function delete_episode($id_user, $id_parcours, $id_episode) {
	global $wpdb;

   	$updated = $wpdb->delete( 
	    'tracking', 
	    array( 'id_user' => $id_user , 'id_episode' => $id_episode , 'id_parcours' => $id_parcours ), 
	    array( 
	        '%d' , '%d', '%d'
	    )
	);

	return $updated;
}


// process the parcours to set principal and completed
function process_parcours($id_user, $id_parcours, $id_episode, $is_current_completed) {
	// check if one parcours is complete
	$is_any_parcours_completed = is_any_parcours_completed();

	if(!$is_any_parcours_completed && !$is_current_completed) {
		delete_all_principal();
		save_parcours($id_parcours, 1, 0);
		
	}
	else if(!$is_any_parcours_completed && $is_current_completed) {
		delete_all_principal();
		save_parcours($id_parcours, 1 , 1);
		
	}
	else if($is_any_parcours_completed && !$is_current_completed) {
		save_parcours($id_parcours, 0 , 0);
		
	}
	else if($is_any_parcours_completed && $is_current_completed) {
		save_parcours($id_parcours, 0, 1);
	}

}

// Ajax functions
add_action( 'wp_ajax_nopriv_save_tracking', 'track_progress' );
add_action( 'wp_ajax_save_tracking', 'track_progress' ); 


function track_progress() {
	check_ajax_referer( 'MY_NONCE_VAR', 'submitted_nonce' ); 


	$id = $_POST['id'];
	$id_user = get_current_user_id();
	$id_episode = $_POST['episode'];
	$id_parcours = $_POST['parcours'];
	$index = $_POST['item_index'];

	

	
	$db = save_episode($id_user, $id_parcours, $id_episode);

	
	
	$bloc_contenu_activite = get_field('bloc_contenu_activite', 'options');
	
	$is_current_completed = is_current_parcours_completed($id_user , $id_episode , $id_parcours);
	process_parcours($id_user, $id_parcours, $id_episode, $is_current_completed);
	
	$result = ['insert' => $db, 'index' => $index , 'id_episode' => $id_episode , 'completed' => $is_current_completed, 'texts' => $bloc_contenu_activite];

	echo json_encode($result);

	
    wp_die();
}


add_action( 'wp_ajax_nopriv_cancel_tracking', 'cancel_progress' );
add_action( 'wp_ajax_cancel_tracking', 'cancel_progress' ); 


function cancel_progress() {
	check_ajax_referer( 'MY_NONCE_VAR', 'submitted_nonce' ); 

	$id_user = get_current_user_id();
	$id_episode = $_POST['episode'];
	$id_parcours = $_POST['parcours'];
	$index = $_POST['item_index'];

	// delete the episode
	$updated = delete_episode($id_user, $id_parcours, $id_episode);
	$is_current_completed = is_current_parcours_completed($id_user , $id_episode , $id_parcours);

	process_parcours($id_user, $id_parcours, $id_episode, $is_current_completed);

	$bloc_contenu_activite = get_field('bloc_contenu_activite', 'options');
	

	$update = ['update' => $updated, 'index' => $index, 'id_episode' => $id_episode , 'id_parcours' => $id_parcours, 'completed' => $is_current_completed , 'texts' => $bloc_contenu_activite];
	echo json_encode($update);


    
    wp_die();
}

add_action( 'wp_ajax_nopriv_get_progress_bar', 'get_progress_bar' );
add_action( 'wp_ajax_get_progress_bar', 'get_progress_bar' ); 

function get_progress_bar() {

	$id_parcours = $_POST['parcours'];

	echo json_encode(get_status_progression($id_parcours));

	wp_die();
}


add_action( 'wp_ajax_nopriv_get_episode_status', 'get_status_episode' );
add_action( 'wp_ajax_get_episode_status', 'get_status_episode' ); 

function get_status_episode() {

	
	check_ajax_referer( 'MY_NONCE_VAR', 'submitted_nonce' ); 
	$status = false;
	$id_episode = $_POST['episode'];
	$id_parcours = $_POST['parcours'];

	$id_user = get_current_user_id();
	global $wpdb;

	$results = $wpdb->get_results("SELECT * FROM tracking WHERE id_user = $id_user and id_parcours = $id_parcours AND id_episode = $id_episode", ARRAY_A);
	if(!empty($results)) $status = true;

	$bloc_contenu_activite = get_field('bloc_contenu_activite', 'options');
	

	$response = ['status' => $status, 'texts' => $bloc_contenu_activite, 'id_episode' => $id_episode ];

	echo json_encode($response);


	wp_die();

}
