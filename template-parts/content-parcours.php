<div class="row">
	<div class="col-12">
        <div class="parcours-item">
        	<div class="row">
        		<div class="col-12 col-lg-3 img-abs-container">
        			<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
        		</div>
        		<div class="col-12 col-xl-4 pl-xl-5">
        			<div class="up-title">Parcours</div>
        			<h2 class="pb-1"><?php the_title(); ?></h2>
        			<p><?php echo $args['number_of_episodes']; ?> activités à découvrir!</p>
        			<p class="duration duration-white pt-3"><strong>Durée estimée : </strong><?php echo $args['duration']; ?></p>
        		</div>
        		<div class="col-12 col-xl-5">
        			<p><?php echo $args['intro_text']; ?></p>
        			<div class="pt-2">
        				<div class="default-btn"><a href="<?php the_permalink(); ?>">Démarrer</a></div>
        			</div>
        		</div>
        	</div>
        </div>
	</div>
</div>