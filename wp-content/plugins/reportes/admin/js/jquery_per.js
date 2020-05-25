$(document).ready(function(){

    $('#todosLosUsuarios').click(function(){

        var clickBtnValue = $(this).val();
        console.log(clickBtnValue);
        var ajaxurl = '/wp-content/plugins/reportes/admin/php/reportes.php',
        data =  {'action': clickBtnValue};
        $.post(ajaxurl, data, function (response) {

            response = JSON.parse(response);
            var getUrl = window.location;
            var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[0];
            window.location = baseUrl + response.rutaReporte;
            
        });

    });

    $('#cursosMasVistos').click(function(){

        var clickBtnValue = $(this).val();
        console.log(clickBtnValue);
        var ajaxurl = '/wp-content/plugins/reportes/admin/php/reportes.php',
        data =  {'action': clickBtnValue};
        $.post(ajaxurl, data, function (response) {
            console.log(response);
            //window.location = 'file.doc';
        });

    });
});
