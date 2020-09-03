<?php
/**
* Template Name: Library
*
* @package didask
*/

// Init some variables
$logged = is_user_logged_in();

get_header();
?>

<?php if($logged): ?>

	<div class="page-content">

		<div class="section">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<h1>La Bibliothèque</h1>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						Explorez toutes les ressources disponibles et expérimentez à votre guise !
					</div>
				</div>
			</div>
		</div>

		<?php

		$episodes = list_posts_by_term('episodes' , 'episode-category' , array( 'taxonomy' => 'episode-category', 'hide_empty' => false));

		?>

		<div class="section" id="library">
			<div class="container">
				<?php 

					foreach($episodes as $episode): ?>
						<div class="row">
							<div class="col-12">
								<div class="theme-title">
									<img src="<?php echo get_field('icone' , 'episode-category_'.$episode['term']['id']); ?>">
									<div>Tous les épisodes sur le thème : <?php echo $episode['term']['name']; ?></div>
								</div>	
							</div><!-- .col-12 -->
						</div><!-- .row -->
						<div class="row">
							<div class="col-12">

								<?php 
								/*************************
										EPISODES LIST 
								************************/
								?>
								<div class="episodes-list" class="section">
									<?php foreach($episode['episodes'] as $key): 
										$args = array('post_type' => 'episodes' , 'p' => $key); 
										$query_episode = new WP_Query( $args );

										if ( $query_episode->have_posts() ): ?>
											
												<?php while ( $query_episode->have_posts() ): $query_episode->the_post(); ?>

													<?php 
													$couleur = get_field('couleur'); 
													?>

													<div class="episode-item mb-5" data-episode="<?php echo the_ID(); ?>">

														<div style="background-color:<?php echo $couleur; ?>" class="colored p-5" data-color="<?php echo $couleur; ?>">

														<div class="icone mb-5"><img src="<?php echo get_field('icone_episode'); ?>"></div>

															<p class="mb-0"><?php echo get_field('description_episode'); ?></p>
															<h2 class="mt-0"><?php the_title(); ?></h2>

														</div> <!-- .colored -->

													</div><!-- .episode-item -->

												<?php endwhile; ?>
											
										<?php endif; ?>

										<?php wp_reset_postdata(); ?>

									<?php endforeach; ?>
								</div><!-- .episodes-list -->	

								<?php 
								/*************************
										EPISODES CONTENT 
								************************/
								?>
								<div class="content-list">
									<?php foreach($episode['episodes'] as $key): 
											$args = array('post_type' => 'episodes' , 'p' => $key); 
											$query_episode = new WP_Query( $args );

											if ( $query_episode->have_posts() ): ?>
												
													<?php while ( $query_episode->have_posts() ): $query_episode->the_post(); 

														$content = get_field('episode_content'); 
						
														$couleur = get_field('couleur'); ?>

														<div class="content-episode-container">
															<div class="row">
																<div class="col-12">

																	<div  class="content-episode">


																		<div style="background:<?php echo $couleur; ?>" class="p-5">
																			
																			<?php //inside bloc ?>
																			<div class="row">
																				<div class="col-12 col-lg-6 px-5">
																					<div class="up-title"><?php echo $content['over_title']; ?></div>
																					<h3 class="pt-1"><?php echo $content['title']; ?></h3>
																					<div class="mb-5"><?php echo $content['sub_title']; ?></div>
																					
																					<?php if(count($content['icon_list']) > 0 ): ?>
																						<div>
																						<?php foreach($content['icon_list'] as $list): ?>
																							<div class="mb-5 icon-before icon-before-blue"><?php echo $list['paragraphe']; ?></div>
																						<?php endforeach; ?>
																						</div>
																					<?php endif; ?>
																				</div><!-- .col -->
																				<div class="col-12 col-lg-6 px-5 content">
																					<?php echo $content['content']; ?>
																				</div><!-- .col -->
																			</div><!-- .row -->
																			<?php //end inside bloc ?>

																		</div>

																	</div><!-- .content-episode -->


																</div><!-- .col-12 -->
															</div><!-- .row -->
														</div><!-- .content-episode-container -->



													<?php endwhile; ?>
											
											<?php endif; ?>
											
											<?php wp_reset_postdata(); ?>

									<?php endforeach; ?>
								</div><!-- .content-list -->

							</div><!-- .col-12 -->
						</div><!-- .row -->
					<?php endforeach; ?>
					
			</div><!-- .container -->					

		</div><!-- .section -->

<?php else: ?>

	<div class="page-content">
		
		<div class="logged-in-only">Vous devez être connecté pour accéder à ce contenu.</div>

	</div>

<?php endif; ?>


<?php get_footer(); ?>