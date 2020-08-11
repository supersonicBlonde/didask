<?php 
	
	/*
		This is the template for the hedaer
		
		@package didask
	*/


?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<title><?php bloginfo('name'); wp_title(); ?></title>
		<meta name="description" content="<?php bloginfo('description'); ?>">
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
				<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php if( is_singular() && pings_open( get_queried_object() ) ): ?>
			<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif; ?>
		<?php wp_head(); ?>
	</head>
	

<body <?php body_class(); ?>>
		<header class="master-header">
			<div class="header-nav">
				<div class="branding">
					<div class="logo"><?php echo file_get_contents(get_template_directory_uri().'/dist/svg/logo.svg'); ?></div>
					<div class="site-title"><?php echo bloginfo('title'); ?></div>
				</div>
				<nav>
					<div class="navbar">
						<ul>
							<li class="menu-btn login-btn">
								<?php
								if(!is_user_logged_in()):
								?>
									<a href="/login">Connexion</a>
								<?php else: ?>
									<a href="/account">Mon Compte</a>
								<?php endif; ?>
								</a>
						</li>
						</ul>
					</div>
				</nav>
			</div>
				<?php if(is_page('home-parcours')): ?>
					<div class="header-content scroll-after section wrapper">
						<div class="parcours-item">
				        	<div class="column">
				        		<div class="super-title">Parcours</div>
				        		<h1 class="h2-sized">Nom du parcours</h1>
				        		<p class="fs-26 lh-x2 fw-300"> Objectif : ouvrir l'esprit de l'équipe sur la diversité des apprentissages possibles en dehors des journées de formation.</p>
				        	</div>
				        	<div class="column"><?php the_post_thumbnail('full'); ?></div>
				        </div>
					</div>
				<?php endif; ?>
		</header>
		<div class="wrapper">

