<?php	
/*
	
@package didask

*/
	
function didask_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Menu Footer Colonne 1', 'didask' ),
        'id'            => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
 
  
 
}

add_action( 'widgets_init', 'didask_widgets_init' );