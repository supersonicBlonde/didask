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
			<div class="branding">
				<div class="logo"><?php echo file_get_contents(get_template_directory_uri().'/dist/svg/logo.svg'); ?></div>
				<div class="site-title"><?php echo bloginfo('title'); ?></div>
			</div>
			<nav>
				<div class="navbar">
					<ul>
						<li><a href="/a-propos">A propos</a></li>
						<li class="menu-btn login-btn"><a href="connect">Connexion</a></li>
					</ul>
				</div>
			</nav>
		</header>
		<div class="content-container">

