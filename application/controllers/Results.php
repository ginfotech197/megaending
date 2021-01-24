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
        <table class="table table-bordered my-table-result mt-1" ng-init="showAllResults()">
            <thead>
            <tr>
                <th scope="col" class="text-center">Date</th>
                <th scope="col" class="text-center">FR</th>
                <th scope="col" class="text-center">SR</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="x in allResults">
                <th scope="row" class="text-center">{{x.record_time}}</th>
                <td class="text-center">{{x.fr_value!=null ? x.fr_value<10? '0'+x.fr_value : x.fr_value : 'XX'}}</td>
                <td class="text-center">{{x.sr_value!=null ? x.sr_value<10? '0'+x.sr_value : x.sr_value : 'XX'}}</td>

            </tr>
            </tbody>
        </table>

        <?php
    }


    function get_all_result_to_show(){
        $result=$this->Main_view_model->select_all_result();
        $report_array['records']=$result->result_array();
        echo json_encode($report_array,JSON_NUMERIC_CHECK);
    }
}
?>