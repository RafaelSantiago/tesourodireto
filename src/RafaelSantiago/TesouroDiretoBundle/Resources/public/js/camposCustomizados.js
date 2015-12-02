$(function(){
    $('.tokenizeIt').tokenfield();

    $('.tipoCampo').change(function(){
        showHideOpcoes($(this).val());
    })

    showHideOpcoes($('.tipoCampo').val());

})

function showHideOpcoes($valor)
{
    if ($valor == 'SELECT' ||$valor == 'MULTIPLE_SELECT'){
        $('.opcoesCampo').show();
    }
    else {
        $('.opcoesCampo').hide();
    }
}