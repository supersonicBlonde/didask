<?php

// return the staus of progress (percent, completed, number of episodes achieved)
function get_percent_progression( $id_parcours) {


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
function check_parcours() {
	$id_user = get_current_user_id();
	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM tracking WHERE id_user = $id_user ORDER BY date_completed ASC", ARRAY_A);
	return (!empty($results))?$results[0]:0;
}


// check if the record of user / episode / parcours so we know if we insert a record or update a record
function check_record_exists($id_user , $id_episode , $id_parcours) {
	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM tracking WHERE id_user = $id_user AND id_parcours = $id_parcours AND id_episode = $id_episode", ARRAY_A);
	return $results;
}


// so we know if the parcours is completed
function get_progression($id_user , $id_episode , $id_parcours) {

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


// Akax functions
add_action( 'wp_ajax_nopriv_save_tracking', 'track_progress' );
add_action( 'wp_ajax_save_tracking', 'track_progress' ); 


function track_progress() {
	check_ajax_referer( 'MY_NONCE_VAR', 'submitted_nonce' ); 



	$id = $_POST['id'];
	$id_user = get_current_user_id();
	$id_episode = $_POST['episode'];
	$id_parcours = $_POST['parcours'];
	$index = $_POST['item_index'];

	$exists = check_record_exists($id_user , $id_episode , $id_parcours);
	global $wpdb;

	

	if(empty($exists)) {
   
		$db = $wpdb->insert( 
		    'tracking', 
		    array( 
		    	'id_user' => $id_user, 
		        'id_episode' => $id_episode,
		        'id_parcours' => $id_parcours,
		        'date_completed' => date( "Y-m-d h:i:s", time() ),
		        'status' => 1
		    ), 
		    array( 
		        '%d',
		        '%d',
		        '%d', 
		        '%s',
		        '%s'
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

	$completed = get_progression($id_user, $id_episode, $id_parcours);

	$result = ['insert' => $db, 'index' => $index , 'id_episode' => $id_episode , 'completed' => $completed];

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