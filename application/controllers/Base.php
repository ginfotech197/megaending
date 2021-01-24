<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this -> load -> model('Person');
        $this -> load -> model('main_view_model');
    }
    public function index()
    {
        $this->load->view('public/index_top');
        $this->load->view('public/index_main');
        $this->load->view('public/index_end');
    }

    public function angular_view_main(){
        $this->load->view('angular_views/main');
    }

    public function validate_credential(){
        $post_data =json_decode(file_get_contents("php://input"), true);
        $result=$this->Person->get_person_by_authentication((object)$post_data);
        $newdata = array(
            'person_id'  => $result->person_id,
            'person_name'     => $result->person_name,
            'user_id'=> $result->user_id,
            'person_cat_id'     => $result->person_cat_id,
            'is_logged_in' => $result->is_logged_in
        );
        $this->session->set_userdata($newdata);
        echo json_encode($newdata);
    }


    public function show_headers(){
        if($_GET['person_cat_id']==3){
            $this->load->view('menus/index_header_staff');
        }
        if($_GET['person_cat_id']==1){
            $this->load->view('menus/index_header_admin');
        }
    }
    public function angular_view_home(){
        $newdata = array(
            'person_id'  => '',
            'person_name' => '',
            'user_id'=> '',
            'person_cat_id' => 0,
            'is_logged_in' => 0
        );
        $this->session->set_userdata($newdata);
        ?>
        <style type="text/css">
            .my-table tr th{
                border: 2px solid black;
                
                background-color: orange ;
                width: 200px;
                height: 50px;
                text-align: center;
                font-size: 30px;
                font-weight: bold;
                color: white;
            }
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

            /*************Css For Gallery***************/
            div.gallery {
                margin: 5px;
                border: 1px solid #ccc;
                float: left;
                width: 100px;
            }

            div.gallery:hover {
                border: 2px solid #777;
            }

            div.gallery img {
                width: 100%;
                height: auto;
            }

            div.desc {
                padding: 15px;
                text-align: center;
            }
            .slideshow-container {
        max-width: 1000px;
        position: relative;
        margin: auto;
    }
    /* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active {
  background-color: #717171;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}
.caption{
    color: black;
    position: absolute;
    top: 80%;
    left: 50%;
    transform: translate(-50%, -50%);

}

@-webkit-keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}
.td{
        border: 1px solid black;
        background-color: orange ;
        width: 200px;
        height: 50px;
        text-align: center;
        font-size: 30px;
        font-weight: bold;
        color: white;
    }
    .tr{
        font-size: 30px;
        font-weight: bold;
        text-align: center;
    }

        </style>

        <div class="row d-flex align-content-center bg-success" >
            <div class="col-3">
                <img src="img/teer-icon.png" class="img-responsive mt-1 mb-1" height="80" width="80" align="left">

            </div>
            <div class="col-6"></div>
            <div class="col-3 pull right">
                <!--<img src="img/live.gif" class="img-responsive mt-1 mb-1" height="100" width="300" align="left">-->
            </div>
            <div class="col-12">
                <h1 align="center" class="text-white"><script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({
                            google_ad_client: "ca-pub-6198621255698529",
                            enable_page_level_ads: true
                        });
                    </script> </h1>
            </div>
            <div class="col-10"></div>

        </div>
        <div class="row text-danger" style="background-color: red;"><marquee style="color: yellow;"><h1>WELCOME TO SIKKIM TEER RESULTS</h1></marquee></div>
        <div class="row d-flex" style="background-color: #22a794;">
            <div class="col-12 text-center table-responsive">
                <p class="text-center"><?php echo get_current_date();?></p>
                <table class="table table-bordered my-table mt-1">
                    <thead>
                    <tr>
                        <th colspan="10">SHILLONG ENDING RESULT</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-warning">
                            <td>9:15</td>
                            <td>9:15</td>
                            <td>9:15</td>
                            <td>9:15</td>
                            <td>9:15</td>
                            <td>9:15</td>
                            <td>9:15</td>
                            <td>9:15</td>
                            <td>9:15</td>
                            <td>9:15</td>
                        </tr>
                        <tr>
                            <td>
                            {{databaseChangesReportValueFr.fr!=null ? databaseChangesReportValueFr.fr<10? '0' + databaseChangesReportValueFr.fr : databaseChangesReportValueFr.fr : 'XX'}}
                            </td>

                            <td> {{databaseChangesReportValueSr.sr!=null ? databaseChangesReportValueSr.sr<10? '0'+ databaseChangesReportValueSr.sr : databaseChangesReportValueSr.sr : 'XX'}}</td>
                            
                            <td>{{databaseChangesReportValueFr.fr!=null ? databaseChangesReportValueFr.fr<10? '0' + databaseChangesReportValueFr.fr : databaseChangesReportValueFr.fr : 'XX'}}</td>

                            <td> {{databaseChangesReportValueSr.sr!=null ? databaseChangesReportValueSr.sr<10? '0'+ databaseChangesReportValueSr.sr : databaseChangesReportValueSr.sr : 'XX'}}</td>
                            
                            <td> {{databaseChangesReportValueSr.sr!=null ? databaseChangesReportValueSr.sr<10? '0'+ databaseChangesReportValueSr.sr : databaseChangesReportValueSr.sr : 'XX'}}</td>
                            
                            <td> {{databaseChangesReportValueSr.sr!=null ? databaseChangesReportValueSr.sr<10? '0'+ databaseChangesReportValueSr.sr : databaseChangesReportValueSr.sr : 'XX'}}</td>
                            
                            <td> {{databaseChangesReportValueSr.sr!=null ? databaseChangesReportValueSr.sr<10? '0'+ databaseChangesReportValueSr.sr : databaseChangesReportValueSr.sr : 'XX'}}</td>
                            
                            <td> {{databaseChangesReportValueSr.sr!=null ? databaseChangesReportValueSr.sr<10? '0'+ databaseChangesReportValueSr.sr : databaseChangesReportValueSr.sr : 'XX'}}</td>
                            
                            <td> {{databaseChangesReportValueSr.sr!=null ? databaseChangesReportValueSr.sr<10? '0'+ databaseChangesReportValueSr.sr : databaseChangesReportValueSr.sr : 'XX'}}</td>
                            
                            <td> {{databaseChangesReportValueSr.sr!=null ? databaseChangesReportValueSr.sr<10? '0'+ databaseChangesReportValueSr.sr : databaseChangesReportValueSr.sr : 'XX'}}</td>


                        </tr>

                    </tbody>
                </table>


                
            </div>
        </div>

        <div class="row d-flex bg-dark text-center">
            <div class="bg-dark text-white col-12 text-center" style="text-shadow: 2px 2px 5px red">
                <h1>SHILLONG ENDING RESULT</h1>

            </div>
        </div>

        <div class="row d-flex bg-light mb-1 mt-1">
            <div class="col-1"></div>
            <div class="col-10 text-center">
                <button type="button" class="btn btn-primary" ng-click="showPreviousResults()">Previous Result&nbsp;</button>
                <button type="button" class="btn btn-warning" ng-click="hidePreviousResults()" ng-show="showResult">&nbsp;Hide</button>
                <a href="#!previousResult" target="_blank" class="btn pull-right" role="button">Show more</a>
            </div>
            <div class="col-10"></div>
        </div>

        <div class="row d-flex bg-maroon text-center" ng-show="showResult" >

            <div class="col-1 bg-gray-2"></div>
            <div class="col-10 text-center table-responsive bg-gray-2">
                <table class="table table-bordered my-table-result mt-1">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>FR</th>
                        <th>SR</th>
                    </tr>
                    </thead>
                    <tbody ng-repeat="x in previousRecordsList">
                    <tr>
                        <td>{{x.record_time}}</td>
                        <td>{{x.fr_value!=null ? x.fr_value<10? '0'+x.fr_value : x.fr_value : 'XX'}}</td>
                        <td>{{x.sr_value!=null? x.sr_value<10? '0'+x.sr_value : x.sr_value : 'XX'}}</td>
                    </tr>
                    </tbody>
                </table>
                
            </div>
            <div class="col-1 bg-gray-2"></div>



            <!--testing-->
        </div>



        <div class="row d-flex bg-dark text-center">
            <div class="p-2 bg-gray-4 col-7 text-center">
                <!--<img class="img-responsive" src="img/icon1.png" height="80" width="80" align="left">-->
                <div class="gallery">
                    <a target="_blank" href="fjords.jpg">
                        <img src="img/gallery/1.1.jpg" alt="Cinque Terre" width="100" height="75">
                    </a>
                </div>

                <div class="gallery">
                    <a target="_blank" href="forest.jpg">
                        <img src="img/gallery/2.2.jpg" alt="Forest" width="100" height="75">
                    </a>
                </div>
                

                <div class="gallery">
                    <a target="_blank" href="lights.jpg">
                        <img src="img/gallery/3.jpg" alt="Northern Lights" width="100" height="75">
                    </a>
                </div>

                <div class="gallery">
                    <a target="_blank" href="">
                        <img src="img/gallery/4.jpg" alt="Mountains" width="100" height="75">
                    </a>
                </div>
            </div>
            <div class="p-2 bg-gray-2 col-5">
                <!--<pre>databaseChangesReportValue = {{databaseChangesReportValue | json}}</pre>-->
                <p class="font-italic text-justify" style="font-size: 8px"> Teer Result | Sikkim Teer | Teer Result  Today

                    Our site is only for those users who are over 18 years of age or you can leave our site yourself now. And if you continue browsing our site then you are disobeying the rules of our
                    website. Our site is not involved in any gambling. Our site only provides teer results collected from (Sikkim Teer Association). Our site is for informational purpose only!
                </p>
            </div>
        </div>
        <div class="d-flex">
            <div class="col-2"></div>
            <div class="col-8">
                <div style="background-color: violet; text-align: center;">
                    <div class="slideshow-container">
                    <div class="mySlides fade">
                                <div class="numbertext">1 / 5</div>
                                <a target="_blank" href="https://www.amazon.in/"><img width="200px" src="application/controllers/image/picture1.png" alt=""></a>
                                <div class="text caption"id="black">Caption Text</div>
                    </div>
                    <div class="mySlides fade">
                                <div class="numbertext">2 / 5</div>
                                <a target="_blank" href="https://www.myntra.com/"><img width="200px" src="application/controllers/image/picture2.jpg" alt=""></a>
                                <div class="text caption">Caption Text</div>
                    </div>
                    <div class="mySlides fade">
                                <div class="numbertext">3 / 5</div>
                                <a target="_blank" href="https://www.flipkart.com/"><img width="200px" src="application/controllers/image/picture3.jpg" alt=""></a>
                                <div class="text caption">Caption Text</div>
                    </div>
                    <div class="mySlides fade">
                                <div class="numbertext">4 / 5</div>
                                <a target="_blank" href="https://www.zomato.com/kolkata"><img width="200px" src="application/controllers/image/picture4.jpg" alt=""></a>
                                <div class="text caption">Caption Text</div>
                    </div>
                    
                    </div>
                    <div style="text-align:center">
                                <span class="dot"></span> 
                                <span class="dot"></span> 
                                <span class="dot"></span> 
                                <span class="dot"></span> 
                    </div>
                            

                    <script>
                                var slideIndex = 0;
                                showSlides();//methode calling
                                
                                function showSlides() {
                                var i;
                                var slides = document.getElementsByClassName("mySlides");
                                var dots = document.getElementsByClassName("dot");
                                for (i = 0; i < slides.length; i++) {
                                    slides[i].style.display = "none";  
                                }
                                slideIndex++;
                                if (slideIndex > slides.length) {slideIndex = 1}    
                                for (i = 0; i < dots.length; i++) {
                                    dots[i].className = dots[i].className.replace(" active", "");
                                }
                                slides[slideIndex-1].style.display = "block";  
                                dots[slideIndex-1].className += " active";
                                setTimeout(showSlides, 2000); // Change image every 2 seconds
                                }
                    </script>
                    </div>
                </div>
                <div>
            </div>
            <div class="col-2"></div>
        </div>



        <?php
    }
    public function angular_view_login(){
        ?>
        <style type="text/css">
            body,html {
                height: 50%;
                /*background-color: green;*/
                background: linear-gradient(to bottom, #0D3349 0%, #4F5155 400%);
            }

        </style>
        <div class="row mt-5">
            <div class="col-md-12">
                <h4 class="text-center text-white mb-4"><i class="fa fa-user"></i> User Login</h4>
                <div class="row">
                    <div class="col-md-4 mx-auto">

                        <!-- form card login -->
                        <div class="card rounded-0">

                            <div class="card-body">
                                <form class="form form-horizontal" role="form" autocomplete="off" id="formLogin" novalidate="" method="POST">
                                    <div class="form-group col-12">
                                        <label for="uname1" class=""><i class="fa fa-user"></i> Username</label>
                                        <input type="text" ng-model="loginData.user_id" class="form-control form-control-lg" name="uname1" id="uname1" required="">
                                    </div>
                                    <div class="form-group col-12">
                                        <label class=""><i class="fas fa-key"></i> Password</label>
                                        <input type="password" ng-model="loginData.user_password" class="form-control form-control-lg" id="pwd1" required="" autocomplete="new-password">
                                    </div>
                                    <div class="row form-group col-12 justify-content-center">
                                        <button type="submit" ng-click="login(loginData)" class="btn btn-success btn-lg" id="btnLogin">Login</button>
                                    </div>

                                </form>
                            </div>
                            <!--/card-block-->
                        </div>
                        <!-- /form card login -->
                    </div>
                </div>
                <!--/row-->
            </div>

            <!--/col-->
            
            
        </div>
        <!--/row-->




        <?php
    }


    function get_fr_value_for_display(){
        $result=$this->main_view_model->select_fr_value();
//        $report_array['records']=$result;
        echo json_encode($result,JSON_NUMERIC_CHECK);
    }
    function get_sr_value_for_display(){
        $result=$this->main_view_model->select_sr_value();
//        $report_array['records']=$result;
        echo json_encode($result,JSON_NUMERIC_CHECK);
    }
    function get_database_changes_report_for_fr(){
        $result=$this->main_view_model->select_database_changes_status_fr();
//        $report_array['records']=$result;
        echo json_encode($result,JSON_NUMERIC_CHECK);
    }

    function get_database_changes_report_for_sr(){
        $result=$this->main_view_model->select_database_changes_status_sr();
//        $report_array['records']=$result;
        echo json_encode($result,JSON_NUMERIC_CHECK);
    }


    function get_previous_result(){
        $result=$this->main_view_model->select_previous_result();
        $report_array['records']=$result->result_array();
        echo json_encode($report_array,JSON_NUMERIC_CHECK);
    }

    function get_draw_time_list(){
        $result=$this->main_view_model->select_all_draw_time()->result_array();
//        $report_array['records']=$result;
        echo json_encode($result,JSON_NUMERIC_CHECK);
    }
}
?>

     