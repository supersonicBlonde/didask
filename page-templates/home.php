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


<?php if(!isset($progress) || $progress['achieved'] == 0): ?>
	<div class="page-content">

		<section id="intro" class="section text-center under-header">
			<div class="container">
				<div class="row">
					<div class="column col-l2 mx-auto text-center">
						<h1><?php echo $section_intro['title']; ?></h1>
					</div>
					<div class="row">
						<div class="column col-lg-6 col-8 mx-auto text-center">
							<p><?php echo $section_intro['paragraphe'] ?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="scroll-next text-center">
						<a href="#"><img src="<?php echo get_template_directory_uri().'/img/arrow-scroll.svg'?>"></a>
					</div>
				</div>
			</div>
		</section>

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
				<div class="row">
					<div class="col-12">
						<div class="scroll-next text-center">
							<a href="#"><img src="<?php echo get_template_directory_uri().'/img/arrow-scroll.svg'?>"></a>
						</div>
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
					        $query_parcours->the_post(); ?>
					    	<div class="row">
					    		<div class="col-12">
							        <div class="parcours-item">
							        	<div class="row">
							        		<div class="col-12 col-lg-3 img-abs-container">
							        			<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
							        		</div>
							        		<div class="col-12 col-lg-4">
							        			<div class="up-title">Parcours</div>
							        			<h2><?php the_title(); ?></h2>
							        			<p><?php echo count(get_field('episodes')); ?> épisodes à découvrir!</p>
							        			<p class="duration duration-white"><strong>Durée estimée : </strong><?php the_field('duration'); ?></p>
							        		</div>
							        		<div class="col-12 col-lg-5">
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

<?php else: ?>

	<div class="page-content">

		<section id="intro" class="scroll-after text-center section under-header">
			<div class="container">
				<div class="row">
					<div class="column col-12 mx-auto text-center">
						<h1><?php echo $section_intro['title']; ?></h1>
					</div>
					<div class="row">
						<div class="column col-lg-5 col-8 mx-auto text-center">
							<p><?php echo $section_intro['paragraphe'] ?></p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="scroll-next text-center">
							<a href="#"><img src="<?php echo get_template_directory_uri().'/img/arrow-scroll.svg'?>"></a>
						</div>
					</div>
				</div>
			</div>
		</section>


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
					        $progress = get_percent_progression( $main_parcours['id_parcours']); ?>
					    	<div class="row">
					    		<div class="col-12">
							        <div class="parcours-item">
							        	<div class="row">
							        		<div class="col-12 col-lg-2 img-abs-container">
							        			<?php the_post_thumbnail('full'); ?>
							        		</div>
							        		<div class="col-12 col-lg-4">
							        			<div class="up-title">Parcours</div>
							        			<h2><?php the_title(); ?></h2>
							        			<div id="progress-section">
													<div class="progress-text"><?php echo $progress['achieved'] ?> épisode<?php echo $progress['achieved'] > 1?'s':''?> terminé<?php echo $progress['achieved'] > 1?'s':''?> sur <?php echo $episodes_number; ?>
														<?php if($progress['completed'] == 1): ?>
															<span class="checkmark"></span>
														<?php endif; ?>
													</div>
													<div class="progress">
														<div class="bar" style="width:<?php echo $progress['percent']; ?>%">
														</div>
													</div>
												</div>
							        		</div>
							        		<div class="col-12 col-lg-6">
							        			<p><?php the_field('intro_text'); ?></p>
							        			<div class="text-center pt-2">
							        				<div class="default-btn"><a href="<?php the_permalink(); ?>"><?php echo get_text_btn($progress); ?></a></div>
							        			</div>
							        		</div>
							        	</div>
							        </div>
						    	</div>
						    </div>
					    	<div class="row">
								<div class="col-12">
									<div class="scroll-next text-center m-3">
										<a href="#"><img src="<?php echo get_template_directory_uri().'/img/arrow-scroll.svg'?>"></a>
									</div>
								</div>
							</div>
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

								        $progress = get_percent_progression(get_the_ID());
								        ?>
								    	<div class="row">
								    		<div class="col-12">
										        <div class="parcours-item">
										        	<div class="row">
										        		<div class="col-12 col-lg-2 img-abs-container">
										        			<?php the_post_thumbnail('full'); ?>
										        		</div>
										        		<div class="col-12 col-lg-4">
										        			<div class="up-title">Parcours</div>
										        			<h2><?php the_title(); ?></h2>
										        			<?php if($progress['achieved'] > 0): ?>
										        				<div id="progress-section">
																	<div class="progress-text"><?php echo $progress['achieved'] ?> épisode<?php echo $progress['achieved'] > 1?'s':''?> terminé<?php echo $progress['achieved'] > 1?'s':''?> sur <?php echo $episodes_number; ?>
																		<?php if($progress['completed'] == 1): ?>
																			<span class="checkmark"></span>
																		<?php endif; ?>
																	</div>
																	<div class="progress">
																		<div class="bar" style="width:<?php echo $progress['percent']; ?>%">
																		</div>
																	</div>
																</div>
																<?php else: ?>
												        			<p><?php echo count(get_field('episodes')); ?> épisodes à découvrir!</p>
												        			<p class="duration duration-white"><strong>Durée estimée : </strong><?php the_field('duration'); ?></p>
												        		<?php endif; ?>
										        		</div>
										        		<div class="col-12 col-lg-6">
										        			<p><?php the_field('intro_text'); ?></p>
										        			<div class="text-center pt-2">
										        				<div class="default-btn"><a href="<?php the_permalink(); ?>"><?php echo get_text_btn($progress); ?></a></div>
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
				</section>
			</div>
		
	</div>	

<?php endif; ?>


<?php get_footer(); ?>