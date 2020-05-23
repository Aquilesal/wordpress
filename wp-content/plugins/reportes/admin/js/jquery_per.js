$(document).ready(function(){

    $('#cursosMasVistos').click(function(){

        var clickBtnValue = $(this).val();
        console.log(clickBtnValue);
        var ajaxurl = '/wp-content/plugins/reportes/admin/php/reportes.php',
        data =  {'action': clickBtnValue};
        $.post(ajaxurl, data, function (response) {
            console.log(response);
        });
        
    });
});
