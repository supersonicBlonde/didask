<?php

add_action( 'wp_ajax_nopriv_get_progress_bar', 'get_progress_bar' );
add_action( 'wp_ajax_get_progress_bar', 'get_progress_bar' ); 

function get_progress_bar() {

	$id_parcours = $_POST['parcours'];

	echo json_encode(get_status_progression($id_parcours));

	wp_die();
}


// return the staus of progress (percent, completed, number of episodes achieved)
function get_status_progression( $id_parcours) {


	global $wpdb;

	$completed = 0;

	$episodes = get_field('episodes' , $id_parcours);

	$episodes_number = count($episodes);
	// init the array to be returned
	$progress_ar = [];

	$id_user = get_current_user_id();
	
	// init an array where the status of episodes are gonna be stored and init at 0
	$status_ar = [];
	foreach($episodes as $episode) {
		$status_ar[$episode->ID] = 0;
	}

	//get the status of episodes and store in status array
	$results = $wpdb->get_results("SELECT * FROM tracking WHERE id_user = $id_user AND id_parcours = $id_parcours", ARRAY_A);
	foreach($results as $r) {
	 	if($r['id_parcours'] == $id_parcours) {
	 		if(array_key_exists($r['id_episode'], $status_ar)) {
	 			$status_ar[$r['id_episode']] = intval($r['status']);
	 		}
	 	}
	}

	// we count the frequency of 0 and 1 in status array
	$count = array_count_values($status_ar);

	// check in database how many lines haves status 1
	$achieved = (isset($count[1]) && ($count[1] > 0))?$count[1]:0;

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

// check the records of user and take the first record to get the main parcours 
// return the first row
/*function check_parcours() {
	$id_user = get_current_user_id();
	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM tracking WHERE id_user = $id_user ORDER BY date_completed ASC", ARRAY_A);
	return (!empty($results))?$results[0]:0;
}*/

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

	global $wpdb;

	$episodes = get_field('episodes' , $id_parcours); 
	$episodes_number = count($episodes); 

	/**********************************
		STATUS 
		************************************/

	// init an array where the status of episodes are gonna be stored and init at 0
	$status_ar = [];
	foreach($episodes as $episode) {
		$status_ar[$episode->ID] = 0;
	}
	//get the status of episodes and store in status array
	$results = $wpdb->get_results("SELECT * FROM tracking WHERE id_user = $id_user AND id_parcours = $id_parcours", ARRAY_A);
	foreach($results as $r) {
	 	if($r['id_parcours'] == $id_parcours) {
	 		if(array_key_exists($r['id_episode'], $status_ar)) {
	 			$status_ar[$r['id_episode']] = intval($r['status']);
	 		}
	 	}
	}


	// we count the frequency of 0 and 1 in status array
	$count = array_count_values($status_ar);

	$achieved = (isset($count[1]) && ($count[1] > 0))?$count[1]:0;

	if($achieved == $episodes_number) {
		$completed = 1;
	}


	return $completed;

}


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
		        'principal' => 1
		    ), 
		    array( 'id_user' => $id_user , 'id_parcours' => $id_parcours ), 
		    array( 
		        '%d'
		    ), 
		    array( '%d' , '%d' ) 
		);
	}
}

function is_any_parcours_completed() {
	
	$id_user = get_current_user_id();
	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM parcours_user WHERE id_user = $id_user AND completed = 1", ARRAY_A);
	if(!empty($results)) return true;	
	return false;
}



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
		        'date_last_done' => date( "Y-m-d h:i:s", time() ),
		        'status' => 1
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
	else {
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
		
	}

	

	// check if one parcours is complete
	$is_any_parcours_completed = is_any_parcours_completed();
	$is_current_completed = is_current_parcours_completed($id_user , $id_episode , $id_parcours);

	if(!$is_any_parcours_completed && !$is_current_completed) {
		delete_all_principal();
		save_parcours($id_parcours, 1, 0);
		$retour = 'aucun complet , courant incomplet';
	}
	else if(!$is_any_parcours_completed && $is_current_completed) {
		delete_all_principal();
		save_parcours($id_parcours, 1 , 1);
		$retour = 'aucun complet , courant complet';
	}
	else if($is_any_parcours_completed && !$is_current_completed) {
		save_parcours($id_parcours, 0 , 0);
		$retour = '1 complet , courant incomplet';
	}
	else if($is_any_parcours_completed && $is_current_completed) {
		save_parcours($id_parcours, 0, 1);
		$retour = '1 complet , courant complet';
	}
	

	
	$result = ['insert' => $db, 'index' => $index , 'id_episode' => $id_episode , 'completed' => $is_current_completed, 'retour' => $retour];

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

   	global $wpdb;

   	$updated = $wpdb->update( 
	    'tracking', 
	    array( 
	        'status' => 0
	    ), 
	    array( 'id_user' => $id_user , 'id_episode' => $id_episode , 'id_parcours' => $id_parcours ), 
	    array( 
	        '%s'
	    ), 
	    array( '%d' ) 
	);
	

	$updated = ['update' => $updated, 'index' => $index, 'id_episode' => $id_episode , 'id_parcours' => $id_parcours];
	echo json_encode($updated);



    
    wp_die();
}