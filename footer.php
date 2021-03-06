<?php 
	
	/*
		This is the template for the footer
		
		@package didask
	*/
	
?>
			
			</div> <!-- .content-container -->

			<footer>
				<nav class="navbar navbar-expand-lg navbar-dark">
					<a class="navbar-brand" href="/"><span class="logo"><?php echo file_get_contents(get_template_directory_uri().'/dist/svg/logo.svg'); ?></span><span class="site-title pl-xl-4 pl-2"><?php echo bloginfo('title'); ?></span></a>

					<div class="" id="navbarNav">
						 <?php wp_nav_menu( array(
				          'menu'  => 'footer',
				          'container'       => false,
				          'menu_class'      => 'navbar-nav ml-lg-auto',
				          'walker'          => new wp_bootstrap_navwalker(),
				          ) ); ?>
					<!-- <form class="form-inline my-2 my-lg-0">
					<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
					</form> -->
					</div>
				</nav>
		</footer>
		<div id="overlay"></div>
	</div><!-- .scale -->
<?php wp_footer(); ?>
</body>
</html>