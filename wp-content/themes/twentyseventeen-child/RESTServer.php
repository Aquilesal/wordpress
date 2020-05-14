<?
/**
 * Clase RestServer
 * 
 * Esta clase se donde se encuentra todo lo relacioando a la API Rest 
 * @author Aquiles Pulido
 * 
 */

require_once 'stripe/init.php';
require('fpdf181/fpdf.php');
require('phpqrcode/qrlib.php');
use Stripe\Stripe;


class PDF extends FPDF 
{ 

function Footer() 
{ 

$this->SetY(-27); 
$this->SetFont('Arial','I',8); 

$this->Cell(0,10,'This certificate has been ©  © produced by ',0,0,'R'); 
} 
} 

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

      register_rest_route( $namespace, '/user/getInfo', array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'get_user_info' ),
            'permission_callback'   => array( $this, 'get_permission' )
          ) );


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

       register_rest_route( $namespace, '/add-user-evaluation', array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'add_evaluation_by_user' ),
            'permission_callback'   => array( $this, 'get_permission' )
          ) );

       register_rest_route( $namespace, '/update-user-evaluation', array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'update_evaluation_by_user' ),
            'permission_callback'   => array( $this, 'get_permission' )
          ) );

       register_rest_route( $namespace, '/get_user_first_evaluation', array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'get_first_evaluation_by_user' ),
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

        register_rest_route( $namespace, '/user/addLesson', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'add_user_Lesson' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );

          register_rest_route( $namespace, '/user/getAllLessons', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'get_user_allLesson' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );

          register_rest_route($namespace, '/user/getByUsername', array(
          'methods'             => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'get_user_list' ),
          'permission_callback'   => array( $this, 'add_permission' )
      ));
          register_rest_route( $namespace, '/user/getMoreViewed', array(
        array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'get_most_viewed' ),
            'permission_callback'   => array( $this, 'add_permission' )
          )
      )  );

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

    public function badges() {
    $namespace = $this->my_namespace . $this->my_version;
    $base      = 'badges';
     register_rest_route( $namespace, '/' . $base.'/getByUser', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'get_user_badges' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );
     register_rest_route( $namespace, '/' . $base.'/getAll', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'get_all_user_badges' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );

          register_rest_route( $namespace, '/' . $base.'/addUserBadges', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'add_user_badges' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );
  }

  public function certificate() {
    $namespace = $this->my_namespace . $this->my_version;
    $base      = 'certificate';
     register_rest_route( $namespace, '/' . $base.'/generate', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'get_certificate' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );
      register_rest_route( $namespace, '/' . $base.'/findByUser', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'find_certificate' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );
      register_rest_route( $namespace, '/' . $base.'/findByCourse', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'find_certificate_course' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );
      register_rest_route( $namespace, '/' . $base.'/totalApprove', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'total_Approve' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );


      register_rest_route( $namespace, '/' . $base.'/generatePhysical', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'get_certificate_physical' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );
      register_rest_route( $namespace, '/' . $base.'/findByUserPhysical', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'find_certificate_physical' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );
      register_rest_route( $namespace, '/' . $base.'/findByCoursePhysical', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'find_certificate_physical_course' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );

  }

  public function stripe() {
    $namespace = $this->my_namespace . $this->my_version;
    $base      = 'stripe';

          register_rest_route( $namespace, '/' . $base.'/addCharge', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'add_stripe_charge' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );

          register_rest_route( $namespace, '/' . $base.'/registerPayment', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'register_payment_stripe' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );
  }

   public function paypal() {
    $namespace = $this->my_namespace . $this->my_version;
    $base      = 'paypal';

          register_rest_route( $namespace, '/' . $base.'/registerPayment', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'register_payment_paypal' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );
  }

  public function valoration() {
    $namespace = $this->my_namespace . $this->my_version;
    $base      = 'valoration';

          register_rest_route( $namespace, '/' . $base.'/addValoration', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'add_valoration' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );

          register_rest_route( $namespace, '/' . $base.'/updateValoration', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'update_valoration' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );

          register_rest_route( $namespace, '/' . $base.'/getValoration', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'get_valoration' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );
          register_rest_route( $namespace, '/' . $base.'/getValorationAllCourses', array(
          'methods'         => WP_REST_Server::CREATABLE,
          'callback'        => array( $this, 'get_valoration_allCourses' ),
          'permission_callback'   => array( $this, 'get_permission' )
        ) );
  }
   
    // Register our REST Server
    public function hook_rest_server(){
      
      add_action( 'rest_api_init', array( $this, 'register_routes' ) );
      add_action( 'rest_api_init', array( $this, 'inscribed_by_course' ) );
      add_action( 'rest_api_init', array( $this, 'forum' ) );
      add_action( 'rest_api_init', array( $this, 'badges' ) );
      add_action( 'rest_api_init', array( $this, 'stripe' ) );
      add_action( 'rest_api_init', array( $this, 'paypal' ) );
      add_action( 'rest_api_init', array( $this, 'certificate' ) );
      add_action( 'rest_api_init', array( $this, 'valoration' ) );

    }
   
    public function get_permission(){
      if ( ! current_user_can( 'edit_posts' ) ) {
            return new WP_Error( 'rest_forbidden', esc_html__( 'You do not have permissions to view this data.', 'my-text-domain' ), array( 'status' => 401 ) );
        }
   
        // This approach blocks the endpoint operation. You could alternatively do this by an un-blocking approach, by returning false here and changing the permissions check.
        return true;
    }

    function get_user_list(WP_REST_Request $request) {
   
   $username=$request->get_param( 'username' );
   $results = get_users(array(
    'login'     => $username

));

   //$results = get_users();

   //Using the default controller to ensure the response follows the same structure as the default route
   $users = array();
   $controller = new WP_REST_Users_Controller();
   foreach ( $results as $user ) {
        $data    = $controller->prepare_item_for_response( $user, $request );
        $users[] = $controller->prepare_response_for_collection( $data );
    }

   return rest_ensure_response( $users );
    //return $results;
}
   
    public function forum() {
      $namespace = $this->my_namespace . $this->my_version;
      $base      = 'forum';
       register_rest_route( $namespace, '/' . $base.'/getTopics', array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'get_forum_topic' ),
            'permission_callback'   => array( $this, 'get_permission' )
          ) );
  
            register_rest_route( $namespace, '/' . $base.'/createTopic', array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'add_forum_topic' ),
            'permission_callback'   => array( $this, 'get_permission' )
          ) );
  
          register_rest_route( $namespace, '/' . $base.'/topic/getAnswers', array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'get_topic_answers' ),
            'permission_callback'   => array( $this, 'get_permission' )
          ) );
            register_rest_route( $namespace, '/' . $base.'/topic/createAnswer', array(
            'methods'         => WP_REST_Server::CREATABLE,
            'callback'        => array( $this, 'add_topic_answer' ),
            'permission_callback'   => array( $this, 'get_permission' )
          ) );

    }

    public function get_forum_topic( WP_REST_Request $request ){

      global $wpdb;
  
      $idCourse=$request->get_param( 'id_course' );
      $idForum=$request->get_param( 'id_forum' );
  
      $query = "SELECT * FROM topic_forum WHERE id_course='$idCourse' and id_forum='$idForum'";
      $list = $wpdb->get_results($query);
      return $list;
     
      
    }
  
    public function add_forum_topic( WP_REST_Request $request ){


      global $wpdb;
  
      $userCreator=$request->get_param( 'username' );
      $idCourse=$request->get_param( 'id_course' );
      $idForum=$request->get_param( 'id_forum' );
      $title=$request->get_param( 'title' );
  
      $query = "INSERT INTO topic_forum (creator_user, id_course,id_forum,title) VALUES ('$userCreator', '$idCourse','$idForum','$title')";
      $list = $wpdb->get_results($query);
      return $list;
     
    }  
  
    public function get_topic_answers( WP_REST_Request $request ){
  
      global $wpdb;
  
      $idTopic=$request->get_param( 'id_topic' );
  
      $query = "SELECT * FROM answer_topic WHERE id_topic='$idTopic'";
      $list = $wpdb->get_results($query);
      return $list;
     
      
    }
  
    public function add_topic_answer( WP_REST_Request $request ){
  
  
      global $wpdb;
   
      $userCreator=$request->get_param( 'username' );
      $idTopic=$request->get_param( 'id_topic' );
      $id_father=$request->get_param( 'id_father' );
      $answer=$request->get_param( 'answer' );
  
      $query = "INSERT INTO answer_topic (creator_user, id_topic,id_father,answer) VALUES ('$userCreator', '$idTopic','$id_father','$answer')";
      $list = $wpdb->get_results($query);
      return $list;
     
      
    }

    public function get_user_allLesson( WP_REST_Request $request ){

      global $wpdb;
      
      $user=$request->get_param( 'username' );
      $id_course=$request->get_param( 'id_course' );
  
      $query = "SELECT * FROM lesson_user_view WHERE user='$user' AND id_course='$id_course'";
      $list = $wpdb->get_results($query);
      return $list;
     
    }
  
    public function add_user_Lesson( WP_REST_Request $request ){
  
  
      global $wpdb;
  
      $user=$request->get_param( 'username' );
      $id_course=$request->get_param( 'id_course' );
      $id_lesson=$request->get_param( 'id_lesson' );
  
      $query = "INSERT INTO lesson_user_view (user, id_course,id_lesson) VALUES ('$user', '$id_course','$id_lesson')";
      $list = $wpdb->get_results($query);
      return $list;
     
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
      $id_course=$request->get_param( 'id_course' );
      $idLesson=$request->get_param( 'id_lesson' );
      $idEvaluation=$request->get_param( 'id_evaluation' );
      $query = "SELECT * FROM `user_evaluation` WHERE user='$user' and id_course='$id_course' and id_lesson='$idLesson' and id_evaluation='$idEvaluation'";
      $list = $wpdb->get_results($query);
      return $list;
    }

    public function add_evaluation_by_user( WP_REST_Request $request ){
  
      global $wpdb;

      $user=$request->get_param( 'user' );
      $id_course=$request->get_param( 'id_course' );
      $idLesson=$request->get_param( 'id_lesson' );
      $idEvaluation=$request->get_param( 'id_evaluation' );
      $score=$request->get_param( 'score' );
      $approve=$request->get_param( 'approve' );

      $query = "SELECT * FROM user_evaluation WHERE user='$user' AND id_course='$id_course' AND id_lesson='$idLesson' AND id_evaluation='$idEvaluation'";
      $list = $wpdb->get_results($query);

       if (count($list)>0){
        $query = "UPDATE user_evaluation SET puntaje='$score',aprobado='$approve' WHERE user='$user' AND id_course='$id_course' AND id_lesson='$idLesson' AND id_evaluation='$idEvaluation'" ;
        $list = $wpdb->get_results($query);
        return $list;
      }

      else{
       $query = "INSERT INTO user_evaluation (user, id_course, id_lesson, id_evaluation, puntaje,aprobado) VALUES ('$user', '$id_course','$idLesson','$idEvaluation','$score','$approve')"  ;
      $list = $wpdb->get_results($query);
      return $list;
      }
      
    }


    public function update_evaluation_by_user( WP_REST_Request $request ){
  
      global $wpdb;
      $user=$request->get_param( 'user' );
      $id_course=$request->get_param( 'id_course' );
      $idLesson=$request->get_param( 'id_lesson' );
      $idEvaluation=$request->get_param( 'id_evaluation' );
      $score=$request->get_param( 'score' );
      $approve=$request->get_param( 'approve' );

      $query = "UPDATE user_evaluation SET puntaje='$score' and set aprobado='$approve' WHERE user='$user' and id_course='$id_course' and id_lesson='$idLesson' and id_evaluation='$idEvaluation'" ;
    
      $list = $wpdb->get_results($query);
      return $list;
    }

    public function get_first_evaluation_by_user( WP_REST_Request $request ){
  
      global $wpdb;
      $user=$request->get_param( 'user' );
      $id_course=$request->get_param( 'id_course' );
      $query = "SELECT COUNT(*) as Cantidad FROM `user_evaluation` WHERE user='$user' and id_course='$id_course'";
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

    public function get_user_badges( WP_REST_Request $request ){

    global $wpdb;

    
    $user=$request->get_param( 'username' );
    $query = "SELECT * FROM user_badges WHERE user='$user'";
    $list = $wpdb->get_results($query);
    return $list;
   
    
  }

   public function get_all_user_badges( WP_REST_Request $request ){

    global $wpdb;

    
     $user=$request->get_param( 'username' );
    $query = "SELECT id_badge, count(id_badge) as total from user_badges WHERE user='$user' group by id_badge order by total desc";
    $list = $wpdb->get_results($query);
    return $list;
   
    
  }

  public function add_user_badges( WP_REST_Request $request ){


    global $wpdb;

    
     $user=$request->get_param( 'username' );
     $id_badge=$request->get_param( 'id_badge' );

    $query = "INSERT INTO user_badges (user, id_badge) VALUES ('$user', '$id_badge')";
    $list = $wpdb->get_results($query);
    return $list;
   
    
  }

  public function add_stripe_charge( WP_REST_Request $request ){


   \Stripe\Stripe::setApiKey('sk_test_Ut3arRU2scvEhhWmFBwIHFdq00UmPRRi2J');

   $token=$request->get_param( 'token' );
   $monto=$request->get_param( 'monto' );

// `source` is obtained with Stripe.js; see https://stripe.com/docs/payments/accept-a-payment-charges#web-create-token
return \Stripe\Charge::create([
  'amount' => $monto,
  'currency' => 'usd',
  'source' => $token,
  'description' => 'My First Test Charge (created for API docs)',
]);
   
    
  }

  public function register_payment_stripe( WP_REST_Request $request ){


     global $wpdb;

    
     $user=$request->get_param( 'username' );
     $id_course=$request->get_param( 'id_course' );
     $id_transaction=$request->get_param( 'id_transaction' );
     $monto=$request->get_param( 'monto' );


    $query = "INSERT INTO user_stripe (user, id_course, id_transaction, monto) VALUES ('$user', '$id_course','$id_transaction','$monto')";
    $list = $wpdb->get_results($query);
    return $list;
    
  }

  public function register_payment_paypal( WP_REST_Request $request ){


     global $wpdb;

    
     $user=$request->get_param( 'username' );
     $id_course=$request->get_param( 'id_course' );
     $id_transaction=$request->get_param( 'id_transaction' );
     $monto=$request->get_param( 'monto' );


    $query = "INSERT INTO user_paypal (user, id_course, id_transaction, monto) VALUES ('$user', '$id_course','$id_transaction','$monto')";
    $list = $wpdb->get_results($query);
    return $list;
    
  }

  public function find_certificate_course( WP_REST_Request $request ){

    global $wpdb;

    
    $user=$request->get_param( 'username' );
    $course=$request->get_param( 'id_course' );

    $query = "SELECT * FROM user_certificate WHERE user='$user' AND id_course='$course'";
    $list = $wpdb->get_results($query);
    return $list;
    
  }

   public function find_certificate_physical_course( WP_REST_Request $request ){

    global $wpdb;

    
    $user=$request->get_param( 'username' );
    $course=$request->get_param( 'id_course' );

    $query = "SELECT * FROM user_certificate_physical WHERE user='$user' AND id_course='$course'";
    $list = $wpdb->get_results($query);
    return $list;
    
  }

  public function find_certificate( WP_REST_Request $request ){

    global $wpdb;

    
    $user=$request->get_param( 'username' );

    $query = "SELECT * FROM user_certificate WHERE user='$user'";
    $list = $wpdb->get_results($query);
    return $list;
    
  }

  public function find_certificate_physical( WP_REST_Request $request ){

    global $wpdb;

    
    $user=$request->get_param( 'username' );

    $query = "SELECT * FROM user_certificate_physical WHERE user='$user'";
    $list = $wpdb->get_results($query);
    return $list;
    
  }


  public function get_certificate( WP_REST_Request $request ){

    global $wpdb;

    // $params = array('where' => "post_parent = '265'");

     // // Example #1
     //  $mycurso = pods_data ( 'curso', '265' );

     //  $mymodulo = pods( 'modulo', '203' );

     //  $myleccion = pods( 'leccion', '273' );

    $userRequest=$request->get_param( 'username' );
    $id_course=$request->get_param( 'id_course' );


    //Obtengo el total de evaluaciones que tiene el curso
     

    $totalEvaluation = $this->searchTotalEvaluation($id_course);

    //valido que el usuario aprobara min el 80% de las evaluaciones del curso

    $query = "SELECT COUNT(*) as cantidadAprobado  FROM user_evaluation where user='$userRequest' and id_course='$id_course' and aprobado=true";
    $list = $wpdb->get_results($query);

    $cantidad=$list[0]->cantidadAprobado;


    $Porcentaje= ($cantidad*100)/$totalEvaluation;

    if($Porcentaje>=80){

      $podCurso = pods( 'curso', $id_course );

      $nombreCurso = $podCurso->field( 'nombre' );


      $user = pods( 'user', '1' );

      $nombreUser = $user->field( 'nombre' );

      $apellidoUser = $user->field( 'apellido' );

      $nombre=$nombreUser." ".$apellidoUser;

      $randomNumber = rand();
      
      $response= $this->generateCertificate($nombreCurso,$nombre,$randomNumber);

      $query = "INSERT INTO user_certificate (user, id_course, id_certificate, url) VALUES ('$userRequest', '$id_course','$randomNumber','$response')";
      $list = $wpdb->get_results($query);


      return $response;

    }

    else
    {
      return "El porcentaje es ".$Porcentaje."% "."Se necesita minimo 80% para generar un certificado.";
    }
    
  }

  public function get_certificate_physical( WP_REST_Request $request ){

    global $wpdb;

    // $params = array('where' => "post_parent = '265'");

     // // Example #1
     //  $mycurso = pods_data ( 'curso', '265' );

     //  $mymodulo = pods( 'modulo', '203' );

     //  $myleccion = pods( 'leccion', '273' );

    $userRequest=$request->get_param( 'username' );
    $id_course=$request->get_param( 'id_course' );


    //Obtengo el total de evaluaciones que tiene el curso
     

    $totalEvaluation = $this->searchTotalEvaluation($id_course);

    //valido que el usuario aprobara min el 80% de las evaluaciones del curso

    $query = "SELECT COUNT(*) as cantidadAprobado  FROM user_evaluation where user='$userRequest' and id_course='$id_course' and aprobado=true";
    $list = $wpdb->get_results($query);

    $cantidad=$list[0]->cantidadAprobado;


    $Porcentaje= ($cantidad*100)/$totalEvaluation;

    if($Porcentaje>=80){

      $podCurso = pods( 'curso', $id_course );

      $nombreCurso = $podCurso->field( 'nombre' );


      $user = pods( 'user', '1' );

      $nombreUser = $user->field( 'nombre' );

      $apellidoUser = $user->field( 'apellido' );

      $nombre=$nombreUser." ".$apellidoUser;

      $randomNumber = rand();
      
      $response= $this->generateCertificate($nombreCurso,$nombre,$randomNumber);

      $query = "INSERT INTO user_certificate_physical (user, id_course, id_certificate, url) VALUES ('$userRequest', '$id_course','$randomNumber','$response')";
      $list = $wpdb->get_results($query);


      return $response;

    }

    else
    {
      return "El porcentaje es ".$Porcentaje."% "."Se necesita minimo 80% para generar un certificado.";
    }
    
  }



  public function get_user_info(WP_REST_Request $request ){
    global $wpdb;

     $userRequest=$request->get_param( 'username' );

     $user = pods( 'user', '1' );

     return $user;
  }


  public function searchTotalEvaluation($id_course){

      $totalEvaluacionesCurso=0;

      $podCurso = pods( 'curso', $id_course );

      $arrayModulos = $podCurso->field( 'modulo' );

      if ( ! empty( $arrayModulos ) ) {
        foreach ( $arrayModulos as $rel ) { 
          $id = $rel[ 'ID' ];


          $podModulo = pods( 'modulo', $id);

          $arrayLecciones = $podModulo->field( 'leccion' );

          if ( ! empty( $arrayLecciones ) ) {
            foreach ( $arrayLecciones as $rel ) { 
              $id = $rel[ 'ID' ];

              $podLeccion = pods( 'leccion', $id );

              $arrayEvaluacion = $podLeccion->field( 'evaluacion' );

              if($arrayEvaluacion){
                $totalEvaluacionesCurso++;
              }

            }

          }
       
   
      } 
    }

    return $totalEvaluacionesCurso;
  } 

 
  public function generateCertificate($nombreCurso,$nombreUser,$randomNumber){

    global $wpdb;



      
      $dir = wp_get_upload_dir()[path];
      $filename=$dir."/".$randomNumber.".pdf";
      $url = wp_get_upload_dir()[url]."/".$randomNumber.".pdf";

      
      $randomNumberQr = rand();
      $filenameQr=$dir."/".$randomNumberQr.".png";
      $urlQr = wp_get_upload_dir()[url]."/".$randomNumberQr.".png";

      QRcode::png($url, $filenameQr); 

      // $pdf = new FPDF();
      // $pdf->AddPage();
      // $pdf->SetFont('Arial','B',16);
      // $pdf->Cell(40,10,'Hello World!');
      // $content = $pdf->Output($filename,'F');


      $pdf = new FPDF('L','pt','A4'); 

      //Loading data 
      $pdf->SetTopMargin(20); $pdf->SetLeftMargin(20); $pdf->SetRightMargin(20); 

      $pdf->AddPage(); 
       //$pdf->Image('fpdf181/ucab_logo.jpg'); 
      $pdf->Image('http://192.168.99.100:8000/wp-content/uploads/2020/04/ucab_logo.jpg',325,0,200,0,'JPG');
      $pdf->Image($urlQr,700,50,100,0,'PNG');
      $pdf->Image("http://192.168.99.100:8000/wp-content/uploads/2020/05/franja_amarilla.png",0,0,850,0,'PNG');
      $pdf->Image("http://192.168.99.100:8000/wp-content/uploads/2020/05/franja_azul.png",828,0,15,0,'PNG');
      $pdf->Image("http://192.168.99.100:8000/wp-content/uploads/2020/05/franja_verde.png",0,580,850,15,'PNG');
     
    // // Print the certificate logo  
    // $pdf->Image("fpdf181/tt1.png", 140, 180, 240);   

      $pdf->SetFont('times','I',20); 
      $pdf->SetXY(0,220); 
      $pdf->Cell(0,0,"Este reconocimiento es para",0,0,'C'); 

      $pdf->SetFont('times','B',40); 
      $pdf->SetXY(0,280); 
      $pdf->Cell(0,0,utf8_decode($nombreUser),0,0,'C'); 


      $pdf->SetFont('times','I',20); 
      $pdf->SetXY(0,330); 
      $pdf->Cell(520,0,"por completar el curso de",0,'C',0); 


      $pdf->SetFont('times','B',40); 
      $pdf->SetXY(0,380); 
      $pdf->Cell(0,0,utf8_decode($nombreCurso),0,0,'C'); 

       // $pdf->SetFont('times','I',20); 
       // $pdf->SetXY(0,100);
       // $pdf->Cell(20,350,"por completar el curso de ",0,0,'C'); 

      // $pdf->SetFont('times','B',40); 
      // $pdf->SetXY(100,100); 
      // $pdf->Cell(25,550,"Programación Basica",0,0,'C'); 

      // $pdf->SetFont('Arial','I',20); 
      // $pdf->SetXY(100,350); 
      // $message = "ON COMPLETION OF"; 
      // $pdf->MultiCell(650,20,"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam vel velit vulputate lorem sollicitudin dictum. Sed vel commodo velit. Sed tincidunt nisi ac malesuada commodo. Maecenas suscipit augue vel nibh rutrum, sit amet lacinia diam rutrum. Integer gravida ipsum justo, vitae faucibus lectus mollis vitae. Curabitur et orci sit amet magna rhoncus egestas vitae sed odio. Suspendisse sit amet tempus eros. Cras rhoncus lacus id est laoreet fringilla.",0,'J',0); 


      // $pdf->SetFont('Arial','I',34); 
      // $pdf->SetXY(100,500); 

      // $pdf->Cell(330,25,"Alumno","B",0,'C',0); 


      


      $pdf->SetFont('Arial','B',15); 
      $pdf->SetXY(20,500); 
      $pdf->Cell(330,10,utf8_decode("Gustavo Peña Torbay"),0,0,'C',0); 
      $pdf->SetFont('Arial','I',15); 
      $pdf->SetXY(20,520); 
      $pdf->Cell(330,10,"Vicerrector Academico de la Ucab",0,0,'C',0); 

      $pdf->SetFont('Arial','B',15); 
      $pdf->SetXY(250,500); 
      $pdf->Cell(330,10,"Silvana Campagnaro",0,0,'C',0); 
      $pdf->SetFont('Arial','I',15); 
      $pdf->SetXY(250,520); 
      $pdf->Cell(330,10,"Directora CIAP-UCAB",0,0,'C',0); 

      $pdf->SetFont('Arial','B',15); 
      $pdf->SetXY(480,500); 
      $pdf->Cell(330,10,utf8_decode("Marysabel Suárez V."),0,0,'C',0); 
      $pdf->SetFont('Arial','I',15); 
      $pdf->SetXY(480,520); 
      $pdf->Cell(330,10,utf8_decode("Directora Centro de Estudios en Línea"),0,0,'C',0); 

//       $pdf->Cell(150,'102 South Avenue',1,0,'L',true);
// $pdf->Ln();
// $pdf->Cell(150,'Suite 107',1,0,'L',true);
// $pdf->Ln();
// $pdf->Cell(150,'Scottsdale AZ 85260',1,0,'L',true);
// $pdf->Ln();
// $pdf->Cell(150,'111-000-1111',1,0,'L',true);

      $pdf->Output($filename,'F'); 

      return $url;

  }

    public function total_Approve(WP_REST_Request $request){
    global $wpdb;

    $userRequest=$request->get_param( 'username' );
    $id_course=$request->get_param( 'id_course' );

    $query = "SELECT COUNT(*) as cantidadAprobado  FROM user_evaluation where user='$userRequest' and id_course='$id_course' and aprobado=true";
    $list = $wpdb->get_results($query);

    return $list;
  }




      public function get_valoration( WP_REST_Request $request ){
  
      global $wpdb;
      $id_course=$request->get_param( 'id_course' );
      $query = "SELECT AVG(puntaje) as valoration, COUNT(user) as total FROM course_valoration WHERE id_course='$id_course'";
      $list = $wpdb->get_results($query);
      return $list[0];
    }

    public function get_valoration_allCourses( WP_REST_Request $request ){
  
      global $wpdb;
      $id_course=$request->get_param( 'id_course' );
      $query = "SELECT id_course, AVG(puntaje) as valoration, COUNT(user) as total FROM course_valoration group by id_course order by valoration desc ";
      $list = $wpdb->get_results($query);
      return $list;
    }

    public function add_valoration( WP_REST_Request $request ){
  
      global $wpdb;

      $user=$request->get_param( 'user' );
      $id_course=$request->get_param( 'id_course' );
      $puntaje=$request->get_param( 'puntaje' );

      $query = "SELECT * FROM course_valoration WHERE user='$user' AND id_course='$id_course'";
      $list = $wpdb->get_results($query);

      if (count($list)>0){
        $query = "UPDATE course_valoration SET puntaje='$puntaje' WHERE user='$user' and id_course='$id_course'" ;
        $list = $wpdb->get_results($query);
        return $list;
      }

      else{
        $query = "INSERT INTO course_valoration (user, id_course, puntaje) VALUES ('$user', '$id_course','$puntaje')"  ;
        $list = $wpdb->get_results($query);
        return $list;
      }
      
    }

    public function update_valoration( WP_REST_Request $request ){
  
      global $wpdb;
      $user=$request->get_param( 'user' );
      $id_course=$request->get_param( 'id_course' );
      $puntaje=$request->get_param( 'puntaje' );

      $query = "UPDATE course_valoration SET puntaje='$puntaje' WHERE user='$user' and id_course='$id_course'" ;
    
      $list = $wpdb->get_results($query);
      return $list;
    }


    public function get_most_viewed( WP_REST_Request $request ){
  
      global $wpdb;

      $query = "SELECT id_curso, count(id_curso) as total from user_inscribed group by id_curso order by total desc";
      $list = $wpdb->get_results($query);
      return $list;
    }


}
