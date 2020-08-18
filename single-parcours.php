<?php
/**
* 
*
* @package didask
*/

get_header();
?>



<div class="page-content" id="single-parcours">

	<div id="header-single-parcours">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-12 my-auto">
					<div class="up-title">Parcours</div>
					<h1 class="mt-1"><?php the_title(); ?></h1>
					<p><?php the_field('intro_text'); ?></p>
				</div>
				<div class="col-lg-6 col-12"><?php the_post_thumbnail('full'); ?></div>
			</div>
		</div>
	</div>


	<div class="section" id="episode-section-2">
		<div class="container">
			<div class="row">
				<div class="col-12 text-center">
					<div class="page-title">Episodes</div>
				</div>
			</div>
		</div>
	</div>

	


	

		<?php 

			$episodes = get_field('episodes'); 

			if(count($episodes) > 0):

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



				<div class="episode-item mb-5">

					<div class="checkbox-discover">
						<input type="checkbox" name="progress" value="" disabled><label class="pl-2" for="progress"> A découvrir</label>
					</div>

					<div style="background-color:<?php echo $couleur; ?>" class="colored p-5">

						<div class="icone mb-5"><img src="<?php echo $icone; ?>"></div>

						<p class="mb-0"><?php echo $description; ?></p>
						<h2 class="mt-0"><?php echo $episode->post_title; ?></h2>

					</div>

				</div>


				<?php 
					endforeach;
				?>


			</div>

		</div>


		<div class="container">
			
					<?php 

						foreach($episodes as $episode): 

							$content = get_field('episode_content' , $episode->ID); 
							$couleur = get_field('couleur' , $episode->ID);

						?>

						<div class="content-episode-container">
							<div class="row">
								<div class="col-12">

									<div  class="content-episode">

										<div style="background:<?php echo $couleur; ?>" class="p-5">

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
												</div>
												<div class="col-12 col-lg-6 px-5">
													<?php echo $content['content']; ?>
												</div>
											</div>

										</div>
</div>
										<div class="row">
											<div class="col-12 mx-auto">
												<div class="save-section my-5">
													<div class="text-uppercase pb-2">Vous avez terminé ?</div>
													<div class="default-btn btn-invert"><a href="/">Cliquez ici pour l'enregistrer</a></div>
												</div>
											</div>
										</div>

									
								</div>
							</div>
						</div>
					<?php endforeach; ?>
		</div>

	<?php endif; ?>

	
</div>



<?php get_footer(); ?>