<?php
/**
* Page by default
*
* @package didask
*/

get_header();
?>

<div>
	<?php

	// Start the Loop.
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content/content', 'page' );

	endwhile; 

	?>
</div>

<?php get_footer(); ?>