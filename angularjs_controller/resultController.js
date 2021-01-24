app.controller("resultCtrl", function ($scope,$window,$http) {
    $scope.showAllResults=function(){
        var request = $http({
            method: "post",
            url: site_url+"/Results/get_all_result_to_show",
            data: {}
            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response){
            $scope.allResults=response.data.records;
        });
    };

    $scope.showAllResults();
});

