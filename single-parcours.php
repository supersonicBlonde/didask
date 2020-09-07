<?php
/**
* 
*
* @package didask
*/


global $post;



// Init some variables
$logged = is_user_logged_in();
$episodes = get_field('episodes');
$id_user = get_current_user_id();
$id_parcours = $post->ID;



// get status
$progress = get_percent_progression( $id_parcours);


get_header();
?>



<?php if($logged): ?>

	<div class="page-content" id="single-parcours">

			<div id="header-single-parcours">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 col-12 my-auto scroll-after column">
							<div class="up-title">Parcours</div>
							<h1 class="mt-1"><?php the_title(); ?></h1>
							<p><?php the_field('texte_introduction_single'); ?></p>
							<div id="progress-section">
								<div class="progress-text"><?php echo $progress['achieved'] ?> épisode<?php echo $progress['achieved'] > 1?'s':''?> terminé<?php echo $progress['achieved'] > 1?'s':''?> sur <?php echo $progress['episodes_number']; ?>
									<?php if($progress['completed'] == 1): ?>
										<span class="checkmark"></span>
									<?php endif; ?>
								</div>
								<div class="progress">
									<div class="bar" style="width:<?php echo $progress['percent']; ?>%">
									</div>
								</div>
							</div>
							<?php if($progress['completed'] == 1): ?>
								<div class="completed">
									<div>Bravo, vous avez terminé le parcours.</div>
									<div class="default-btn"><a href="#">Poursuivre l'expérience</a></div>
								</div>
							<?php endif; ?>

						</div>
						<div class="col-lg-6 col-12 img-abs-container"><?php the_post_thumbnail('full'); ?></div>
					</div>
				</div>
			</div><!-- #header-single-parcours -->


			<?php 
			/*******************************************************
						PAGE TITLE
			*******************************************************/
			 ?>
			<div class="section" id="episode-section-2">
				<div class="container">
					<div class="row">
						<div class="col-12 text-center">
							<div class="page-title">Episodes</div>
						</div>
					</div>
				</div>
			</div><!-- #episode-section-2 -->

			<?php 

				

				if(count($episodes) > 0):

			?>


			<?php 
			/*******************************************************
						SECTION EPISODES LIST
			*******************************************************/
			 ?>
			<div class="container">
				
				<div class="episodes-list" class="section">


					<?php
						foreach($episodes as $episode):

							$icone = get_field('icone_episode' , $episode->ID);
						    $content = get_field('episode_content' , $episode->ID);
						    $couleur = get_field('couleur' , $episode->ID);
						    $description = get_field('description_episode' , $episode->ID);
					?>



					<div class="episode-item mb-5" data-episode="<?php echo $episode->ID; ?>">

						<?php

						$status_results = $wpdb->get_row( "SELECT status FROM tracking WHERE id_user = $id_user AND id_parcours = $id_parcours AND id_episode = $episode->ID", OBJECT );

						$checked = "";
						$label = "A découvrir";
				

						if(isset($status_results->status) && $status_results->status == '1') {

							$checked = 'checked="checked"';
							$label = 'Terminé';
						}
			

						?>
						<div class="checkbox-discover">
							<label  for="progress"><span class="text-label"><?php echo $label; ?></span>
							  <input type="checkbox" name="progress" value="" disabled <?php echo $checked; ?>>
							  <span class="checkmark-input"></span>
							</label>
						</div>

						<!-- <div class="checkbox-discover">
							<input type="checkbox" ><label class="pl-2" for="progress"> <?php echo $label; ?></label>
						</div> --><!-- .checkbox-discover -->

						<div style="background-color:<?php echo $couleur; ?>" class="colored p-5" data-color="<?php echo $couleur; ?>">

							<div class="icone mb-5"><img src="<?php echo $icone; ?>"></div>

							<p class="mb-0"><?php echo $description; ?></p>
							<h2 class="mt-0"><?php echo $episode->post_title; ?></h2>

						</div><!-- .colored -->

					</div><!-- .episode-item -->



					<?php endforeach; ?>




				</div><!-- .episodes-list -->





			<?php 
			/*******************************************************
						CONTENT EPISODE BLOCK
			*******************************************************/
			 ?>



			 	<div class="content-list">
			 	
			 	<?php 

					foreach($episodes as $episode): 

						$content = get_field('episode_content' , $episode->ID); 
					
						$couleur = get_field('couleur' , $episode->ID);

						$status_results = $wpdb->get_row( "SELECT status FROM tracking WHERE id_user = $id_user AND id_parcours = $id_parcours AND id_episode = $episode->ID", OBJECT );


						$status = 0;

						if(isset($status_results->status) && $status_results->status == '1') {

							$status = 1;
						}

				?>


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

									<?php //save-section ?>
									<div class="row">
										<div class="col-12 mx-auto">
											<div class="save-section my-5" data-episode_saved="<?php echo $episode->ID; ?>" data-parcours="<?php echo $id_parcours; ?>">
												<?php if($status == 0): ?>
													<div class="text-uppercase pb-2">Vous avez terminé ?</div>
													<div class="default-btn btn-invert"><a href="/" class="track-btn">Cliquez ici pour l'enregistrer</a></div>
												<?php else: ?>
													<div class="text-uppercase pb-2">Vous avez déja fait ce module</div>
													<div><a href="#" class="cancel-track">Annuler</a></div>
												<?php endif; ?>
											</div>
										</div>
									</div>
									<?php //end save section ?>

								</div><!-- .content-episode -->


							</div><!-- .col-12 -->
						</div><!-- .row -->
					</div><!-- .content-episode-container -->

				<?php endforeach; ?>

				</div>
				

			 </div><!-- .container -->



			<?php endif; ?>


			<?php // section autres episodes ?>

			<?php $display = ($progress['completed'] == 1)?'block':'none'; ?>

			<div id="parcours-secondaire" style="display:<?php echo $display; ?>">
				
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

				<section id="autre-parcours">
					<div class="container">
						<div class="row">
							<div class="col-12 mx-auto">
								<div>Si vous souhaitez suivre un autre parcours :</div>
							</div>
						</div>
					</div>

					<div class="section">
						<div class="container">
							
							<?php
					
								$args = array(
									'post_type' 		=> 'parcours',
									'posts_per_page'    => -1,
									'post__not_in' => array($id_parcours) 
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
				</section>



			</div>



	</div><!-- .page-content -->

<?php else: ?>

	<div class="page-content">
		
		<div class="logged-in-only">Vous devez être connecté pour accéder à ce contenu.</div>
	</div>
<?php endif; ?>


<?php get_footer(); ?>