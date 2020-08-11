<?php 
	
	/*
		This is the template for the footer
		
		@package didask
	*/
	
?>
			
		</div> <!-- .content-container -->

		<footer>
			<div class="footer-content">
				<div class="branding">
					<div class="logo"><?php echo file_get_contents(get_template_directory_uri().'/dist/svg/logo.svg'); ?></div>
					<div class="site-title"><?php echo bloginfo('title'); ?></div>
				</div>
				<nav>
					<div class="navbar">
						<ul>
							<li>
							<a href="">A propos</a>
							</li>
							<li>
							<a href="">A propos</a>
							</li>
							<li>
							<a href="">Mentions légales</a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
	</footer>
		
<?php wp_footer(); ?>
</body>
</html>