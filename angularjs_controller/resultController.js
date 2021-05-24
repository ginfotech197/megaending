app.controller("resultCtrl", function ($scope,$window,$http) {

    $scope.changeDateFormat=function(userDate){
        return moment(userDate).format('YYYY-MM-DD');
    };
    $scope.start_date = new Date();
    $scope.end_date = new Date();
    
    $scope.getDrawMaster=function () {
        var request = $http({
            method: "post",
            url: site_url+"/Base/get_draw_time_list",
            data: {}
            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response){
            $scope.drawTimeList=response.data;
        });
    };
    $scope.getDrawMaster();
    
    $scope.showAllResults=function(start_date,end_date){
        var startDate=$scope.changeDateFormat(start_date);
        var endDate=$scope.changeDateFormat(end_date);
        var request = $http({
            method: "post",
            url: site_url+"/Results/get_all_result_to_show",
            data: {
                startDate: startDate,
                endDate: endDate
            }
            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response){
            $scope.allResults=response.data.records;
        });
    };
});

