$(function(){

    if ($showNotify == '1'){
        setInterval(function() {
            $.ajax({
                url: $url_notifications
            }).done(function(retorno){

                    if (retorno.hasNewFiles == true){

                        new PNotify({
                            title: 'Novo arquivo recebido',
                            text: retorno.msg,
                            type: 'success',
                            icon: 'fa fa-envelope',
                            styling: 'fontawesome'
                        });

                        if ($showSoundNotify == '1'){
                            $.playSound($url_sound);
                        }

                    }

                });
        }, 60000); // um minuto
    }


});
