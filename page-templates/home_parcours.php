<?php
/**
* Template Name: Home Parcours
*
* @package didask
*/

get_header();
?>

<?php

// GROUPS



?>

<div class="page-content">

	<div class="page-title">Episodes</div>

	<div id="episodes-list" class="section">
		<div class="container">
			
			<?php

				$args = array(
					'post_type' 		=> 'episodes',
					'posts_per_page'    => -1
				);
				
				$query_episodes = new WP_Query( $args );

				if ( $query_episodes->have_posts() ): ?>
				    <div class="episodes-list">
				    
				    <?php 

				    while ( $query_episodes->have_posts() ):
				        $query_episodes->the_post(); 

				        $icone = get_field('icone_episode');
				        $content = get_field('episode_content');
				        ?>
				    
				        <div class="episodes-item">



				        	<div style="background:<?php the_field('couleur'); ?>"é>

					        	<div class="icone"><img src="<?php echo $icone; ?>"></div>

					        	<h2><?php the_title(); ?></h2>

					        	<p><?php the_field('description_episode'); ?></p>

					        </div>

					        <div class="checkbox-discover">
					        	<input type="checkbox" name="progress" value="" disabled><label for="progress"> A découvrir</label>
					        </div>
	
				        </div>
				       

				    <?php endwhile; wp_reset_postdata(); ?>
					
					</div> 
				    
				     <?php while ( $query_episodes->have_posts() ):
				        $query_episodes->the_post(); 

				      
				        $content = get_field('episode_content');
				        ?>


				      <div  class="section content-episode">

								<div class="container" style="background:<?php the_field('couleur'); ?>">
									<div class="column">
										<div class="super-title"><?php echo $content['over_title']; ?></div>
						        		<h3><?php echo $content['title']; ?></h3>
						        		<div class="fs-20"><?php echo $content['sub_title']; ?></div>
						        		
					        			<?php if(count($content['icon_list']) > 0 ): ?>
					        				<div>
					        				<?php foreach($content['icon_list'] as $list): ?>
					        					<div><?php echo $list['icone']; ?></div>
					        					<div class="duration fs-20"><?php echo $list['paragraphe']; ?></div>
					        				<?php endforeach; ?>
					        				</div>
					        			<?php endif; ?>
									</div>
									<div class="column">
										<?php echo $content['content']; ?>
									</div>
								</div>

								<div class="save-section">
									<div>Vous avez terminé ?</div>
									<div><a href="">Cliquez ici pour l'enregistrer</a></div>
								</div>

							</div>

						<?php endwhile; ?>
				    
				<?php endif; 
				wp_reset_postdata();
				?>

		</div>
	</div>

	
	
</div>



<?php get_footer(); ?>