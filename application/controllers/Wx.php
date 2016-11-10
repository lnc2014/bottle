<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once "BaseController.php";
class Wx extends BaseController {
	private $data;

	//微信登录首页
	public function index()
	{
		$this->check_user();
		if($_SESSION['flag'] == 1){//已经激活的直接跳转领取页面
			redirect('wx/get_money');
		}elseif($_SESSION['flag'] == 2){//跳转到支付页面
			redirect('wx/pay_reg');
		}

	}

	/**
	 * 注册支付金钱
	 */
	public function pay_reg(){
		$this->check_user();
		$this->load->model('M_bot_system');
		$admin = $this->M_bot_system->get_one(array('flag' => 1));
		if(empty($admin)){
			echo '<script>alert("非法请求");history.go(-1);</script>';
			return;
		}
		$attach = '';//附加数据，支付用户ID和订单编号和司机id
		$pay_all_money = $admin['reg_price'];
		$order_no = $_SESSION['order_no'];
		$total_fee = empty($pay_all_money) ? 1 : $pay_all_money;
		$openid = $_SESSION['jspayOpenId'];
		include_once(FCPATH . 'public/user-pay/lib/WxPayException.php');
		include_once(FCPATH . 'public/user-pay/lib/WxPayApi.php');
		include_once(FCPATH . 'public/user-pay/lib/WxPayConfig.production.php');
		include_once(FCPATH . 'public/user-pay/lib/WxPayJsApiPay.class.php');
		include_once(FCPATH . 'public/user-pay/lib/WxPayData.php');
		$tools = new JsApiPay();
		$input = new WxPayUnifiedOrder();
		$input->SetBody('注册费用');
		$input->SetAttach($attach);
		$input->SetOut_trade_no($order_no);    //订单号
		$input->SetTotal_fee($total_fee * 100);   //总费用
//        $input->SetTotal_fee($total_fee);   //总费用
		$input->SetTime_start(date("YmdHis"));
		//$input->SetTime_expire(date("YmdHis", time() + 1200));
		$input->SetNotify_url(WxPayConfig::NOTIFY_URL);   //支付回调地址，这里改成你自己的回调地址。
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($openid);
		$order = WxPayApi::unifiedOrder($input);
		$jsApiParameters = $tools->GetJsApiParameters($order);
		$this->data['jsApiParameters'] = $jsApiParameters;
		$this->data['title'] = '注册';
		$this->data['url'] = 'http://'.$_SERVER['HTTP_HOST'].'/index.php/wx/get_money';
		$this->load->view('reg_pay', $this->data);
	}
	//微信支付回调
	public function notify(){
		$wx_order_str =  $this->input->post("wx_order_str");
		$order_no =  $this->input->post("order_no");
		$real_pay =  $this->input->post("total_fee");
		$real_pay =  round($real_pay/100, 2);//微信回调是以分为单位
		$log_data['post_data'] = $_POST;
		if($real_pay < 0 || empty($order_num) || empty($wx_order_str)){//日志记录
			return;
		}
		$this->load->model('M_bot_user');
		$user = $this->M_bot_user->get_one(array('order_no' => $order_no));
		if(!empty($user)){
			$this->load->model('M_bot_system');
			$admin = $this->M_bot_system->get_one(array('flag' => 1));
			if($admin['reg_price'] == $real_pay){ //支付等价商品
				$this->M_bot_user->update(array('flag' => 1), array('order_no' => $order_no));
			}
		}
	}
	/**
	 * 获取金钱的页面
	 */
	public function get_money(){
		$this->check_user();
		$this->data['title'] = '领取金钱页面';
		//计算前台的倒计时功能
		$this->load->model('M_bot_system');
		$this->load->model('M_bot_account_log');
		$admin = $this->M_bot_system->get_one(array('flag' => 1));
		$user_get_money = $this->M_bot_account_log->get_one(array('is_withdraw' => 0), '*', 'get_time DESC');//获取用户最新领取的一条记录
		$this->data['left_time'] = 0;//前台倒计时时间
		$this->data['is_can_get'] = 1;//1为可以领取0为不可以领取
		if(!empty($user_get_money)){
			$have_get_time = bcsub(time(), strtotime($user_get_money['get_time']), 2);
			if($have_get_time > 0){
				$left_time = bcsub($admin['intervals'], $have_get_time);//前台倒计时时间
				if($left_time > 0){
					$this->data['left_time'] = $left_time;//前台倒计时时间,精确到秒
					$this->data['is_can_get'] = 0;//可以领取
				}
			}
		}
		$this->load->view('get_money', $this->data);
	}
	/**
	 * 个人中心
	 */
	public function my_account(){
		$this->check_user();
		$this->data['title'] = '领取金钱页面';
		$this->load->model('M_bot_user');
		$user = $this->M_bot_user->get_one(array('user_id' => $_SESSION['user_id']));
		if(empty($user) || ($user['open_id'] != $_SESSION['jspayOpenId']) || ($user['flag'] != 1)){
			echo '<script>alert("用户信息不正确或者用户尚未激活");history.go(-1);</script>';
			exit();
		}
		$this->data['user'] = $user;
		$this->load->model('M_bot_account_log');
		$this->data['can_withdraw'] = $this->M_bot_account_log->get_list(array('is_withdraw' => 0));
		$this->load->view('my_account', $this->data);
	}
	//领取金钱的动作
	public function get_money_again(){
		$this->check_user();
		$this->data['title'] = '领取金钱页面';
		//增加一个安全机制：
		/**
		 * 1、身份校验
		 * 2、时间校验
		 * 3、领取金额校验
		 */
		$this->load->model('M_bot_user');
		$user = $this->M_bot_user->get_one(array('user_id' => $_SESSION['user_id']));
		if(empty($user) || ($user['open_id'] != $_SESSION['jspayOpenId']) || ($user['flag'] != 1)){
			echo '<script>alert("用户信息不正确或者用户尚未激活");history.go(-1);</script>';
			exit();
		}

		$this->load->model('M_bot_system');
		$this->load->model('M_bot_account_log');
		$admin = $this->M_bot_system->get_one(array('flag' => 1));
		$user_get_money = $this->M_bot_account_log->get_one(array('is_withdraw' => 0), '*', 'get_time DESC');//获取用户最新领取的一条记录
		if(!empty($user_get_money)){
			$have_get_time = bcsub(time(), strtotime($user_get_money['get_time']), 2);
			if($have_get_time > 0){
				$left_time = bcsub($admin['intervals'], $have_get_time);//前台倒计时时间
				if($left_time > 0){
					echo '<script>alert("尚未到领取时间，请稍后试");history.go(-1);</script>';
					exit();
				}
			}
		}
		//领取金额
		$get_money = $this->randFloat($admin['money_min'], $admin['money_max']);
		if($get_money > $admin['money_max']){
			$get_money = $admin['money_min'];
		}
		$user_money_data['price'] = $get_money;
		$user_money_data['get_time'] = date('Y-m-d H:i:s', time());
		$user_money_data['is_withdraw'] = 0;
		$user_money_data['user_id'] = $_SESSION['user_id'];
		$account_log_id = $this->M_bot_account_log->add($user_money_data);
		if($account_log_id > 0){
			$user_money = bcadd($user['get_all_money'], $get_money, 2);
			$this->M_bot_user->update(array('get_all_money' => $user_money), array('user_id' => $_SESSION['user_id']));
			echo '<script>alert("恭喜你，成功领取'.$get_money.'元");history.go(-1);</script>';
			exit();
		}else{
			echo '<script>alert("领取失败，请联系客服");history.go(-1);</script>';
			exit();
		}
	}

	/**
	 * 获取随机小数
	 * @param int $min
	 * @param int $max
	 * @return int
	 */
	public function randFloat($min = 0, $max = 1){
		return round($min + mt_rand()/mt_getrandmax() * ($max-$min), 2);
	}
	/**
	 * 用户登录校验
	 * @return bool
	 */
	public function check_user()
	{
		//检测用户是否已经登录授权过
		if(isset($_SESSION['user_id']) && isset($_SESSION['jspayOpenId']) && isset($_SESSION['flag'])){
			return true;
		}
		$this->load->model('M_bot_user');
		$data = $this->get_user_openid();//用户无登录入口，必须微信自动登录
		$user = $this->M_bot_user->get_one(array('open_id' => $data['openid']), 'user_id');

		if(!empty($user)){
			$_SESSION['user_id'] = $user['user_id'];
			$_SESSION['flag'] = $user['flag'];
			$_SESSION['jspayOpenId'] = $data['openid'];
			$_SESSION['order_no'] = $user['order_no'];
			return true;
		}else{
			$user_info = $this->get_user_info_by_snsapi($data['openid'], $data['access_token']);
			$data = array(
					'open_id' => $data['openid'],
					'user_name' => empty($user_info['nick_name'])?'':$user_info['nick_name'],
					'head_img' => empty($user_info['head_url'])?'':$user_info['head_url'],
					'create_time' => time(),
					'order_no' => 'Bottle'.date('YmdHis', time()).rand(1000,9999),
					'flag' => 2,//未激活
			);
			$user_id = $this->M_bot_user->add($data);
			if($user_id > 0 ){
				$_SESSION['user_id'] = $user_id;
				$_SESSION['jspayOpenId'] = $data['openid'];
				$_SESSION['flag'] = 2;
				$_SESSION['order_no'] = $data['order_no'];
				return true;
			}else{
				return false;
			}
		}
	}
	/**
	 * 获取微信用户openid
	 * @return string
	 */
	public function get_user_openid(){
		include_once(FCPATH . "public/user-pay/WxOpenIdHelper.php");
		$wxopenidhelper = new WxOpenIdHelper();
		$data = $wxopenidhelper->getOpenId();
		$_SESSION['jspayOpenId'] = $data['openid'];
		return $data;
	}
	/**
	 * 获取用户的头像
	 * @param $open_id
	 * @param $token
	 * @return mixed
	 */
	public function get_user_info_by_snsapi($open_id, $token){
		$url="https://api.weixin.qq.com/sns/userinfo?access_token=$token&openid=$open_id&lang=zh_CN";
		$result=  file_get_contents($url);

		$result=  explode(",", $result);
		$nick_name=  explode(":",$result[1]);
		$head_url=  explode(":", $result[7]);
		$data["nick_name"]= str_replace('"',"",$nick_name[1]);
		$data["head_url"]=$head_url[1].":".$head_url[2];
		$data['head_url'] = str_replace('"',"",$data['head_url']);
		$data['head_url'] = stripslashes($data['head_url']);
		return $data;
	}

	/**
	 * 推广二维码
	 */
	public function qcode(){
		$this->check_user();
		$this->load->model('M_bot_user');
		$user = $this->M_bot_user->get_one(array('user_id' => $_SESSION['user_id']));
		$this->data['title'] = '推广二维码';
		$url = 'http://'.$_SERVER['HTTP_HOST'].'/index.php/wx/promote_user/'.$user['promote_alias'];
		$this->data['img_url'] =  "http://pan.baidu.com/share/qrcode?w=300&h=300&url=".$url;
		$this->load->view('my_qrcode', $this->data);
	}
}
