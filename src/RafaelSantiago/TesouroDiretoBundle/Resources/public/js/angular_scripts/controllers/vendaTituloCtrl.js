angular.module("tesouroDireto").controller("vendaTituloCtrl", function ($scope, $http) {

    $scope.dataVenda = '';
    $scope.tituloId = '';
    $scope.valorVenda = '';
    $scope.quantidade = '';
    $scope.valorTotalVenda = '';

    $scope.atualizaValor = function(){
        if ($scope.dataVenda !== '' && $scope.dataVenda !== undefined && $scope.tituloId !== ''){

            _reqData = {
                data: $scope.dataVenda,
                titulo: $scope.tituloId
            };

            _reqUrl = '{{ path('rafael_santiago_tesouro_direto_ajax_getvalortitulo') }}';

            $http.get(_reqUrl, {
                params: _reqData
            }).then(function(retorno){
                if (retorno.data.success == true){
                    $scope.valorVenda = retorno.data.valor;
                }
            });

        }
    };

    $scope.atualizaValorTotal = function(){
        $scope.valorTotalVenda = parseFloat($scope.quantidade) * parseFloat($scope.valorVenda);
    };

});