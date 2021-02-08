app.controller("adminCtrl", function ($scope,$http,$filter,$rootScope,dateFilter,$timeout,$interval,$window) {
    $scope.msg = "This is admin controller";
    
    //$scope.frButton = false;
    $scope.srButton = false;
    $scope.isUpdateableFr=false;
    $scope.isUpdateableSr=false;
    $scope.tab = 1;
    $scope.sort = {
        active: '',
        descending: undefined
    };
    $scope.findObjectByKey = function(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return array[i];
            }
        }
        return null;
    };
    $scope.changeSorting = function(column) {
        var sort = $scope.sort;

        if (sort.active == column) {
            sort.descending = !sort.descending;
        }
        else {
            sort.active = column;
            sort.descending = false;
        }
    };
    $scope.getIcon = function(column) {
        var sort = $scope.sort;

        if (sort.active == column) {
            return sort.descending
                ? 'glyphicon-chevron-up'
                : 'glyphicon-chevron-down';
        }

        return 'glyphicon-star';
    };

    $scope.setTab = function(newTab){
        $scope.tab = newTab;
    };

    $scope.isSet = function(tabNum){
        return $scope.tab === tabNum;
        if(newTab==1){
            $scope.isUpdateableFr=false;
        }
    };
    
     $scope.selectedTab = {
        "color" : "white",
        "background-color" : "#655D5D",
        "font-size" : "15px",
        "padding" : "5px"
    };
    
    //GET CURRENT SERVER DATE//
    /*$scope.getTodayDate=function(){
    	if($scope.theclock=='12:41:00' && $scope.am_pm=='AM'){
    		alert('2');
    	}
    	return;
		 var request = $http({
            method: "post",
            url: site_url+"/base/get_server_current_date",
            data: {}
            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response){
            $scope.d=response.data;
        });	
	};*/
	
	//$scope.$watch('theclock', $scope.getTodayDate, true);
    
    
    //CONVERT CURRENT TIME INTO MILLISECONDS//
    $scope.getCurrentTimeIntoMilliseconds=function(){
        $scope.holaDate = new Date();
        $scope.holahour = new Date().getHours();
        $scope.holamin = new Date().getMinutes();
        $scope.holasec = new Date().getSeconds();
        $scope.milliSec=(($scope.holahour * 60 + $scope.holamin) * 60 + $scope.holasec) * 1000;
        $scope.am_pm = new Date().getHours() >= 12 ? "PM" : "AM";
    };

    $scope.getCurrentTimeIntoMilliseconds();
    $interval(function () {
        $scope.getCurrentTimeIntoMilliseconds();
        if($scope.holahour>=21){
            $scope.remainingTime=(86400000 -$scope.milliSec)+$scope.drawMilliSec;
        }else{
            $scope.remainingTime=$scope.drawMilliSec-$scope.milliSec;
        }

    },1000);

    $scope.frMaster={
        fr_value: '',time:''
    };
    $scope.srMaster={
        sr_value: ''
    };

    $scope.dd = new Date().getDate();
    $scope.mm = new Date().getMonth()+1;
    $scope.yy = new Date().getFullYear();
    $scope.day= ($scope.dd<10)? '0'+$scope.dd : $scope.dd;
    $scope.month= ($scope.mm<10)? '0'+$scope.mm : $scope.mm;
    $scope.frMaster.record_date=($scope.day+"/"+$scope.month+"/"+$scope.yy);
    $scope.srMaster.record_date=($scope.day+"/"+$scope.month+"/"+$scope.yy);

    $scope.updateTime = function(){
        $timeout(function(){
            $scope.theclock = (dateFilter(new Date(), 'hh:mm:ss'));
            $scope.updateTime();
        },1000);
    };
    $scope.updateTime();

    $scope.getDrawMaster=function () {
        var request = $http({
            method: "post",
            url: site_url+"/Admin/get_draw_time_list",
            data: {}
            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response){
            $scope.drawTimeList=response.data;
            $scope.first_record=alasql('select * from ? where status= "first_record"',[$scope.drawTimeList])[0];
            $scope.second_record=alasql('select * from ? where status= "second_record"',[$scope.drawTimeList])[0];

        });
    };
    $scope.getDrawMaster();


    $scope.gettResultByDrawTime=function (drawId) {
        var request = $http({
            method: "post",
            url: site_url+"/Admin/getResultBydrawTime",
            data: {drawId: drawId}
            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response){
            var result= response.data.records.result_value;
            if(result>0){
                $scope.frMaster.fr_value = result;
            }

        });
    };

   /* $scope.enableSubmitButtonByDrawTime=function () {
        if($scope.theclock==$scope.first_record.start_time && $scope.am_pm==$scope.first_record.meridiem){
            $scope.frButton = true;
        }
        if($scope.theclock==$scope.second_record.start_time && $scope.am_pm==$scope.second_record.meridiem){
            $scope.srButton = true;
        }
    }*/
    
    
   
    //$scope.$watch('theclock', $scope.enableSubmitButtonByDrawTime, true);

    $scope.saveFirstRecord=function(resultSet){
        console.log(resultSet);
    	var inputLength=resultSet.fr_value.length;
    	if(inputLength>0){
	        var request = $http({
	            method: "post",
	            url: site_url+"/Admin/save_fr_value",
	            data: {
	                data: resultSet
	            }
	            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
			 }).then(function(response){
		            $scope.frDatabaseReport=response.data.records;
		             if($scope.frDatabaseReport.success==1){
		                alert("Result added successful");
		            }
		            var temp={};
		            temp.fr_value=frMaster.fr_value/1;
		            temp.record_date='Today'
		            $scope.frRecordList=angular.copy(temp);
		            $scope.frButton=false;           
		        });
        }else{
            alert('Input is not valid');
        }

    };

    //FOR SR VALUE//

    $scope.saveSecondRecord=function(srMaster){
    	var srLnth=srMaster.sr_value.length;
    	if(srLnth>1){
			var request = $http({
	            method: "post",
	            url: site_url+"/Admin/save_sr_value",
	            data: {
	                srMaster: srMaster
	            }
	            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
	       	 }).then(function(response){
	            $scope.srDatabaseReport=response.data.records;
	            if($scope.srDatabaseReport.success==1){
	                alert("Sr input successful");
	            }
	            var temp={};
	            temp.sr_value=srMaster.sr_value/1;
	            temp.record_date='Today'
	            $scope.srRecordList=angular.copy(temp);
	            $scope.srButton=false; 
	        });
		}else{
			alert('Input is not valid')
		}

    };
	
	$scope.frButton=true;
	$scope.showFrValueToday=function(){
		var request = $http({
            method: "post",
            url: site_url+"/Admin/get_fr_value_for_edit",
            data: {}
            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response){
            $scope.frRecordList=response.data;
            if($scope.frRecordList.fr_value>=0){
				$scope.frButton=false;
			}
			
        });	
	};
	
	$scope.showFrValueToday();
	// $interval(function () {
    //     $scope.showFrValueToday();

    // },10000);
	
	//EDIT THE LAST FR-VALUE//
	
	$scope.editLastFrValue=function(){
		$scope.showFrValueToday();
		if($scope.frRecordList.fr_value<10){
			$scope.frMaster.fr_value='0'+$scope.frRecordList.fr_value;
		}else{
			$scope.frMaster.fr_value=$scope.frRecordList.fr_value;
		}
		
		$scope.isUpdateableFr=true;
	};
	
	$scope.updateFrValue=function(frVal){
		var frLnth=frVal.length;
		if(frLnth>1){
			var frId=$scope.frRecordList.draw_details_id;
			var request = $http({
	            method: "post",
	            url: site_url+"/Admin/update_fr_record",
	            data: {
	                frValue: frVal
	                ,frId: frId
	                
	            }
	            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
	        }).then(function(response){
	            $scope.updatefrValue=response.data.records;
	             if($scope.updatefrValue.success==1){
	                alert("Update successfull");
	            }
	            var temp={};
	            temp.fr_value=frVal/1;
	            temp.record_date='Today'
	            $scope.frRecordList=angular.copy(temp);
	            $scope.isUpdateableFr=false;
	        });
		}else{
			alert('Input is not valid');
		}

	};
	
	
	//sr//
	$scope.srButton=true;
	$scope.showSrValueToday=function(){
		var request = $http({
            method: "post",
            url: site_url+"/Admin/get_sr_value_for_edit",
            data: {}
            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response){
            $scope.srRecordList=response.data;
            //console.log($scope.srRecordList.sr_value);
            if($scope.srRecordList.sr_value>=0){
				$scope.srButton=false;
			}
			
        });	
	};
	$scope.showSrValueToday();
	// $interval(function () {
    //     $scope.showSrValueToday();

    // },1000);
	
	$scope.editLastSrValue=function(){
		$scope.showSrValueToday();
		if($scope.srRecordList.sr_value<10){
			$scope.srMaster.sr_value='0'+$scope.srRecordList.sr_value;
		}else{
			$scope.srMaster.sr_value=$scope.srRecordList.sr_value;
		}
		
		$scope.isUpdateableSr=true;
	};
	
	$scope.updateSrValue=function(srVal){
		var srLnth=srVal.length;
		if(srLnth>1){
			//console.log($scope.srRecordList.draw_details_id);
			var srId=$scope.srRecordList.draw_details_id;
			
			var request = $http({
	            method: "post",
	            url: site_url+"/Admin/update_sr_record",
	            data: {
	                srValue: srVal
	                ,srId: srId
	                
	            }
	            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
	        }).then(function(response){
	            $scope.updatesrValue=response.data.records;
	             if($scope.updatesrValue.success==1){
	                alert("Update successfull");
	            }
	            var temp={};
	            temp.sr_value=srVal/1;
	            temp.record_date='Today'
	            $scope.srRecordList=angular.copy(temp);
	            $scope.isUpdateableSr=false;
	        });
		}else{
			alert('Input is not valid');
		}

	};

	$scope.logoutCpanel=function () {
        var request = $http({
            method: "post",
            url: site_url+"/Admin/logout_cpanel",
            data: {}
            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response){
            $window.location.href = base_url+'#!/login';
        });
    };

    $scope.resetData={};
    $scope.resetPassword=function(resetData){
        //    console.log(resetData);
        var request = $http({
            method: "post",
            url: site_url+"/Admin/reset_admin_password",
            data: {
                masterData: resetData
            }
            ,headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(response){
            $scope.resetRecord=response.data.records;
            if($scope.resetRecord.success==1){
                alert('Password reset successfully');
                $(".modal-backdrop").hide();
                $('#reset-modal').modal('hide');
                $scope.logoutCpanel();
             
                
            }
        });       
    };




});

