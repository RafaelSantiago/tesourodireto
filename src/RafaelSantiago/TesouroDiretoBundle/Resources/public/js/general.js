$(function(){

    /*
     *  INPUT MASK PARA TELEFONES
     */
    var options = {
        onKeyPress: function(phone){
            var masks = ['(00) 0000-00009', '(00) 00000-0000'];
            var mask = (phone.length>14) ? masks[1] : masks[0];
            $('.telefone-mask').mask(mask, this);
        }
    }
    $(".telefone-mask").mask('(00) 0000-00009', options);

    $('.tooltip').tooltipster({
        theme: 'tooltip-custom-theme',
        position: 'bottom',
        offsetY: -8,
        delay: 0
    });

    $('.tooltip-danger').tooltipster({
        theme: 'tooltip-custom-theme-danger',
        position: 'bottom',
        offsetY: -8,
        delay: 0
    });

});