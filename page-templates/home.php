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
$logged = is_user_logged_in();
$section_intro = get_field('section_introduction_home');
$section_2col = get_field('bloc_2_colonnes');
$section_intro_parcours = get_field('presentation_des_parcours');

if($logged):
$main_parcours = check_parcours();
if($main_parcours) {
	$progress = get_percent_progression(  $main_parcours['id_parcours']);
}


 endif;
?>


<?php if(!isset($progress)): ?>
	<div class="page-content">

		<?php  get_template_part( 'template-parts/content', 'intro', $section_intro ); ?>


		<div id="home-section-2" class="section center">
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
					<div class="column col-lg-5 col-8 mx-auto text-center">
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
					        $query_parcours->the_post(); 

					       $args = array(
					       	'number_of_episodes' 	=> count(get_field('episodes')),
					       	'duration'   		 	=> get_field('duration'),
					       	'intro_text' 			=> get_field('intro_text')
					       );

					        get_template_part('template-parts/content' , 'parcours' , $args); ?>

		
					    <?php endwhile; ?>
					    
		
					    </div><!-- .parcours-list -->
		
					<?php endif; 
					wp_reset_postdata();
					?>
		
			</div>
		</div>
		
	</div>

<?php else: ?>

	<div class="page-content">

		<?php  get_template_part( 'template-parts/content', 'intro', $section_intro ); ?>


		<div class="section">
			<div class="container">
				<div class="row">
					<div class="column col-lg-5 col-8 mx-auto text-center mt-5">
						<h2 class="h3-sized">VOTRE PARCOURS</h2>
					</div>
				</div>
			</div>
		</div>

		<div class="section" id="home-section-4">
			<div class="container">
				
				<?php
		 			
					$args = array(
						'post_type' 		=> 'parcours',
						'posts_per_page'    => 1,
						'p' => $main_parcours['id_parcours']
					);
					
					$query_parcours = new WP_Query( $args );
		
					if ( $query_parcours->have_posts() ): ?>
					    <div class="parcours-container">
					    
					    <?php 
		
					    while ( $query_parcours->have_posts() ):
					        $query_parcours->the_post(); 

					        // get list of episodes
					        $episodes = get_field('episodes' , $main_parcours['id_parcours']);
					        
					        $episodes_number = count($episodes);
					        $progress = get_percent_progression( $main_parcours['id_parcours']); 
					        


					        $args = array(
					        	'progress' 				=> $progress,
					        	'number_of_episodes' 	=> $episodes_number,
					        	'intro_text'			=> get_field('intro_text')
					        );

					        get_template_part('template-parts/content' , 'parcours-logged' , $args);

					        ?>
					    	
					    	
							<?php if($progress['completed'] == 1): ?>
									<section id="intro" class="text-center">
										<div class="container">
											<div class="row">
												<div class="column col-lg-4 col-8 mx-auto text-center">
													<h1>Bravo !</h1>
													<p>Avec ce premier parcours terminé, votre équipe a déjà fait un grand pas en avant. La suite de l’histoire s’écrit essentiellement dans votre quotidien, en essayant d’appliquer ce que vous avez appris ensemble.</p>
												</div>
											</div>
											<div class="row">
												<div class="col-12">
													<div class="up-btn">Pour explorer librement le reste de ce kit</div>
													<div class="default-btn"><a href="/bibliotheque">Aller à la bibliothèque</a></div>
												</div>
											</div>
									</section>
							<?php endif; ?>
					    <?php endwhile; ?>
					    
		
					    </div><!-- .parcours-list -->
		
					<?php endif; 
					wp_reset_postdata();
					?>
		
			</div>
		</div>

		<div id="parcours-secondaire" style="display:block;background:transparent;">
			

				<section id="autre-parcours" class="section">
					<div class="container">
						<div class="row">
							<div class="col-12 mx-auto text-center">
								<div class="h3-sized">SI VOUS SOUHAITEZ CHANGER DE PARCOURS</div>
							</div>
						</div>
					</div>

					<div class="section">
						<div class="container">
							
							<?php
					
								$args = array(
									'post_type' 		=> 'parcours',
									'posts_per_page'    => -1,
									'post__not_in' => array($main_parcours['id_parcours']) 
								);
								
								$query_parcours = new WP_Query( $args );
								
					
								if ( $query_parcours->have_posts() ): ?>

								    <div class="parcours-container">
								    
								    <?php 
					
								    while ( $query_parcours->have_posts() ):
								        $query_parcours->the_post(); 

								        // get list of episodes
								        $episodes = get_field('episodes');
								        
								        $episodes_number = count($episodes);

								        $progress = get_percent_progression(get_the_ID());

								         $args = array(
								        	'progress' 				=> $progress,
								        	'number_of_episodes' 	=> $episodes_number,
								        	'intro_text'			=> get_field('intro_text')
								        );

								        get_template_part('template-parts/content' , 'parcours-logged' , $args); ?>
								    	
								    
					
								    <?php endwhile; ?>
								    
					
								    </div><!-- .parcours-list -->
					
								<?php endif; 
								wp_reset_postdata();
								?>
					
						</div>
					</div>
				</section>
			</div>
		
	</div>	

<?php endif; ?>


<?php get_footer(); ?>