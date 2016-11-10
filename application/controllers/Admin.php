<?php
/**
 * Description : 系统后台的控制器
 * Author: LNC
 * Date: 2016/11/1
 * Time: 18:44
 */
include_once "BaseController.php";
class Admin extends BaseController{
    private $data;
    public function __construct()
    {
        parent::__construct();
    }
    //后台首页
    public function index(){
        if(!$this->check_login()){
            redirect('admin/login');
        }
        $this->load->model('M_bot_system');
        $this->data['admin'] = $this->M_bot_system->get_one(array('flag' => 1));
        $this->data['title'] = '后台首页';
        $this->data['active'] = 'index';
        $this->load->view('admin_index', $this->data);
    }
    //登录
    public function login(){
        if($this->check_login()){
            redirect('admin/index');
        }
        $this->data['title'] = '登录';
        $this->load->view('login', $this->data);
    }
    //登录校验
    public function login_check(){
        $username = $this->input->post('username');
        $psw = $this->input->post('psw');
        if(empty($username) || empty($psw)){
            echo $this->apiReturn("0003", new stdClass(), $this->response_msg["0003"]);
            return;
        }
        $psw = md5($psw);//使用md5加密
        $this->load->model('M_bot_admin');
        $admin = $this->M_bot_admin->get_one(array('user_name' => $username, 'psw' => $psw));
        if(empty($admin)){
            echo $this->apiReturn('0010', new stdClass(), $this->response_msg["0010"]);
            return;
        }
        //登录成功将id存入session
        $_SESSION['user_name'] = $admin['user_name'];
        echo $this->apiReturn('0000', new stdClass(), $this->response_msg["0000"]);
        return;
    }
    public function edit_sys(){
        if(!$this->check_login()){
            redirect('admin/login');
        }
        $this->data['active'] = 'index';
        $this->load->model('M_bot_system');
        $this->data['admin'] = $this->M_bot_system->get_one(array('flag' => 1));
        $this->data['title'] = '修改系统配置';
        $this->load->view('edit_sys', $this->data);
    }
    public function save_sys(){
        if(!$this->check_login()){
            redirect('admin/login');
        }
        $post = $this->input->post();
        if(empty($post)){
            echo $this->apiReturn("0003", new stdClass(), $this->response_msg["0003"]);
            return;
        }
        $post['intervals'] = $post['intervals'] * 60;
        $this->load->model('M_bot_system');
        $update = $this->M_bot_system->update($post, array('flag' => 1));
        if($update){
            echo $this->apiReturn('0000', new stdClass(), $this->response_msg["0000"]);
            return;
        }else{
            echo $this->apiReturn('0002', new stdClass(), $this->response_msg["0002"]);
            return;
        }
    }
    //用户列表
    public function user_list(){
        if(!$this->check_login()){
            redirect('admin/login');
        }
        $this->load->model('M_bot_user');
        $this->data['user_list'] = $this->M_bot_user->get_list();
        $this->data['title'] = '用户列表';
        $this->data['active'] = 'user';
        $this->load->view('user_list', $this->data);
    }
    //用户提现记录
    public function user_account($user_id = ''){
        if(!$this->check_login()){
            redirect('admin/login');
        }
        $this->load->model('M_bot_account_log');
        $this->data['user_account'] = $this->M_bot_account_log->get_list(array('type' => 1));
        if(!empty($user_id)){
            $this->data['user_account'] = $this->M_bot_account_log->get_list(array('user_id' => $user_id, 'type' => 1));
        }
        $this->data['title'] = '用户领取记录';
        $this->data['active'] = 'account';
        $this->load->view('user_account', $this->data);
    }
    /**
     * 退出登录
     */
    public function login_out(){
        if(session_destroy()){
            redirect('admin/login');
        }
    }
}