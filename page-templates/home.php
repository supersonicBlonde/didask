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

	<section id="intro" class="scroll-after text-center">
		<div class="container">
			<div class="row">
				<div class="column col-lg-4 col-8 mx-auto text-center">
					<h1><?php echo $section_intro['title']; ?></h1>
					<p><?php echo $section_intro['paragraphe'] ?></p>
				</div>
			</div>
		</div>
	</section>

	<div id="home-section-2" class="section scroll-after center">
		<div class="container">
			<div class="row my-auto">
				<div class="col-12 col-lg-7 mb-3 column">
					<div class="embed-responsive embed-responsive-16by9"><?php echo $section_2col['video'] ?></div>
				</div>
				<div class="col-12 col-lg-5 column my-auto">
					<h2 class="h3-sized text-uppercase"><?php echo $section_2col['titre'] ?></h2>
					<p><?php echo $section_2col['paragraphe'] ?></p>
				</div>
			</div>
		</div>
	</div>

	<div id="home-section-3"  class="section">
		<div class="container">
			<div class="row">
				<div class="column col-lg-4 col-8 mx-auto text-center">
					<h2 class="h3-sized"><?php echo $section_intro_parcours['titre'] ?></h2>
					<p><?php echo $section_intro_parcours['paragraphe'] ?></p>
				</div>
			</div>
		</div>
	</div>

	<div class="section" id="home-section-4">
		<div class="container">
			
			<?php
	
				$args = array(
					'post_type' 		=> 'parcours',
					'posts_per_page'    => -1
				);
				
				$query_parcours = new WP_Query( $args );
	
				if ( $query_parcours->have_posts() ): ?>
				    <div class="parcours-container">
				    
				    <?php 
	
				    while ( $query_parcours->have_posts() ):
				        $query_parcours->the_post(); ?>
				    	<div class="row">
				    		<div class="col-12">
						        <div class="parcours-item">
						        	<div class="row">
						        		<div class="col-12 col-lg-2">
						        			<?php the_post_thumbnail('full'); ?>
						        		</div>
						        		<div class="col-12 col-lg-4">
						        			<div class="up-title">Parcours</div>
						        			<h2><?php the_title(); ?></h2>
						        			<p><?php echo count(get_field('episodes')); ?> épisodes à découvrir!</p>
						        			<p class="duration duration-white"><strong>Durée estimée : </strong><?php the_field('duration'); ?></p>
						        		</div>
						        		<div class="col-12 col-lg-6">
						        			<p><?php the_field('intro_text'); ?></p>
						        			<div class="text-center pt-2">
						        				<div class="default-btn"><a href="<?php the_permalink(); ?>">Démarrer</a></div>
						        			</div>
						        		</div>
						        	</div>
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