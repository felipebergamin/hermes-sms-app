$(function () {
    //onChange select
    $('select').change(function () {
        var select = $('select');
        console.debug(select);
        console.log(select.val());
        if(select.val() === 'bloq5') {
            var mensagem = 'Caro cliente, %nome%. ';
            mensagem += 'A AceTech Soluções em TI informa que dentro de 5 dias nosso sistema ';
            mensagem += 'fará o bloqueio dos clientes que possuem títulos em atraso há mais ';
            mensagem += 'de 7 dias úteis. Mantenha seus títulos em dia para evitar que sua ';
            mensagem += 'conexão seja bloqueada! Caso as parcelas estejam em dia, por favor, ';
            mensagem += 'desconsidere este sms. Essa mensagem é gerada automaticamente, ';
            mensagem += 'por favor, não responda! AceTech Soluções em TI';
            $('form textarea').val(mensagem);
        } else if (select.val() === 'bloq3') {
            var mensagem = 'Caro cliente, %nome%. ';
            mensagem += 'A AceTech Soluções em TI informa que dentro de 3 dias nosso sistema ';
            mensagem += 'fará o bloqueio dos clientes que possuem títulos em atraso há mais ';
            mensagem += 'de 7 dias úteis. Mantenha seus títulos em dia para evitar que sua ';
            mensagem += 'conexão seja bloqueada! Caso as parcelas estejam em dia, por favor, ';
            mensagem += 'desconsidere este sms. Essa mensagem é gerada automaticamente, ';
            mensagem += 'por favor, não responda! AceTech Soluções em TI';
            $('form textarea').val(mensagem);
        } else if (select.val() === 'personalizado') {
            $('form textarea').val('');
        }
    });
    
    $('form').submit(function () {
        console.log('submit form');
        
        var objform = this;
        var form = $(this);
        var sbmtBtn = $('form :submit');
        
        //armazena o texto padrão do botão de submit
        var sbmt_btn_default_txt = sbmtBtn.val();
        
        var dados = new FormData(objform);
        
        $.ajax({
            beforeSend: function (xhr) {
                console.log('vou enviar agora...');
            },
            url: form.attr('action'),
            type: form.attr('method'),
            data: dados,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                console.debug(data);
                
                alert(data.totalDeMsg + ' mensagens no total.\n' + data.msgComFalhas + ' não puderam ser enviadas.');
                //$('form textarea').val(data);
                
                for(i = 0; i < data.lotesms.mensagens.length; i++) {
                    if(data.lotesms.mensagens[i].statusEnvio.status === 'falha') {
                        console.error('Não foi possivel entregar a mensagem:');
                        console.error(data.lotesms.mensagens[i]);
                    }
                }
                
                //o php passa um Unix TimeStamp, que é o número de SEGUNDOS desde January 1 1970 00:00:00
                //o javascript interpreta como MILISSEGUNDOS, por isso, é necessário multiplicar por 1000
                //para converter os segundos para milissegundos
                //var diaEnvio = new Date(data.lotesms.mensagens[0].dataEnvio * 1000);
            },
            error: function () {
                alert('Ops... Alguma coisa deu errado! Atualize a página e tente novamente!');
            }
        });
        
        return false;
    });
});