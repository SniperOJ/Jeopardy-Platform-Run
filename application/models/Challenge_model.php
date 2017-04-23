<?php

class User_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();
    }

    /* 获取单个 chellenge 的详细信息 */
    public function get_challenge_info($challenge_id)
    {
        $query = $this->db
            ->select(array(
                'challenge_id',
                'name',
                'description',
                'score',
                'type',
                'online_time',
                'visit_times',
                'fixing',
                'resource',
                'document',
            ))
            ->where('challenge_id',$challenge_id)
            ->get('challenges');
        $challenge = $query->row_array();
            $challenge['solved_times'] = $this->get_challenge_solved_times($challenge['challenge_id']);
            $challenge['submit_times'] = $this->get_challenge_submit_times($challenge['challenge_id']);
        return $challenge;
    }

    /* 获取所有 challenges 的简要描述 */
    public function get_all_challenges()
    {
        $query = $this->db
            ->where(array("fixing" => "0"))
            ->get("challenges");
        $challenges = $query->result_array();
        for ($i=0; $i < count($challenges); $i++) { 
            $challenges[$i]['solved_times'] = $this->get_challenge_solved_times($challenges[$i]['challenge_id']);
            $challenges[$i]['submit_times'] = $this->get_challenge_submit_times($challenges[$i]['challenge_id']);
        }
        return $challenges;
    }

    /* 根据用户 id 对 challenges 进行清洗 */
    public function filter_by_user_id($challenges, $user_id)
    {
        for ($i=0; $i < count($challenges); $i++) { 
            $challenges[$i]['is_solved'] = $this->is_solved_by_user_id($challenges[$i]['challenge_id'], $user_id);
        }
    }

    /* 获取指定 challenge 是否被指定 user 解决 */
    public function is_solved_by_user_id($challenge_id, $user_id)
    {
        $query = $this->db->select('submit_time')
        ->where(array(
            "challenge_id" => $challenge_id,
            "user_id" => $user_id,
            "is_current" => "1"
        ))
        ->get('submit_log');
        $result = $query->num_rows();
        return $result;
    }

    /* 获取 challenge 被解决的次数 */
    public function get_challenge_solved_times($challenge_id){
        $query = $this->db->select('submitID')
        ->where(array(
            "is_current" => "1",
            "challenge_id" => $challenge_id,
        ))
        ->get('submit_log');
        $result = $query->num_rows();
        return $result;
    }

    /* 获取 challenge 被提交的次数 */
    public function get_challenge_submit_times($challenge_id){
        $query = $this->db->select('submitID')
        ->where(array(
            "challenge_id" => $challenge_id,
        ))
        ->get('submit_log');
        $result = $query->num_rows();
        return $result;
    }

    /* 获取指定类型的 challenge */
    public function get_type_challenges($user_id, $type)
    {
        $query = $this->db
            ->where(array(
                "fixing" => "0",
                "type" => $type,
            ))
            ->get("challenges");
        $challenges = $query->result_array();
        for ($i=0; $i < count($challenges); $i++) { 
            $challenges[$i]['solved_times'] = $this->get_challenge_solved_times($challenges[$i]['challenge_id']);
            $challenges[$i]['submit_times'] = $this->get_challenge_submit_times($challenges[$i]['challenge_id']);
            $challenges[$i]['is_solved'] = $this->is_solved_by_user_id($challenges[$i]['challenge_id'], $user_id);
        }
        return $challenges;
    }

    /* 更新点击量 */
    public function update_visit_times($challenge_id)
    {
        $visit_times = intval($this->get_visit_times($challenge_id));
        $this->set_visit_times($challenge_id, $visit_times+1);
    }

    /* 人性化显示时间 */
    function formatTime($time){       
        $rtime = date("Y年m月d日 H:i",$time);       
        $htime = date("H:i",$time);             
        $time = time() - $time;         
        if ($time < 60){           
            $str = '刚刚';       
        }elseif($time < 60 * 60){           
            $min = floor($time/60);           
            $str = $min.'分钟前';       
        }elseif($time < 60 * 60 * 24){           
            $h = floor($time/(60*60));           
            $str = $h.'小时前 ';       
        }elseif($time < 60 * 60 * 24 * 3){           
            $d = floor($time/(60*60*24));           
            if($d==1){  
                $str = '昨天 '.$htime;
            }else{  
                $str = '前天 '.$htime;       
            }  
        }else{           
            $str = $rtime;       
        }       
        return $str;
    }

    /* 获取战况 */
    public function get_progress($offset_time){
        $query = $this->db->select(array('challenge_id', 'user_id', 'submit_time'))
        ->where(array(
            'is_current' => '1',
            'submit_time > ' => time() - $offset_time,
        ))
        ->get('submit_log');
        $result = $query->result_array();
        for ($i=0; $i < count($result); $i++) { 
            $result[$i]['submit_time'] = $this->formatTime($result[$i]['submit_time']);
            $user_id = $result[$i]['user_id'];
            $challenge_id = $result[$i]['challenge_id'];
            $username = $this->user_model->get_username($user_id);
            $challenge_name = $this->get_challenge_name($challenge_id);
            $result[$i]['username'] = $username;
            $result[$i]['challenge_name'] = $challenge_name;
        }
        return $result;
    }

    /* 获取第 n 血 */
    public function get_number_blood($challenge_id, $number)
    {
        // TODO
    }
}