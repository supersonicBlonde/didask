<?php
/**
* Template Name: Home
*
* @package didask
*/

get_header();
?>

<?php

// GROUPS
$section_intro = get_field('section_introduction_home');
$section_2col = get_field('bloc_2_colonnes');
$section_intro_parcours = get_field('presentation_des_parcours');


?>

<div class="page-content">

	<section id="intro" class="scroll-after center">
		<div class="container">
			<h1><?php echo $section_intro['title']; ?></h1>
			<p><?php echo $section_intro['paragraphe'] ?></p>
		</div>
	</section>

	<div class="section scroll-after">
		<div class="container">
			<div class="videoWrapper column"><?php echo $section_2col['video'] ?></div>
			<div class="column">
				<div class="fs-28 small-title fw-600 mb-small upc"><?php echo $section_2col['titre'] ?></div>
				<p><?php echo $section_2col['paragraphe'] ?></p>
			</div>
		</div>
	</div>

	<div class="section center">
		<div class="container">
			<div>
				<div class="fs-28 small-title fw-600 mb-small upc"><?php echo $section_intro_parcours['titre'] ?></div>
				<p><?php echo $section_intro_parcours['paragraphe'] ?></p>
			</div>
		</div>
	</div>

	<div id="parcours-list" class="section">
		<div class="container">
			
			<?php

				$args = array(
					'post_type' 		=> 'parcours',
					'posts_per_page'    => -1
				);
				
				$query_parcours = new WP_Query( $args );

				if ( $query_parcours->have_posts() ): ?>
				    <div class="parcours-list">
				    
				    <?php 

				    while ( $query_parcours->have_posts() ):
				        $query_parcours->the_post(); ?>
				    
				        <div class="parcours-item">
				        	<div class="column"><?php the_post_thumbnail('medium'); ?></div>
				        	<div class="column">
				        		<div class="super-title">Parcours</div>
				        		<h2><?php the_title(); ?></h2>
				        		<div class="fs-20"><?php echo count(get_field('episodes')); ?> épisodes à découvrir!</div>
				        		<div class="duration fs-20"><strong>Durée estimée : </strong><?php the_field('duration'); ?></div>
				        	</div>
				        	<div class="column">
				        		<p class="fs-20 lh-x2"><?php the_field('intro_text'); ?></p>
				        		<div>
				        			<div class="default-btn"><a href="/home-parcours">Démarrer</a></div>
				        		</div>
				        	</div>
				        </div>
				    

				    <?php endwhile; ?>
				    

				    </div><!-- .parcours-list -->

				<?php endif; 
				wp_reset_postdata();
				?>

		</div>
	</div>
	
</div>



<?php get_footer(); ?>