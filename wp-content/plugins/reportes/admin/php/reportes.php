<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    //Llamando librerias necesarias
    require_once ('../../../../../wp-config.php');
    require  "../vendor/autoload.php";
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    //Revisando si es un post
    if (isset($_POST['action'])) {

        switch ($_POST['action']) {
            case 'insert':
                insert();
                break;
            case 'select':
                select();
                break;
            case 'todosLosUsuarios':
                reporteTodosLosUsuarios();
                break;
            case 'cursosMasVistos':
                cursosMasVistos();
                break;
            case 'cursosCertificadosGeneradosDigitales':
                cursosCertificadosGeneradosDigitales();
                break;
            case 'cursosMasComprados':
                cursosMasComprados();
                break;
        }
    }

    function select() {
        echo "The select function is called.";
        exit;
    }

    function insert() {
        echo "The insert function is called.";
        exit;
    }

    function cursosMasComprados()
    {
     
        $documento = new Spreadsheet();
        $wpdb = inicializarBaseDeDatos();
        $cursosMasVistos = $wpdb->get_results("select compras.idCurso, compras.Curso, SUM(compras.montoTotal) montoTotal, SUM(compras.total)  total
        from ( SELECT us.id_course idCurso, wp.post_title Curso, sum(us.monto) montoTotal, count(*) total            
        FROM user_stripe us, wp_posts wp          
            where wp.post_type LIKE 'Curso' && wp.ID = us.id_course          
            group by us.id_course           
        UNION All            
        SELECT us.id_course idCurso, wp.post_title Curso, sum(us.monto) montoTotal, count(*) total             
            FROM user_paypal us, wp_posts wp            
            where wp.post_type LIKE 'Curso' && wp.ID = us.id_course            
            group by us.id_course ) compras 
        group by compras.idCurso, compras.Curso
        order by total desc");
        $hoja = $documento->getActiveSheet();
        $hoja->setTitle("Usuarios en la plataforma");

        $hoja->setCellValueByColumnAndRow(1, 1, "Id del curso");
        $hoja->setCellValueByColumnAndRow(2, 1, "Nombre del curso");
        $hoja->setCellValueByColumnAndRow(3, 1, "Monto Total");
        $hoja->setCellValueByColumnAndRow(4, 1, "Cantidad de veces comprado");
  

        for ($i=0; $i < count($cursosMasVistos); $i++) {

            $hoja->setCellValueByColumnAndRow(1,$i+2,  $cursosMasVistos[$i]->idCurso);
            $hoja->setCellValueByColumnAndRow(2,$i+2,  $cursosMasVistos[$i]->Curso);
            $hoja->setCellValueByColumnAndRow(3,$i+2,  $cursosMasVistos[$i]->montoTotal);
            $hoja->setCellValueByColumnAndRow(4,$i+2,  $cursosMasVistos[$i]->total);


        }

        $writer = new Xlsx($documento);

        $rutaDeGuardado = "../reportes/cursos_mas_comprados-".date("Y-m-d H:i:s").".xls";
        # Le pasamos la ruta de guardado
        $writer->save($rutaDeGuardado);

        $url = construirUrl($rutaDeGuardado);

        echo json_encode([
            "rutaReporte" => $url
        ]);


    }
    /**
    * Funcion que permite la devolucion de los cursos con certificados fisicos generados
    */
    function cursosCertificadosGeneradosDigitales()
    {
        $documento = new Spreadsheet();
        $wpdb = inicializarBaseDeDatos();
        $cursosMasVistos = $wpdb->get_results("select uc.id_course as idCurso, wp.post_title as titulo, count(*) as certificadosGenerados from wp_posts wp, user_certificate uc where wp.post_type LIKE 'Curso' && wp.ID = uc.id_course group by idCurso order by certificadosGenerados desc");
        $hoja = $documento->getActiveSheet();
        $hoja->setTitle("Usuarios en la plataforma");

        $hoja->setCellValueByColumnAndRow(1, 1, "Id del curso");
        $hoja->setCellValueByColumnAndRow(2, 1, "Nombre del curso");
        $hoja->setCellValueByColumnAndRow(3, 1, "Cantidad de certificados generados");
  

        for ($i=0; $i < count($cursosMasVistos); $i++) {

            $hoja->setCellValueByColumnAndRow(1,$i+2,  $cursosMasVistos[$i]->idCurso);
            $hoja->setCellValueByColumnAndRow(2,$i+2,  $cursosMasVistos[$i]->titulo);
            $hoja->setCellValueByColumnAndRow(3,$i+2,  $cursosMasVistos[$i]->certificadosGenerados);


        }

        $writer = new Xlsx($documento);

        $rutaDeGuardado = "../reportes/cursos_certificados_generados_digitales-".date("Y-m-d H:i:s").".xls";
        # Le pasamos la ruta de guardado
        $writer->save($rutaDeGuardado);

        $url = construirUrl($rutaDeGuardado);

        echo json_encode([
            "rutaReporte" => $url
        ]);

    }

    /**
    * Funcion que permite la devolucion de los cursos mas vistos
    */
    function cursosMasVistos()
    {
        $documento = new Spreadsheet();
        $wpdb = inicializarBaseDeDatos();
        $cursosMasVistos = $wpdb->get_results("SELECT ui.id_curso as idCurso, p.post_title as titulo, count(ui.id_curso) as vistos from wp_posts as p, user_inscribed as ui where p.ID = ui.id_curso group by ui.id_curso order by vistos desc");
        $hoja = $documento->getActiveSheet();
        $hoja->setTitle("Usuarios en la plataforma");

        $hoja->setCellValueByColumnAndRow(1, 1, "Id del curso");
        $hoja->setCellValueByColumnAndRow(2, 1, "Nombre del curso");
        $hoja->setCellValueByColumnAndRow(3, 1, "Cantidad de vistos");
  

        for ($i=0; $i < count($cursosMasVistos); $i++) {

            $hoja->setCellValueByColumnAndRow(1,$i+2,  $cursosMasVistos[$i]->idCurso);
            $hoja->setCellValueByColumnAndRow(2,$i+2,  $cursosMasVistos[$i]->titulo);
            $hoja->setCellValueByColumnAndRow(3,$i+2,  $cursosMasVistos[$i]->vistos);


        }

        $writer = new Xlsx($documento);

        $rutaDeGuardado = "../reportes/cursos_mas_vistos-".date("Y-m-d H:i:s").".xls";
        # Le pasamos la ruta de guardado
        $writer->save($rutaDeGuardado);

        $url = construirUrl($rutaDeGuardado);

        echo json_encode([
            "rutaReporte" => $url
        ]);

    }

    /**
    * Funcion que permite la devolucion del reporte de todos los usuarios
    */
    function reporteTodosLosUsuarios()
    {

        $documento = new Spreadsheet();
        $wpdb = inicializarBaseDeDatos();
        $users = $wpdb->get_results("SELECT * FROM wp_users");

        $hoja = $documento->getActiveSheet();
        $hoja->setTitle("Usuarios en la plataforma");

        $hoja->setCellValueByColumnAndRow(1, 1, "ID");
        $hoja->setCellValueByColumnAndRow(2, 1, "user_login");
        $hoja->setCellValueByColumnAndRow(3, 1, "user_pass");
        $hoja->setCellValueByColumnAndRow(4, 1, "user_nicename");
        $hoja->setCellValueByColumnAndRow(5, 1, "user_email");
        $hoja->setCellValueByColumnAndRow(6, 1, "user_url");
        $hoja->setCellValueByColumnAndRow(7, 1, "user_registered");
        $hoja->setCellValueByColumnAndRow(8, 1, "user_activation_key");
        $hoja->setCellValueByColumnAndRow(9, 1, "user_status");
        $hoja->setCellValueByColumnAndRow(10, 1, "display_name");

        for ($i=0; $i < count($users); $i++) {

            $hoja->setCellValueByColumnAndRow(1,$i+2,  $users[$i]->ID);
            $hoja->setCellValueByColumnAndRow(2,$i+2,  $users[$i]->user_login);
            $hoja->setCellValueByColumnAndRow(3,$i+2,  $users[$i]->user_pass);
            $hoja->setCellValueByColumnAndRow(4,$i+2,  $users[$i]->user_nicename);
            $hoja->setCellValueByColumnAndRow(5,$i+2,  $users[$i]->user_email);
            $hoja->setCellValueByColumnAndRow(6,$i+2,  $users[$i]->user_url);
            $hoja->setCellValueByColumnAndRow(7,$i+2,  $users[$i]->user_registered);
            $hoja->setCellValueByColumnAndRow(8,$i+2,  $users[$i]->user_activation_key);
            $hoja->setCellValueByColumnAndRow(9,$i+2,  $users[$i]->user_status);
            $hoja->setCellValueByColumnAndRow(10,$i+2, $users[$i]->display_name);

        }

        $writer = new Xlsx($documento);

        $rutaDeGuardado = "../reportes/usuarios-".date("Y-m-d H:i:s").".xls";
        # Le pasamos la ruta de guardado
        $writer->save($rutaDeGuardado);

        $url = construirUrl($rutaDeGuardado);

        echo json_encode([
            "rutaReporte" => $url
        ]);

    }

    function construirUrl( $rutaDeGuardado )
    {

        $rutaDeGuardado = substr($rutaDeGuardado ,2 );
        return "/wp-content/plugins/reportes/admin".$rutaDeGuardado;

    }

    function inicializarBaseDeDatos()
    {
        return new wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );
    }


?>
