app.controller("mainCtrl", function ($scope,$http,$filter,md5,$window,$interval) {
    $scope.msg = " This is main controller";
    $scope.showResult=false;
    var request = $http({
            method: "post",
            url: site_url+"/base/get_server_current_date",
            data: {}
            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response){
            $scope.d=response.data;
        });
    

    $scope.getDrawMaster=function () {
        var request = $http({
            method: "post",
            url: site_url+"/Base/get_draw_time_list",
            data: {}
            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response){
            $scope.drawTimeList=response.data;
            // $scope.first_record=alasql('select * from ? where status= "first_record"',[$scope.drawTimeList])[0];
            // $scope.second_record=alasql('select * from ? where status= "second_record"',[$scope.drawTimeList])[0];

        });
    };

    $scope.getTodayTeerResult=function () {
        var request = $http({
            method: "post",
            url: site_url+"/Base/get_today_teer_result",
            data: {}
            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response){
            $scope.todayResultList=response.data;
            

        });
    };

    $scope.getTodayTeerResult();




    $scope.getDrawMaster();

    $scope.getFrValue=function () {
        var request = $http({
            method: "post",
            url: site_url+"/base/get_fr_value_for_display",
            data: {}
            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response){
            $scope.displayFrValue=response.data;
        });
    };

    $scope.getFrValue();

    $scope.getSrValue=function () {
        var request = $http({
            method: "post",
            url: site_url+"/base/get_sr_value_for_display",
            data: {}
            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response){
            $scope.displaySrValue=response.data;
        });
    };

    $scope.getSrValue();

    $scope.checkDatabaseChangesForFr=function(){
        var request = $http({
            method: "post",
            url: site_url+"/base/get_database_changes_report_for_fr",
            data: {}
            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response){
            $scope.databaseChangesReportValueFr=response.data;
        });
    };
    $scope.checkDatabaseChangesForFr();
    $interval(function () {
        $scope.checkDatabaseChangesForFr();

    },10000);
    
    $scope.checkDatabaseChangesForSr=function(){
        var request = $http({
            method: "post",
            url: site_url+"/base/get_database_changes_report_for_sr",
            data: {}
            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response){
            $scope.databaseChangesReportValueSr=response.data;
        });
    };
    $scope.checkDatabaseChangesForSr();
    $interval(function () {
        $scope.checkDatabaseChangesForSr();

    },10000);


    $scope.showPreviousResults=function(){

    	$scope.showResult=true;
		var request = $http({
            method: "post",
            url: site_url+"/base/get_previous_result",
            data: {}
            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response){
            $scope.previousRecordsList=response.data.records;
        });
	};

	
	$scope.hidePreviousResults=function(){
		$scope.showResult=false;
	};



});

