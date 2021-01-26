<?php
class main_view_model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('huiui_helper');
    }
    
     function select_current_date(){
        $sql="select get_current_date() as dt;";
        $result = $this->db->query($sql,array());
        if($result==null){
            return null;
        }else{
            return $result->row();
        }
    }

    function select_all_draw_time(){
        $sql="select * from draw_master order by id";
        $result = $this->db->query($sql,array());
        return $result;
    }
    

//
    function select_fr_value(){
        $current_date=get_current_date();
        $sql="select fr_value from draw_details where record_date=? and fr_value>0";
        $result = $this->db->query($sql,array(to_sql_date($current_date)));
        if($result==null){
            return null;
        }else{
            return $result->row();
        }

    }

    function select_sr_value(){
        $current_date=get_current_date();
        $sql="select sr_value from draw_details where record_date=? and sr_value>0";
        $result = $this->db->query($sql,array(to_sql_date($current_date)));
        if($result==null){
            return null;
        }else{
            return $result->row();
        }
    }

    function select_database_changes_status_fr(){
        $sql="select * from database_change where date(now())=date(fr_record_time);";
        $result = $this->db->query($sql,array());
        if($result==null){
            return null;
        }else{
            return $result->row();
        }
    }
    
     function select_database_changes_status_sr(){
        $sql="select * from database_change where date(now())=date(sr_record_time);";
        $result = $this->db->query($sql,array());
        if($result==null){
            return null;
        }else{
            return $result->row();
        }
    }
    
    
    function select_previous_result(){
        $sql="select game_date,max(first) as first,max(second) as second,max(third) as third,max(fourth) as fourth,max(fifth) as fifth
        ,max(sixth) as sixth,max(seventh) as seventh,max(eighth) as eighth,max(ninth) as ninth,max(tenth) as tenth
        from (select *,
        case when id = 1 then result_value end as 'first' ,
        case when id = 2 then result_value end as 'second',
        case when id = 3 then result_value end as 'third',
        case when id = 4 then result_value end as 'fourth' ,
        case when id = 5 then result_value end as 'fifth',
        case when id = 6 then result_value end as 'sixth',
        case when id = 7 then result_value end as 'seventh',
        case when id = 8 then result_value end as 'eighth' ,
        case when id = 9 then result_value end as 'ninth',
        case when id = 10 then result_value end as 'tenth'
        from (select draw_master.id, draw_master.start_time, result_master.result_value, result_master.game_date from draw_master
        left join result_master on draw_master.id = result_master.draw_master_id
        where result_master.game_date between curdate() and  DATE_ADD(curdate(), INTERVAL 5 DAY)) as table1)
        table2 group by game_date";
        $result = $this->db->query($sql,array());
        if($result==null){
            return null;
        }else{
            return $result;
        }
    }

    function select_all_result($startDate,$endDate){
        $sql="select game_date,max(first) as first,max(second) as second,max(third) as third,max(fourth) as fourth,max(fifth) as fifth
        ,max(sixth) as sixth,max(seventh) as seventh,max(eighth) as eighth,max(ninth) as ninth,max(tenth) as tenth
        from (select *,
        case when id = 1 then result_value end as 'first' ,
        case when id = 2 then result_value end as 'second',
        case when id = 3 then result_value end as 'third',
        case when id = 4 then result_value end as 'fourth' ,
        case when id = 5 then result_value end as 'fifth',
        case when id = 6 then result_value end as 'sixth',
        case when id = 7 then result_value end as 'seventh',
        case when id = 8 then result_value end as 'eighth' ,
        case when id = 9 then result_value end as 'ninth',
        case when id = 10 then result_value end as 'tenth'
        from (select draw_master.id, draw_master.start_time, result_master.result_value, result_master.game_date from draw_master
        left join result_master on draw_master.id = result_master.draw_master_id
        where result_master.game_date between ? and  ?) as table1)
        table2 group by game_date order by game_date desc";
        $result = $this->db->query($sql,array($startDate,$endDate));
        if($result==null){
            return null;
        }else{
            return $result;
        }
    }



    function select_today_result(){
        $sql="select game_date,max(first) as first,max(second) as second,max(third) as third,max(fourth) as fourth,max(fifth) as fifth
        ,max(sixth) as sixth,max(seventh) as seventh,max(eighth) as eighth,max(ninth) as ninth,max(tenth) as tenth
        from (select *,
        case when id = 1 then result_value end as 'first' ,
        case when id = 2 then result_value end as 'second',
        case when id = 3 then result_value end as 'third',
        case when id = 4 then result_value end as 'fourth' ,
        case when id = 5 then result_value end as 'fifth',
        case when id = 6 then result_value end as 'sixth',
        case when id = 7 then result_value end as 'seventh',
        case when id = 8 then result_value end as 'eighth' ,
        case when id = 9 then result_value end as 'ninth',
        case when id = 10 then result_value end as 'tenth'
        from (select draw_master.id, draw_master.start_time, result_master.result_value, result_master.game_date from draw_master
        left join result_master on draw_master.id = result_master.draw_master_id where result_master.game_date=curdate()) as table1)table2 group by game_date";
        $result = $this->db->query($sql,array());
        if($result==null){
            return null;
        }else{
            return $result->row();
        }
    }
    

}//final

?>