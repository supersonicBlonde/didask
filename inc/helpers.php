<?php  

/**
* Get posts and group by taxonomy terms.
* @param string $posts Post type to get.
* @param string $terms Taxonomy to group by.
* @param integer $count How many post to show per taxonomy term.
*/
function list_posts_by_term( $posts, $tax, $terms, $posts_per_page = -1 ) {
	$tax_terms = get_terms( $terms);

	$posts_ar = [];
	$count = 0;
	
	foreach ( $tax_terms as $term ) {
		$posts_ar[$count]['term']['name'] =  $term->name;
		$posts_ar[$count]['term']['id'] =  $term->term_id;

		   $args = array(
		    'posts_per_page' => $posts_per_page,
		    'tax_query' => array(
			    array(
			      'taxonomy' => $tax,
			      'field' => 'slug', 
			      'terms' => $term->slug, /// Where term_id of Term 1 is "1".
			      'include_children' => false
			    )
			  ),
		    'post_type' => $posts,
	     );
		    $tax_terms_posts = get_posts($args);
		    $episodes_ar = [];
		    foreach ( $tax_terms_posts as $post ) {
		    	$episodes_ar[] = $post->ID;
		    	$posts_ar[$count]['episodes'] = $episodes_ar;
		    }
		$count++;
	}
	wp_reset_postdata();
	return $posts_ar;
	
}





function didask_get_cpt_taxonomies($post_id, $taxonomy) {
	$tax_ar = [];
	$terms = wp_get_post_terms( $post_id, $taxonomy );
	foreach ( $terms as $term ) {
		$tax_ar[$term->slug] =  $term->name;
	}
	return $tax_ar;
}

function didask_echo_cpt_taxonomies($post_id, $taxonomy) {
	$ar = didask_get_cpt_taxonomies($post_id, $taxonomy);
	
	$start_str = "<ul>";
	$end_str = "</ul>";
	$str = "";


	if(count($ar) == 0 )
		return;

	foreach($ar as $k => $v) {
		$str .= '<li><a href="/videos-category/'.$k.'">'.$v.'</a><li>';
	}

	return $start_str.$str.$end_str;
}

function didask_get_attachment($num = 1)
{
    $output = '';
    if (has_post_thumbnail() && $num == 1):
        $output = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())); else:
        $attachments = get_posts(array(
            'post_type' => 'attachment',
            'posts_per_page' => $num,
            'post_parent' => get_the_ID(),
        ));
    if ($attachments && $num == 1):
            foreach ($attachments as $attachment):
                $output = wp_get_attachment_url($attachment->ID);
    endforeach; elseif ($attachments && $num > 1):
            $output = $attachments;
    endif;

    wp_reset_postdata();

    endif;

    return $output;
}