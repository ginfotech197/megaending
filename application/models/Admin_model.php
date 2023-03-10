<?php
class admin_model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('huiui_helper');
    }

//
    function select_all_draw_time(){
        $sql="select * from draw_master order by id";
        $result = $this->db->query($sql,array());
        return $result;
    }

    function insert_fr_value($frMaster){
        $set_date=get_date_value();
        $return_array=array();
        try{
            $this->db->query("START TRANSACTION");
            $this->db->trans_start();
            //insert into maxtable
            $sql="insert into maxtable (subject_name, current_value,prefix)
            	values('daily_result',1,'')
				on duplicate key UPDATE id=last_insert_id(id), current_value=current_value+1";
            $result = $this->db->query($sql, array());
            if($result==FALSE){
                throw new Exception('Increasing Maxtable for result');
            }

            //getting from maxtable
            $sql="select * from maxtable where id=last_insert_id()";
            $result = $this->db->query($sql);
            if($result==FALSE){
                throw new Exception('error getting maxtable');
            }


            //        adding New Bill Master
            $sql="insert into result_master (
                  draw_master_id
                  ,result_value
                  ,game_date
                ) VALUES (?,?,?)";
            $result=$this->db->query($sql,array(
                $frMaster->time
                ,$frMaster->fr_value
                ,to_sql_date($frMaster->record_date)
            ));

            $return_array['dberror']=$this->db->error();

            if($result==FALSE){
                throw new Exception('error adding sale master');
            }
            // adding draw_details completed
            $sql="update database_change set
			last_table_name='draw_details'
			,fr=?
			,sr_record_time=sr_record_time where id=1";
            $result = $this->db->query($sql,array($frMaster->fr_value));
            if($result==FALSE){
                throw new Exception('error database_change');
            }
            $this->db->trans_complete();
            $return_array['success']=1;
            $return_array['message']='Successfully recorded';
        }catch(mysqli_sql_exception $e){
            //$err=(object) $this->db->error();

            $err=(object) $this->db->error();
            $return_array['error']=create_log($err->code,$this->db->last_query(),'purchase_model','insert_opening',"log_file.csv");
            $return_array['success']=0;
            $return_array['message']='test';
            $this->db->query("ROLLBACK");
        }catch(Exception $e){
            $err=(object) $this->db->error();
            $return_array['error']=create_log($err->code,$this->db->last_query(),'purchase_model','insert_opening',"log_file.csv");
            // $return_array['error']=mysql_error;
            $return_array['success']=0;
            $return_array['message']=$err->message;
            $this->db->query("ROLLBACK");
        }
        return (object)$return_array;
    }//end of function

    function insert_sr_value($srMaster){
        $set_date=get_date_value();
        $return_array=array();
        try{
            $this->db->query("START TRANSACTION");
            $this->db->trans_start();
            //insert into maxtable
            $sql="insert into maxtable (subject_name, current_value,prefix)
            	values('second_record',1,'SR')
				on duplicate key UPDATE id=last_insert_id(id), current_value=current_value+1";
            $result = $this->db->query($sql, array());
            if($result==FALSE){
                throw new Exception('Increasing Maxtable for bill_master');
            }

            //getting from maxtable
            $sql="select * from maxtable where id=last_insert_id()";
            $result = $this->db->query($sql);
            if($result==FALSE){
                throw new Exception('error getting maxtable');
            }
            $draw_details_id=$result->row()->prefix.'-'.leading_zeroes($result->row()->current_value,4).'-'.$set_date;
            $return_array['draw_details_id']=$draw_details_id;


            //        adding New Bill Master
            $sql="insert into draw_details (
                   draw_details_id
                  ,draw_master_id
                  ,sr_value
                  ,record_date
                ) VALUES (?,2,?,?)";
            $result=$this->db->query($sql,array(
                $draw_details_id
            ,$srMaster->sr_value
            ,to_sql_date($srMaster->record_date)
            ));
            $return_array['dberror']=$this->db->error();

            if($result==FALSE){
                throw new Exception('error adding sale master');
            }
            // adding draw_details completed

            $sql="update database_change set last_table_name='draw_details'
            ,sr=?
            ,fr_record_time=fr_record_time
             where id=1";
            $result = $this->db->query($sql,array($srMaster->sr_value));
            if($result==FALSE){
                throw new Exception('error database_change');
            }
            $this->db->trans_complete();
            $return_array['success']=1;
            $return_array['message']='Successfully recorded';
        }catch(mysqli_sql_exception $e){
            //$err=(object) $this->db->error();

            $err=(object) $this->db->error();
            $return_array['error']=create_log($err->code,$this->db->last_query(),'purchase_model','insert_opening',"log_file.csv");
            $return_array['success']=0;
            $return_array['message']='test';
            $this->db->query("ROLLBACK");
        }catch(Exception $e){
            $err=(object) $this->db->error();
            $return_array['error']=create_log($err->code,$this->db->last_query(),'purchase_model','insert_opening',"log_file.csv");
            // $return_array['error']=mysql_error;
            $return_array['success']=0;
            $return_array['message']=$err->message;
            $this->db->query("ROLLBACK");
        }
        return (object)$return_array;
    }//end of function

   function select_fr_value(){
        $sql="select draw_details_id,fr_value, record_date from draw_details where  draw_master_id=1 and
DATE_FORMAT(convert_tz(now(),@@session.time_zone,'+05:30') ,'%Y-%m-%d')=date(record_time)";
        $result = $this->db->query($sql,array());
        if($result==null){
            return null;
        }else{
            return $result->row();
        }

    }

    function update_fr_value($frValue,$frId){
        $return_array=array();
        try{
            $this->db->query("START TRANSACTION");
            $this->db->trans_start();
            //insert into maxtable

            $sql="update draw_details set fr_value=?,record_time=CONVERT_TZ(now(), @@session.time_zone, '+05:30')
where draw_details_id=? and draw_master_id=1";
            $result=$this->db->query($sql,array($frValue,$frId));
            $return_array['dberror']=$this->db->error();

            if($result==FALSE){
                throw new Exception('error updating error value');
            }
            // adding draw_details completed
            $sql="update database_change set last_table_name='draw_details'
				,fr=?
				,fr_record_time=CONVERT_TZ(now(), @@session.time_zone, '+05:30')
				,sr_record_time=sr_record_time where id=1";
            $result = $this->db->query($sql,array($frValue));
            if($result==FALSE){
                throw new Exception('error database_change');
            }
            $this->db->trans_complete();
            $return_array['success']=1;
            $return_array['message']='Update successful';
        }catch(mysqli_sql_exception $e){
            //$err=(object) $this->db->error();

            $err=(object) $this->db->error();
            $return_array['error']=create_log($err->code,$this->db->last_query(),'Admin_model','insert_opening',"log_file.csv");
            $return_array['success']=0;
            $return_array['message']='test';
            $this->db->query("ROLLBACK");
        }catch(Exception $e){
            $err=(object) $this->db->error();
            $return_array['error']=create_log($err->code,$this->db->last_query(),'Admin_model','insert_opening',"log_file.csv");
            // $return_array['error']=mysql_error;
            $return_array['success']=0;
            $return_array['message']=$err->message;
            $this->db->query("ROLLBACK");
        }
        return (object)$return_array;
    }//end of function
    
    
       function select_sr_value(){
	        $sql="select draw_details_id,sr_value, record_date from draw_details where  draw_master_id=2 and
	DATE_FORMAT(convert_tz(now(),@@session.time_zone,'+05:30') ,'%Y-%m-%d')=date(record_time)";
	        $result = $this->db->query($sql,array());
	        if($result==null){
	            return null;
	        }else{
	            return $result->row();
	        }

    	}
    	
    	function update_sr_value($srValue,$srId){
	        $return_array=array();
	        try{
	            $this->db->query("START TRANSACTION");
	            $this->db->trans_start();
	            //insert into maxtable

	            $sql="update draw_details set sr_value=?,record_time=CONVERT_TZ(now(), @@session.time_zone, '+05:30')
	             where draw_details_id=? and draw_master_id=2";
	            $result=$this->db->query($sql,array($srValue,$srId));
	            $return_array['dberror']=$this->db->error();

	            if($result==FALSE){
	                throw new Exception('error updating error value');
	            }
	            // adding draw_details completed
	            $sql="update database_change set last_table_name='draw_details',sr=?,fr_record_time=fr_record_time where id=1";
	            $result = $this->db->query($sql,array($srValue));
	            if($result==FALSE){
	                throw new Exception('error database_change');
	            }
	            $this->db->trans_complete();
	            $return_array['success']=1;
	            $return_array['message']='Update successful';
	        }catch(mysqli_sql_exception $e){
	            //$err=(object) $this->db->error();

	            $err=(object) $this->db->error();
	            $return_array['error']=create_log($err->code,$this->db->last_query(),'Admin_model','insert_opening',"log_file.csv");
	            $return_array['success']=0;
	            $return_array['message']='test';
	            $this->db->query("ROLLBACK");
	        }catch(Exception $e){
	            $err=(object) $this->db->error();
	            $return_array['error']=create_log($err->code,$this->db->last_query(),'Admin_model','insert_opening',"log_file.csv");
	            // $return_array['error']=mysql_error;
	            $return_array['success']=0;
	            $return_array['message']=$err->message;
	            $this->db->query("ROLLBACK");
	        }
	        return (object)$return_array;
	    }//end of function
	    
	    
    
        function selectResultByDrawTime($drawId){
            $sql="select result_value from result_master where draw_master_id=? and game_date=curdate();";
            $result = $this->db->query($sql,array($drawId));
            if($result==null){
                return null;
            }else{
                return $result->row();
            }
        }

        function update_admin_password($pswInfo,$personId){   
            $return_array=array();
            try{
                $this->db->query("START TRANSACTION");
                $this->db->trans_start();
        
                $sql="update person set user_password=md5(?) where person_id=?";
        
                $result=$this->db->query($sql,array(
                    $pswInfo->user_password
                    ,$personId
                ));        
        
                $return_array['dberror']=$this->db->error();
        
                if($result==FALSE){
                    throw new Exception('error adding sale master');
                }
                $this->db->trans_complete();
                $return_array['success']=1;
                $return_array['message']='Successfully recorded';
            }catch(mysqli_sql_exception $e){
                //$err=(object) $this->db->error();        
                $err=(object) $this->db->error();
                $return_array['error']=create_log($err->code,$this->db->last_query(),'Admin_model','update_admin_password',"log_file.csv");
                $return_array['success']=0;
                $return_array['message']='test';
                $this->db->query("ROLLBACK");
            }catch(Exception $e){
                $err=(object) $this->db->error();
                $return_array['error']=create_log($err->code,$this->db->last_query(),'Admin_model','update_admin_password',"log_file.csv");
                // $return_array['error']=mysql_error;
                $return_array['success']=0;
                $return_array['message']=$err->message;
                $this->db->query("ROLLBACK");
            }
            return (object)$return_array;
        }//end of function
    

}//final

?>