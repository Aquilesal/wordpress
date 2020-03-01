<?
/**
 * Clase RestServer
 * 
 * Esta clase se donde se encuentra todo lo relacioando a la API Rest 
 * @author Aquiles Pulido
 * 
 */
class RESTServer extends WP_REST_Controller {
 
    //The namespace and version for the REST SERVER
    var $my_namespace = 'my_rest_server/v';
    var $my_version   = '1';
   
    public function register_routes() {
      $namespace = $this->my_namespace . $this->my_version;
      $base      = 'user-inscribed';
      register_rest_route( $namespace, '/' . $base, array(
        array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'add_user_inscribed' ),
            'permission_callback'   => array( $this, 'add_permission' )
          )
      )  );

      register_rest_route( $namespace, 'users/courses/user_inscribed_by_username', array(
        array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'get_user_inscribed_by_username' ),
            'permission_callback'   => array( $this, 'get_permission' )
          )
      )  );

       register_rest_route( $namespace, '/user-evaluation', array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'get_evaluation_by_user' ),
            'permission_callback'   => array( $this, 'get_permission' )
          ) );
  
       register_rest_route( $namespace, '/users/register', array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'wc_rest_user_endpoint_handler' )
          ) );

        register_rest_route( $namespace, '/user/addLastLesson', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'add_user_lastLesson' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );

         register_rest_route( $namespace, '/user/getLastLesson', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'get_user_lastLesson' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );
    }
  
    public function inscribed_by_course() {
      $namespace = $this->my_namespace . $this->my_version;
      $base      = 'user-by-course';
      register_rest_route( $namespace,  '/' . $base, array(
        array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'get_user_inscribed_by_course' ),
            'permission_callback'   => array( $this, 'get_permission' )
          )
      )  );
    }
   
    // Register our REST Server
    public function hook_rest_server(){
      add_action( 'rest_api_init', array( $this, 'register_routes' ) );
      add_action( 'rest_api_init', array( $this, 'inscribed_by_course' ) );
    }
   
    public function get_permission(){
      if ( ! current_user_can( 'edit_posts' ) ) {
            return new WP_Error( 'rest_forbidden', esc_html__( 'You do not have permissions to view this data.', 'my-text-domain' ), array( 'status' => 401 ) );
        }
   
        // This approach blocks the endpoint operation. You could alternatively do this by an un-blocking approach, by returning false here and changing the permissions check.
        return true;
    }
   
    public function get_user_inscribed_by_username( WP_REST_Request $request ){
      // //Let Us use the helper methods to get the parameters
      // $category = $request->get_param( 'category' );
      // $post = get_posts( array(
      //       'category'      => $category,
      //         'posts_per_page'  => 1,
      //         'offset'      => 0
      // ) );
   
      //   if( empty( $post ) ){
      //     return null;
      //   }
   
      //   return $post[0]->post_title;
  
      global $wpdb;
      $username=$request->get_param( 'username' );
      $query = "SELECT * FROM `user_inscribed` WHERE usuario='$username'";
      
      $list = $wpdb->get_results( $query);
      return $list;
    }
  
    public function get_user_inscribed_by_course( WP_REST_Request $request ){
  
      global $wpdb;
      $course=$request->get_param( 'course' );
      $user=$request->get_param( 'user' );
      $query = "SELECT * FROM `user_inscribed` WHERE id_curso='$course' and usuario='$user'";
      $list = $wpdb->get_results($query);
      return $list;
    }
  
  
    public function get_evaluation_by_user( WP_REST_Request $request ){
  
      global $wpdb;
      $user=$request->get_param( 'user' );
      $idLesson=$request->get_param( 'id_lesson' );
      $idEvaluation=$request->get_param( 'id_evaluation' );
      $query = "SELECT * FROM `user_evaluation` WHERE user='$user' and id_lesson='$idLesson' and id_evaluation='$idEvaluation'";
      $list = $wpdb->get_results($query);
      return $list;
    }
  
    function wc_rest_user_endpoint_handler($request = null) {
  
      $response = array();
      $parameters = $request->get_json_params();
      $username = sanitize_text_field($parameters['username']);
      $email = sanitize_text_field($parameters['email']);
      $email_usuario = sanitize_text_field($parameters['email_usuario']);
      $nombre = sanitize_text_field($parameters['nombre']);
      $apellido = sanitize_text_field($parameters['apellido']);
      $compania_universidad = sanitize_text_field($parameters['compania_universidad']);
      $profesion = sanitize_text_field($parameters['profesion']);
      $pais = sanitize_text_field($parameters['pais']);
      $password = sanitize_text_field($parameters['password']);
      
      // $role = sanitize_text_field($parameters['role']);
      $error = new WP_Error();
      if (empty($username)) {
        $error->add(400, __("El campo del nombre de usuario es requerido", 'wp-rest-user'), array('status' => 400));
        return $error;
      }

      if (empty($email) || empty($email_usuario)) {
        $error->add(400, __("El campo de email es requerido", 'wp-rest-user'), array('status' => 400));
        return $error;
      }

      if (empty($password)) {
        $error->add(400, __("El campo de contraseña es requerido", 'wp-rest-user'), array('status' => 400));
        return $error;
      }

      if (empty($nombre)) {
        $error->add(400, __("El campo de nombre es requerido", 'wp-rest-user'), array('status' => 400));
        return $error;
      }

      if (empty($apellido)) {
        $error->add(400, __("El campo de apellido es requerido", 'wp-rest-user'), array('status' => 400));
        return $error;
      }

      if (empty($compania_universidad)) {
        $error->add(400, __("El campo de Compania/Universidad es requerido", 'wp-rest-user'), array('status' => 400));
        return $error;
      }

      if (empty($profesion)) {
        $error->add(400, __("El campo de profesion es requerido", 'wp-rest-user'), array('status' => 400));
        return $error;
      }
      
      // if (empty($role)) {
      //  $role = 'subscriber';
      // } else {
      //     if ($GLOBALS['wp_roles']->is_role($role)) {
      //      // Silence is gold
      //     } else {
      //    $error->add(405, __("Role field 'role' is not a valid. Check your User Roles from Dashboard.", 'wp_rest_user'), array('status' => 400));
      //    return $error;
      //     }
      // }
      $user_id = username_exists($username);
      if($user_id){
        $error->add(400, __("El usuario ya existe, por favor intente intente con otro", 'wp-rest-user'), array('status' => 400));
      }
  
      if (!$user_id && email_exists($email) == false) {
        $user_id = wp_create_user($username, $password, $email);
        // $user_id = wp_create_user($username, $password, $email, $nombre, $apellido, $compania_universidad, $profesion, $pais);
        //     $user_id = wp_insert_user( array(
        //   'user_login' => $username,
        //   'user_pass' => $password,
        //   'user_email' => $email,
        //   'nombre' => $nombre,
        //   'apellido' => $apellido
        // ));
        $meta = array(
        'nombre' => $nombre,
        'apellido' => $apellido,
        'compania_universidad'=> $compania_universidad,
        'profesion'=> $profesion,
        'pais'=> $pais,
        'email_usuario'=> $email_usuario
        );
  
      if (!is_wp_error($user_id)) {
        // Ger User Meta Data (Sensitive, Password included. DO NOT pass to front end.)
        $user = get_user_by('id', $user_id);

        foreach( $meta as $key => $val ) {
          update_user_meta( $user_id, $key, $val ); 
        }
  
          // $user->set_role($role);
        $user->set_role('estudiante');
          // WooCommerce specific code
        if (class_exists('WooCommerce')) {
          $user->set_role('customer');
        }
        // Ger User Data (Non-Sensitive, Pass to front end.)
        $response['code'] = 200;
        $response['message'] = __("El usuario '" . $username . "' Registro completo", "wp-rest-user");
  
      } else {
  
        return $user_id;
  
      }
  
    } else {
  
      $error->add(401, __("El email ya existe, por favor intente presionando 'Olvide contraseña'", 'wp-rest-user'), array('status' => 400));
      return $error;
  
    }
  
    return new WP_REST_Response($response, 123);
    
  }
  
    
  
  
   
    public function add_permission(){
      if ( ! current_user_can( 'edit_posts' ) ) {
            return new WP_Error( 'rest_forbidden', esc_html__( 'You do not have permissions to create data.', 'my-text-domain' ), array( 'status' => 401 ) );
        }
        return true;
    }
   
    public function add_user_inscribed( WP_REST_Request $request ){
      //Let Us use the helper methods to get the parameters
      // $args = array(
      //   'post_title' => $request->get_param( 'title' ),
      //   'post_category' => array( $request->get_param( 'category' ) )
      // );
   
      // if ( false !== ( $id = wp_insert_post( $args ) ) ){
      //   return get_post( $id );
      // }
  
      global $wpdb;
  
      $user=$request->get_param( 'username' );
      $course=$request->get_param( 'courseID' );
  
      $query = "INSERT INTO user_inscribed (usuario, id_curso) VALUES ('$user', '$course')"  ;
      $list = $wpdb->get_results($query, OBJECT);
      return $list;
      
    }

    public function add_user_lastLesson( WP_REST_Request $request ){

      global $wpdb;

      $user=$request->get_param( 'username' );
      $lesson=$request->get_param( 'lessonID' );
  
      $query = "UPDATE user_inscribed SET lastLesson='$lesson' WHERE usuario='$user'" ;
      $list = $wpdb->get_results($query);
      return $list;
     
      
    }
  
     public function get_user_lastLesson( WP_REST_Request $request ){
  
      global $wpdb;
  
      $user=$request->get_param( 'username' );
   
      $idLesson=$request->get_param( 'id_lesson' );
      $idEvaluation=$request->get_param( 'id_evaluation' );
      $query = "SELECT * FROM `user_inscribed` WHERE usuario='$user'";
      $list = $wpdb->get_results($query);
      return $list;
     
    }
    
  }