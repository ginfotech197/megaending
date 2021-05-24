<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Results extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this -> load -> model('Main_view_model');
//        $this -> is_logged_in();
    }
//    function is_logged_in() {
//		$is_logged_in = $this -> session -> userdata('is_logged_in');
//		if (!isset($is_logged_in) || $is_logged_in != 1) {
//			echo 'you have no permission to use developer area'. '<a href="">Login</a>';
//			die();
//		}
//	}

    public function previous_result_view(){
        ?>
        <style>
            .my-table tr td{
                border: 2px solid black;
            }

            .my-table-result tr th{
                border: 1px solid black;
            }
            .my-table-result tr td{
                border: 1px solid black;
            }
            .my-table-result tr{
                line-height: 0px;
                border: 2px solid black;

            }
        </style>
        <div class="d-flex justify-content-center">
            <div class=""><input type="date" class="form-control" ng-model="start_date" ng-change="changeDateFormat(start_date)"></div>
            <div class="ml-2 mr-2">To</div>
            <div class=""><input type="date" class="form-control" ng-model="end_date" ng-change="changeDateFormat(end_date)"></div>
            <div class="ml-2"><input type="button" class="btn btn-info form-control" value="Show" ng-click="showAllResults(start_date,end_date)"></div>
        </div>



        <table class="table table-bordered my-table-result mt-1 responsive" style="white-space: nowrap" ng-init="showAllResults()">
            <thead>
                <tr>
                    <th  colspan="3">Date</th>
                    <th ng-repeat="x in drawTimeList">{{x.start_time | limitTo:5}}</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="x in allResults">
                    <td  colspan="3">{{x.game_date}}</td>
                    <td><b class="text-weight-bold">X</b>{{x.first || 'X'}}</td>

                    <td><b class="text-weight-bold">X</b>{{x.second || 'X'}}</td>
                    
                    <td><b class="text-weight-bold">X</b>{{x.third || 'X'}}</td>

                    <td> <b class="text-weight-bold">X</b>{{x.fourth || 'X'}}</td>
                    
                    <td> <b class="text-weight-bold">X</b>{{x.fifth || 'X'}}</td>
                    
                    <td> <b class="text-weight-bold">X</b>{{x.sixth || 'X'}}</td>
                    
                    <td> <b class="text-weight-bold">X</b>{{x.seventh || 'X'}}</td>
                    
                    <td> <b class="text-weight-bold">X</b>{{x.eighth || 'X'}}</td>
                    
                    <td> <b class="text-weight-bold">X</b>{{x.ninth || 'X'}}</td>
                    
                    <td> <b class="text-weight-bold">X</b>{{x.tenth || 'X'}}</td>
                </tr>
            </tbody>
        </table>

        <?php
    }


    function get_all_result_to_show(){
        $post_data =json_decode(file_get_contents("php://input"), true);
        $result=$this->Main_view_model->select_all_result($post_data['startDate'],$post_data['endDate']);
        $report_array['records']=$result->result_array();
        echo json_encode($report_array,JSON_NUMERIC_CHECK);
    }
}
?>