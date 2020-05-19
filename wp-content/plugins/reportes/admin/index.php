
<?php
    require __DIR__ . "/vendor/autoload.php";
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    
    $documento = new Spreadsheet();

    $users = $wpdb->get_results("SELECT * FROM wp_users");

    $hoja = $documento->getActiveSheet();
    $hoja->setTitle("Usuarios en la plataforma");

    foreach ($users as $user) {
        print_r($user);
    }

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

    print_r( $posts);
    $writer = new Xlsx($documento);


    # Le pasamos la ruta de guardado
    $writer->save(__DIR__."/test.xls");

?>
<div class="wrap">

    <div class="row">
        <div class="col-4">

            <h1>Reportes</h1>

        </div>

    </div>

</div>