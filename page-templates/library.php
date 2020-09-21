<?php
/**
* Template Name: Library
*
* @package didask
*/

// Init some variables
$logged = is_user_logged_in();

$textes = get_field('bibliotheque' , 'options');
get_header();
?>
<script>
	let x768 = window.matchMedia("(min-width: 768px)");
	let x576 = window.matchMedia("(min-width: 576px)");
	let x1200 = window.matchMedia("(min-width: 1200px)");
</script>
<?php if($logged): ?>

	<div class="page-content">

		<div class="section under-header">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<h1><?php the_title(); ?></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<h2 class="h4-sized"><?php echo $textes['texte_intro_page']; ?></h2>
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
									<div style="display:flex;align-items:center;">
									<img src="<?php echo get_field('icone' , 'episode-category_'.$episode['term']['id']); ?>">
									<h3 class="text-uppercase" style="margin-bottom:5px;"><?php echo $textes['titre_theme']; ?>&nbsp;<?php echo $episode['term']['name']; ?></h3>
									</div>
									<p style="font-size:1.5rem;padding-left:75px;"><?php echo $episode['term']['description']; ?></p>
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
								<div class="episodes-list section library">
									<?php foreach($episode['episodes'] as $key): 
										$args = array('post_type' => 'episodes' , 'p' => $key); 
										$query_episode = new WP_Query( $args );
										$labels = get_field('activite' , 'options');
										
										if ( $query_episode->have_posts() ): ?>
											
												<?php while ( $query_episode->have_posts() ): $query_episode->the_post(); ?>

													<?php 
													$couleur = get_field('couleur'); 
													?>

													<div class="episode-item mb-5" data-episode="<?php echo the_ID(); ?>">

														<?php
															
															
															$id_user = get_current_user_id();
															$episode_id = get_the_ID();
															$status_results = $wpdb->get_row( "SELECT * FROM tracking WHERE id_user = $id_user AND  id_episode = $episode_id", OBJECT );

															$checked = "";
															$label = '<span style="opacity:0">'.$labels['status_to_do'].'</span>';
															

															if(!empty($status_results)) {

																$checked = 'checked="checked"';
																$label = $labels['status_over_library'];
															}
												

															?>

														<div class="checkbox-discover">
															<label  for="progress"><span class="text-labl"><?php echo $label; ?></span></label>
														</div>

															<div class="colored" data-color="<?php echo $couleur; ?>" style="background-color:<?php echo $couleur; ?>;display: flex;">

															<div>
																<p class="mb-0 icone-line"><img src="<?php echo get_field('icone_episode'); ?>" class="pr-2" style="width:50px;"><span><?php echo get_field('description_episode'); ?></span></p>
																<h2 class="mt-2 text-uppercase episode-title"><?php the_title(); ?></h2>
															</div>

															</div><!-- .colored -->

													</div><!-- .episode-item -->

												<?php endwhile; ?>

												<?php $number_of_episodes = $query_episode->post_count; ?>

												
											
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


																		<div style="background:<?php echo $couleur; ?>" class="my-2 py-5 px-lg-5">
																			<div class="close"><img src="<?php echo get_template_directory_uri().'/img/close.svg'; ?>"></div>
																			
																			<?php //inside bloc ?>
																			<div class="row">
																				<div class="col-12 col-lg-6 px-5">
																					<div class="up-title"><?php echo $content['over_title']; ?></div>
																					<h3 class="pt-1"><?php echo $content['title']; ?></h3>
																					<div class="mb-5" style="font-size:1.5em;"><?php echo $content['sub_title']; ?></div>
																					
																					<?php if(count($content['icon_list']) > 0 ): ?>
																						<div>
																						<?php foreach($content['icon_list'] as $list): ?>
																							<div class="mb-5 icon-before icon-before-blue" style="display: flex;align-items: center;"><div><?php echo $list['paragraphe']; ?></div></div>
																						<?php endforeach; ?>
																						</div>
																					<?php endif; ?>
																				</div><!-- .col -->
																				<div class="col-12 col-lg-6 px-5 content">
																					<div style="font-size: 2em;font-weight: 600;" class="text-uppercase mb-2"><?php the_field('bloc_contenu_activite' , 'options'); ?></div>
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