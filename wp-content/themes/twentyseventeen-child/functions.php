<?php

  function enqueue_styles_child_theme() {

    $parent_style = 'twentyseventeen-style';
    $child_style  = 'twentyseventeen-child-style';

    wp_enqueue_style( $parent_style,
          get_template_directory_uri() . '/style.css' );

    wp_enqueue_style( $child_style,
          get_stylesheet_directory_uri() . '/style.css',
          array( $parent_style ),
          wp_get_theme()->get('Version')
          );
  }
  add_action( 'wp_enqueue_scripts', 'enqueue_styles_child_theme' );





  // add_action( 'rest_api_init', function () {
  //   register_rest_route( 'restos/v1', '/all', array(
  //     'methods' => 'GET',
  //     'callback' => 'handle_get_all',
  //     'permission_callback' => function () {
  //       return current_user_can( 'edit_others_posts' );
  //     }
  //   ) );
  // } );

  // function handle_get_all( $data ) {
  //     global $wpdb;
  //     $query = "SELECT * FROM `prueba`";
  //     $list = $wpdb->get_results($query);
  //     return $list;
  // }
  
  include('RESTServer.php');
  $my_rest_server = new RESTServer(); 
  $my_rest_server->hook_rest_server();