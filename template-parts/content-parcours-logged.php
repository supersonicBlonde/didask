<div class="row">
	<div class="col-12">
        <div class="parcours-item">
        	<div class="row">
        		<div class="col-12 col-lg-3 img-abs-container">
        			<?php the_post_thumbnail('full'); ?>
        		</div>
        		<div class="col-12 col-xl-4 pl-xl-5">
        			<div class="up-title">Parcours</div>
        			<h2><?php the_title(); ?></h2>
        			<div id="progress-section">
						<div class="progress-text"><?php echo $args['progress']['achieved'] ?> épisode<?php echo $args['progress']['achieved'] > 1?'s':''?> terminé<?php echo $args['progress']['achieved'] > 1?'s':''?> sur <?php echo $args['number_of_episodes']; ?>
							<?php if($args['progress']['completed'] == 1): ?>
								<span class="checkmark"></span>
							<?php endif; ?>
						</div>
						<div class="progress">
							<div class="bar" style="width:<?php echo $args['progress']['percent']; ?>%">
							</div>
						</div>
					</div>
        		</div>
        		<div class="col-12 col-xl-5">
        			<p><?php echo $args['intro_text']; ?></p>
        			<div class="pt-2">
        				<div class="default-btn"><a href="<?php the_permalink(); ?>"><?php echo get_text_btn($args['progress']); ?></a></div>
        			</div>
        		</div>
        	</div>
        </div>
	</div>
</div>