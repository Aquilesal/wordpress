<?php

// Top level menu del plugin
function menu_administrador()
{
	add_menu_page("Reportes","Reportes",'manage_options','reportes/admin/index.php');
}

function ln_reg_css_and_js($hook)
{

    $current_screen = get_current_screen();

    if ( strpos($current_screen->base, 'reportes') === false) {

    	return;

    } else {

        wp_enqueue_style('boot_css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css' );
		wp_enqueue_script('jquery_js', 'https://code.jquery.com/jquery-3.5.1.slim.min.js');
		wp_enqueue_script('popper_js', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js');
		wp_enqueue_script('bootstrap_js' , 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js');
		wp_register_script( 'jquery_per',plugins_url('../admin/js/jquery_per.js', __FILE__), array('jquery'));

		wp_enqueue_script( 'jquery_per' );
    }
}

add_action('admin_menu', 'menu_administrador');
add_action('admin_enqueue_scripts', 'ln_reg_css_and_js');
