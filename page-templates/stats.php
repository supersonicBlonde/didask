<?php
/**
* Template Name: Stats
*
* @package didask
*/

// Init some variables
$logged = is_user_logged_in();

get_header();
?>
<script>
	let x768 = window.matchMedia("(min-width: 768px)");
	let x576 = window.matchMedia("(min-width: 576px)");
	let x1200 = window.matchMedia("(min-width: 1200px)");
</script>
<?php if($logged): ?>


	<div class="page-content">
		<?php if(have_posts()): ?>
			<?php while(have_posts()): the_post(); ?>
		<div class="section under-header">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<h1><?php the_title(); ?></h1>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<h2 class="h4-sized"><?php the_content(); ?></h2>
					</div>
				</div>
			</div>
		</div>
		<?php endwhile; endif; ?>


<?php else: ?>

	<div class="page-content">
		
		<div class="logged-in-only">Vous devez être connecté pour accéder à ce contenu.</div>

	</div>

<?php endif; ?>


<?php get_footer(); ?>