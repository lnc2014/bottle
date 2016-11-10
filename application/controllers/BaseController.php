<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *  基础类
 */
class BaseController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		header("Content-type:text/html;charset=utf-8");
		session_start();
		date_default_timezone_set('PRC'); //设置中国时区
		$this->config->load('common/config_response', TRUE); //统一返回状态码loading
		$this->load->helper('url');
		$this->response_msg = $this->config->item('response', 'common/config_response');
	}

	/**
	 * 接口api统一结果处理
	 * @param $result
	 * @param $data
	 * @param $info
	 * @return string
	 */
	public function apiReturn($result, $data, $info)
	{
		$arr["result"] = $result;
		$arr["data"] = $data === null ? '' : $data;
		$arr["info"] = $info;
		$res = json_encode($arr);
		return $res;
	}

	/**
	 * 检测是不是已经登录
	 */
	public function check_login(){
		//检测用户是否已经登录授权过
		if(isset($_SESSION['user_name'])){
			return true;
		}
		return false;
	}
}
