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
  <div class="scale">
  	<header id="header-container" class="header-container">
      <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="/"><span class="logo"><?php echo file_get_contents(get_template_directory_uri().'/dist/svg/logo.svg'); ?></span><span class="site-title pl-xl-4 pl-2"><?php echo bloginfo('title'); ?></span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
          <?php wp_nav_menu( array(
          'theme_location'  => 'primary',
          'container'       => false,
          'menu_class'      => 'navbar-nav ml-auto',
          'walker'          => new wp_bootstrap_navwalker(),
          ) ); ?>
        <!-- <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <?php
            if(!is_user_logged_in()):
            ?>
              <a class="nav-link menu-btn login-btn" href="/login">Connexion</a>
            <?php else: ?>
              <a class="nav-link menu-btn login-btn" href="/account">Mon Compte</a>
            <?php endif; ?>
            </a>
          </li>
        </ul> -->
        <!-- <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form> -->
        </div>
      </nav>
  	</header>
  		
  	<div class="wrapper">

