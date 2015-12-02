$(function(){
    $('.easypiechart#diskUsage').easyPieChart({
        barColor: "#16a085",
        trackColor: '#edeef0',
        scaleColor: '#d2d3d6',
        scaleLength: 5,
        lineCap: 'square',
        lineWidth: 8,
        size: 150
    });

    $('.readmore').readmore({
        speed: 75,
        maxHeight: 66,
        moreLink: '<a href="#">ver mais</a>',
        lessLink: '<a href="#">fechar</a>'
    });

})