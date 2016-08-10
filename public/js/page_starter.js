$(function () {
    
    $('form').submit(function () {
        var formObj = this;
        var form = $(formObj);
        
        var dados = form.serialize();
        
        $.ajax({
            beforeSend: function (xhr) {
                $('form :submit').attr('disabled', true);
            },
            url: form.attr('action'),
            type: form.attr('method'),
            data: dados,
            dataType: 'json',
            success: function (data) {
                console.debug(data);
                
                if(data.status === 'ok') {
                    alert(data.mensagem);
                    form[0].reset();
                } else {
                    alert(data.mensagem);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error(textStatus);
            }
        });
        
        return false;
    });
});

$(document).ready(function () {
    $('#li_inicio').addClass('active');
});