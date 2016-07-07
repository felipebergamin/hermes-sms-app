$(function () {
    $('#enviar_sms').click(function () {
          toastr.options = {
          "closeButton": false,
          "debug": false,
          "newestOnTop": false,
          "progressBar": true,
          "positionClass": "toast-top-center",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
          };

          toastr["success"]("Oi amiguinho!");
    });
    
    /*
    var enviando_form = false;
    
    $('#form-sms').submit(function () {
        var obj = this;
        var form = $(obj);
        var sbmtBtn = $('form :submit');
        var sbmtBtn_defaultText = sbmtBtn.val();
        
        //var dados = new FormData(obj);
        var dados = form.serialize();
        
        function voltaSubmit() {
            sbmtBtn.removeAttr('disabled');
            sbmtBtn.val(sbmtBtn_defaultText);
        }
        
        if(!enviando_form) {
            // hora do ajax!
            $.ajax({
                beforeSend: function () {
                    enviando_form = true;
                    sbmtBtn.attr('disabled', true);
                    sbmtBtn.val('Enviando...');
                },
                url: form.attr('action'),
                type: form.attr('method'),
                data: dados,
                dataType: 'text',
                success: function (data) {
                    voltaSubmit();
                    form[0].reset();
                    console.log(data);
                    enviando_form = false;
                    alert('SMS enviado com sucesso!');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(textStatus);
                    enviando_form = false;
                    alert('Houve uma falha ao enviar o SMS! :(');
                }
            }); // fim da chamada ao ajax
        } // fim do if(!enviando_form)
        
        return false;
    }); //fim do evento submit
    
    */
});