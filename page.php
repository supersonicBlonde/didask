<?php
/**
* Page by default
*
* @package didask
*/

get_header();
?>



	<div class="page-content">

		<div class="section under-header">
			
		</div>

		

		<div class="container">

			<div class="row">

				<div class="col-12">
						<?php

						// Start the Loop.
						while ( have_posts() ) :
							the_post();

							get_template_part( 'template-parts/content/content', 'page' );

						endwhile; 

						?>

					</div>

			</div>

		</div>


		
	</div>	




<?php get_footer(); ?>