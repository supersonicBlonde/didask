<?php  

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