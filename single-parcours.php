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
$labels =get_field('activite' , 'options');



// get status
$progress = get_status_progression( $id_parcours);


get_header();
?>



<?php if($logged): ?>

	<div class="page-content" id="single-parcours">

			<div id="header-single-parcours" class="section under-header">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 col-12 my-auto column">
							<div class="up-title">Parcours</div>
							<h1 class="mt-1"><?php the_title(); ?></h1>
							<p><?php the_field('texte_introduction_single'); ?></p>
							<div class="progress-section">
								<div class="progress-text" id="progress-text" style="display:inline;"><?php echo $progress['achieved'] ?> activité<?php echo $progress['achieved'] > 1?'s':''?> terminée<?php echo $progress['achieved'] > 1?'s':''?> sur <?php echo $progress['episodes_number']; ?>
									<?php $display = $progress['completed'] == 1?'inline':'none'; ?>
								</div>
								<span class="checkmark" id="checkmark" style="display:<?php echo $display; ?>"></span>
								<div class="progress">
									<div class="bar" id="bar" style="width:<?php echo $progress['percent']; ?>%">
									</div>
								</div>
							</div>
							<?php $display = $progress['completed'] == 1?'1':'0'; ?>
								<div class="completed" id="completed" style="opacity: <?php echo $display; ?>">
									<div>Bravo, vous avez terminé le parcours.</div>
									<div class="default-btn"><a href="/">Poursuivre l'expérience</a></div>
								</div>

						</div>
						<div class="col-lg-6 col-12 img-abs-container"><?php the_post_thumbnail('full'); ?></div>
					</div>
					<div class="row">
						<div class="col-12">
							<div class="scroll-next">
								<a href="#"><img src="<?php echo get_template_directory_uri().'/img/arrow-scroll.svg'?>"></a>
							</div>
						</div>
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
							<div class="page-title"><?php echo $labels['titre_page']; ?></div>
						</div>
					</div>
				</div>
			</div><!-- #episode-section-2 -->

			<?php 

				
				$number_of_episodes = count($episodes);
				if($number_of_episodes > 0):

			?>


			<?php 
			/*******************************************************
						SECTION EPISODES LIST
			*******************************************************/
			 ?>
			
			<div class="container">
				
				<div class="episodes-list section">


					<?php
						foreach($episodes as $episode):

							$icone = get_field('icone_episode' , $episode->ID);
						    $content = get_field('episode_content' , $episode->ID);
						    $couleur = get_field('couleur' , $episode->ID);
						    $description = get_field('description_episode' , $episode->ID);
					?>





					<div class="episode-item mb-5" data-episode="<?php echo $episode->ID; ?>">

						<?php
						

						$status_results = $wpdb->get_row( "SELECT * FROM tracking WHERE id_user = $id_user AND id_parcours = $id_parcours AND id_episode = $episode->ID", OBJECT );

						$checked = "";
						$label = $labels['status_to_do'];
				


						if(!empty($status_results)) {

							$checked = 'checked="checked"';
							$label = $labels['status_over'];
						}
			

						?>
						
						<div class="checkbox-discover" style="background: white;">
							<label  for="progress">
							  
							   <span class="text-label"><?php echo $label; ?></span>
							   <input type="checkbox" name="progress" value="" disabled <?php echo $checked; ?>>
							  <span class="checkmark-input"></span>
							</label>
						</div>

						<!-- <div class="checkbox-discover">
							<input type="checkbox" ><label class="pl-2" for="progress"> <?php echo $label; ?></label>
						</div> --><!-- .checkbox-discover -->

						<div class="colored" data-color="<?php echo $couleur; ?>" style="background-color:<?php echo $couleur; ?>;display: flex;">

							<!-- <div class="icone mb-5"><img src="<?php echo $icone; ?>"></div> -->
							<div>
								<p class="mb-0 icone-line"><img src="<?php echo $icone; ?>" class="pr-2" style="width:50px;"><span><?php echo $description; ?></span></p>
								<h2 class="mt-2 text-uppercase episode-title"><?php echo $episode->post_title; ?></h2>
							</div>

						</div><!-- .colored -->

					</div><!-- .episode-item -->



					<?php endforeach; ?>


					<script>
					
						let x768 = window.matchMedia("(min-width: 768px)");
						let x576 = window.matchMedia("(min-width: 576px)");
						let x1200 = window.matchMedia("(min-width: 1200px)");

						console.log("resp576",x576.matches);
						console.log("resp768",x768.matches);
						console.log("resp1200",x1200.matches);

						let ghost = 0;
						if(x1200.matches && <?php echo $number_of_episodes ?>%4!=0) {
							console.log("modulo1200");
							if(<?php echo $number_of_episodes ?> == 5 || <?php echo $number_of_episodes ?> == 9) ghost  = 3;
							if(<?php echo $number_of_episodes ?> == 6 || <?php echo $number_of_episodes ?> == 10) ghost = 2;
							if(<?php echo $number_of_episodes ?> == 7 || <?php echo $number_of_episodes ?> == 11) ghost = 1;
							i = 0;
							while(i < ghost) {
								document.write('<div class="episode-item ghost mb-5"></div>');
								i++;
							}
						}
						else if(x768.matches && <?php echo $number_of_episodes ?>%3!=0) {
							console.log("modulo768");
							if(<?php echo $number_of_episodes ?> == 4 || <?php echo $number_of_episodes ?> == 7) ghost  = 2;
							if(<?php echo $number_of_episodes ?> == 5 || <?php echo $number_of_episodes ?> == 8) ghost = 1;
							$i = 0;
							while(i < ghost) {
								document.write('<div class="episode-item ghost mb-5"></div>');
								i++;
							}
						}
						else if(x576.matches && <?php echo $number_of_episodes ?>%2!=0) {
							document.write('<div class="mb-5"></div>');
							console.log("modulo576", <?php echo $number_of_episodes ?>%4);
						}
					</script>




				</div><!-- .episodes-list -->





			<?php 
			/*******************************************************
						CONTENT EPISODE BLOCK
			*******************************************************/
			 ?>



			 	<div class="content-list">
						

			 	<?php 
					$activite = get_field('activite', 'options');
					$bloc_contenu_activite = get_field('bloc_contenu_activite', 'options');

					foreach($episodes as $episode): 

						$content = get_field('episode_content' , $episode->ID); 
					
						$couleur = get_field('couleur' , $episode->ID);

						$status_results = $wpdb->get_row( "SELECT * FROM tracking WHERE id_user = $id_user AND id_parcours = $id_parcours AND id_episode = $episode->ID", OBJECT );


						$status = 0;

						if(!empty($status_results)) {

							$status = 1;
						}

				?>

					
					<div class="content-episode-container">
						<div class="row">
							<div class="col-12">

								<div class="content-episode">


									<div style="background:<?php echo $couleur; ?>" class="py-5 px-lg-5">

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
												<div style="font-size: 2em;font-weight: 600;" class="text-uppercase mb-2"><?php echo $bloc_contenu_activite['title_instructions']; ?></div>
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
													<?php get_template_part( 'template-parts/content', 'start' , $bloc_contenu_activite); ?>
												<?php else: ?>
													<?php get_template_part( 'template-parts/content', 'end' , $bloc_contenu_activite); ?>
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

			<?php 
					$congrats = get_field('parcours_prinicpal_termine' , 'options'); 
			?>

			<?php $display = ($progress['completed'] == 1)?'none':'none'; ?>

			<div id="parcours-secondaire" style="display:<?php echo $display; ?>">
				
				<section class="intro text-center">
					<div class="container">
						<div class="row">
							<div class="column col-lg-4 col-8 mx-auto text-center">
								<div class="h1-sized"><?php echo $congrats['titre']; ?></div>
								<p><?php echo $congrats['paragraphe']; ?></p>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="up-btn"><?php echo $congrats['up_btn_library'] ?></div>
								<div class="default-btn"><a href="/bibliotheque"><?php echo $congrats['texte_bouton_bibliotheque']; ?></a></div>
							</div>
						</div>
					</div>
				</section>

				<section id="autre-parcours" class="mt-5">
					<div class="container">
						<div class="row">
							<div class="col-12 mx-auto text-center up-btn" style="color: white;">
								<?php echo $congrats['changement_de_parcours']; ?>
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
								        $query_parcours->the_post();

								           // get list of episodes
								        $episodes = get_field('episodes');
								        
								        $episodes_number = count($episodes);

								        $progress = get_status_progression(get_the_ID());

								         $args = array(
								        	'progress' 				=> $progress,
								        	'number_of_episodes' 	=> $episodes_number,
								        	'duration'   		 	=> get_field('duration'),
								        	'intro_text'			=> get_field('intro_text')
								        );
								    	
								    	get_template_part('template-parts/content' , 'parcours-logged' , $args);
								    
					
								     endwhile; ?>
								    
					
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