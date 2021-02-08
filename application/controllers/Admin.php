<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this -> load -> model('Admin_model');
        $this -> is_logged_in();
    }

    function is_logged_in() {
        $is_logged_in = $this -> session -> userdata('is_logged_in');
        $person_cat_id = $this -> session -> userdata('person_cat_id');
//        print_r($this -> session -> userdata());
        if (!isset($is_logged_in) || $is_logged_in != 1 || $person_cat_id!=1) {
            echo 'you have no permission to use admin area'. '<a href="#!login" ng-click="goToFrontPage()">Login</a>';
            die();
        }
    }
	
    public function angular_view_admin(){
    	//testing
        ?>
        <style type="text/css">
            .td-input{
                padding: 2px;
                margin-left: 0px;
                margin-right: 0px;
                text-align: right;
            }
            #purchase-table th, #purchase-table tr td{
                border: 0;
            }
        </style>
        <div class="d-flex">
            <div class="p-2 my-flex-item col-12">
                <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
                    <!-- Brand -->

                    <a class="navbar-brand pull-right" href="#" ng-click="logoutCpanel()">Logout</a>
                    <a class="" href="#" type="button" data-toggle="modal" data-target="#reset-modal">Reset password</a>

                    <!-- Links -->
                    <ul class="navbar-nav">
<!--                        <li class="nav-item">-->
<!--                            <a class="nav-link" href="#!staffArea">Back <i class="fas fa-home"></i></a>-->
<!--                        </li>-->
                    </ul>
                </nav>

            </div>

        </div>
        <div class="d-flex col-12">
            <div class="col-12">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-justified indigo" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#" role="tab" ng-style="tab==1 && selectedTab" ng-click="setTab(1)"> F/R</a>
                    </li>

                </ul>
                <!-- Tab panels -->
                <div class="tab-content">
                    <!--Panel 1-->
                    <div ng-show="isSet(1)">
                        <div id="row my-tab-1">
                            <form name="purchaseForm" class="form-horizontal" id="purchaseForm">
                                <div class="row d-flex col-12 bg-gray-5">
                                 <div class="col-2 bg-gray-2"></div>
                                    <div class="col-8 bg-gray-3">
                                        <div class="d-flex col-12 mt-1 pl-0">
                                            <label  class="col-4">Date</label>
                                            <div class="col-8" ng-if="frMaster">
                                                <span ng-bind="frMaster.record_date+ '  ('+first_record.start_time+''+first_record.meridiem+')'"></span>
                                            </div>
                                        </div>

                                        <div class="d-flex col-12 mt-1 pl-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Time</span>
                                            </div>
                                            <select required  data-ng-model="frMaster.time" ng-change="gettResultByDrawTime(frMaster.time)">
                                                <option ng-repeat="x in drawTimeList" value="{{x.id}}">
                                                {{x.start_time | limitTo:5}}
                                                </option>
                                            </select>
                                        </div>
                                        
                                        <div class="d-flex col-12 mt-1 pl-0">
                                            <label class="col-4">Last Input:</label>
                                            <div class="col-4">
                                                <!-- <span ng-bind="frRecordList.fr_value"></span>-->
                                                <span ng-bind="frRecordList.fr_value>=0 ?frRecordList.fr_value<10? '0'+frRecordList.fr_value : frRecordList.fr_value : ''"></span>
                                                
                                            </div>
                                            <div class="col-2" ng-show="!frButton"><a href="#" ng-click="editLastFrValue()"><i class="fas fa-edit"></i></a></div>
                                        </div>

                                        <div class="d-flex col-12 mt-1 pl-0">
                                            <label class="col-4">Result</label>
                                            <div class="col-8">
                                                <input type="text" numbers-only class="textinput textInput form-control" my-maxlength="1" ng-model="frMaster.fr_value" />
                                            </div>
                                        </div>
                                        <div class="d-flex col-12 mt-1 mb-1 pl-0">
                                            <div class="row col-10 mt-1"></div>
                                            <div class="row col-4 mt-1">
                                                <input type="button" class="btn btn-primary" value="Save" ng-click="saveFirstRecord(frMaster)" ng-hide="!frButton">
                                                <input type="button" class="btn btn-primary" value="Update" ng-click="updateFrValue(frMaster.fr_value)" ng-show="isUpdateableFr">
                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div class="col-2 bg-gray-2"></div>
                                </div>
                            </form>

                        </div> <!--//End of my tab1//-->
                    </div>
                </div>
            </div>
        </div>

        <!-- The modal -->
        <div class="modal fade" id="reset-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title" id="modalLabel">Reset Password</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <form name="resetpsw_form">
                                        
                                        <div class="form-group">
                                        <label for="pwd">Password:</label>
                                        <input type="password" class="form-control" ng-model="resetData.user_password"  placeholder="Enter password" required>
                                        </div>
                                        <button type="submit" ng-click="resetPassword(resetData)"  ng-disabled="resetpsw_form.$invalid" class="btn btn-primary">Reset</button>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>
        </div>
        <?php
    }

        function get_draw_time_list(){
        $result=$this->Admin_model->select_all_draw_time()->result_array();
//        $report_array['records']=$result;
        echo json_encode($result,JSON_NUMERIC_CHECK);
        }

    function save_fr_value(){
        $post_data =json_decode(file_get_contents("php://input"), true);
        $result=$this->Admin_model->insert_fr_value((object)$post_data['data']);
        $report_array['records']=$result;
        echo json_encode($report_array,JSON_NUMERIC_CHECK);
    }

    function save_sr_value(){
        $post_data =json_decode(file_get_contents("php://input"), true);
        $result=$this->Admin_model->insert_sr_value((object)$post_data['srMaster']);
        $report_array['records']=$result;
        echo json_encode($report_array,JSON_NUMERIC_CHECK);
    }
    
    function get_fr_value_for_edit(){
        $result=$this->Admin_model->select_fr_value();
       //$report_array['records']=$result;
        echo json_encode($result,JSON_NUMERIC_CHECK);
    }
    
    function update_fr_record(){
        $post_data =json_decode(file_get_contents("php://input"), true);
        $result=$this->Admin_model->update_fr_value($post_data['frValue'],$post_data['frId']);
        $report_array['records']=$result;
        echo json_encode($report_array,JSON_NUMERIC_CHECK);
    }
    
    function get_sr_value_for_edit(){
        $result=$this->Admin_model->select_sr_value();
       //$report_array['records']=$result;
        echo json_encode($result,JSON_NUMERIC_CHECK);
    }
    
    function update_sr_record(){
        $post_data =json_decode(file_get_contents("php://input"), true);
        $result=$this->Admin_model->update_sr_value($post_data['srValue'],$post_data['srId']);
        $report_array['records']=$result;
        echo json_encode($report_array,JSON_NUMERIC_CHECK);
    }

    function getResultBydrawTime(){
        $post_data =json_decode(file_get_contents("php://input"), true);
        $result=$this->Admin_model->selectResultByDrawTime($post_data['drawId']);
        $report_array['records']=$result;
        echo json_encode($report_array,JSON_NUMERIC_CHECK);
    }


    function logout_cpanel(){
        $newdata = array(
            'person_id'  => '',
            'person_name'     => '',
            'user_id'=> '',
            'person_cat_id'     => '',
            'is_logged_in' => 0
        );
        $this->session->set_userdata($newdata);
        echo json_encode($newdata,JSON_NUMERIC_CHECK);
    }

    function reset_admin_password(){
        $personId=$this->session->userdata('person_id');
        $post_data =json_decode(file_get_contents("php://input"), true);
        $result=$this->Admin_model->update_admin_password((object)$post_data['masterData'],$personId);
        $report_array['records']=$result;
        echo json_encode($report_array,JSON_NUMERIC_CHECK);

    }
}
?>