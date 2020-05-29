$(document).ready(function(){

    $('button').click(function(){

        var clickBtnValue = $(this).val();
        console.log(clickBtnValue);
        var ajaxurl = '/wp-content/plugins/reportes/admin/php/reportes.php',
        data =  {'action': clickBtnValue};
        $.post(ajaxurl, data, function (response) {

            descargarArchivo(response);

        });

    });

});

function descargarArchivo(response){

    response = JSON.parse(response);
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[0];
    window.location = baseUrl + response.rutaReporte;
    
}
