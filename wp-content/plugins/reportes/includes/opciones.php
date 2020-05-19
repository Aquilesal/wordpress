<?php

// Top level menu del plugin
function menu_administrador()
{
	add_menu_page("Reportes","Reportes",'manage_options','reportes/admin/index.php');
}

add_action('admin_menu', 'menu_administrador');

