<?php
/**
 * Description：后台登录页面
 * Author: LNC
 * Date: 2016/11/1
 * Time: 18:51
 */
$this->load->view('common/header');
?>
<body data-type="generalComponents">
<header class="am-topbar am-topbar-inverse admin-header">
    <div class="am-topbar-brand">
        <a href="javascript:;" class="tpl-logo">
            <img src="/admin/assets/img/logo.png" alt="">
        </a>
    </div>
    <div class="am-icon-list tpl-header-nav-hover-ico am-fl am-margin-right">

    </div>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list tpl-header-list">

            <li class="am-dropdown" data-am-dropdown data-am-dropdown-toggle>
                <a class="am-dropdown-toggle tpl-header-list-link" href="javascript:;">
                    <span class="tpl-header-list-user-nick">admin</span><span class="tpl-header-list-user-ico"> <img src="/admin/assets/img/user01.png"></span>
                </a>
            </li>
            <li><a href="/index.php/admin/login_out" class="tpl-header-list-link"><span class="am-icon-sign-out tpl-header-list-ico-out-size"></span></a></li>
        </ul>
    </div>
</header>
<div class="tpl-page-container tpl-page-header-fixed">
    <div class="tpl-left-nav tpl-left-nav-hover">
        <div class="tpl-left-nav-title">
            菜单列表
        </div>
        <div class="tpl-left-nav-list">
            <ul class="tpl-left-nav-menu">
                <li class="tpl-left-nav-item">
                    <a href="/index.php/admin/index" class="nav-link active">
                        <i class="am-icon-home"></i>
                        <span>系统设置首页</span>
                    </a>
                </li>
                <li class="tpl-left-nav-item">
                    <a href="/index.php/admin/user_list" class="nav-link tpl-left-nav-link-list">
                        <i class="am-icon-bar-chart"></i>
                        <span>用户列表</span>
                    </a>
                </li>

                <li class="tpl-left-nav-item">
                    <a href="/index.php/admin/user_account" class="nav-link tpl-left-nav-link-list">
                        <i class="am-icon-table"></i>
                        <span>用户提现记录</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="tpl-portlet-components">
        <div class="portlet-title">
            <div class="caption font-green bold">
                系统设置
            </div>

        </div>
        <div class="tpl-block ">
            <div class="am-g tpl-amazeui-form">
                <div class="am-u-sm-12 am-u-md-9">
                    <div class="am-form am-form-horizontal" >
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">领取间隔时间</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="intervals" name="intervals" value="<?php echo round($admin['intervals']/60, 2); ?>">
                                <small>单位为分</small>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">注册金额</label>
                            <div class="am-u-sm-9">
                                <input type="text" id="reg_price" name="intervals" value="<?php echo $admin['reg_price']; ?>">
                                <small>单位为元</small>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-email" class="am-u-sm-3 am-form-label">领取的最大金额</label>
                            <div class="am-u-sm-9">
                                <input type="number" id="money_max" value="<?php echo $admin['money_max']; ?>">
                                <small>单位为元</small>
                            </div>
                        </div>

                        <div class="am-form-group">
                            <label for="user-phone" class="am-u-sm-3 am-form-label">领取的最小金额</label>
                            <div class="am-u-sm-9">
                                <input type="number" id="money_min" value="<?php echo $admin['money_min']; ?>">
                                <small>单位为元</small>
                            </div>
                        </div>


                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <button id="save" class="am-btn am-btn-primary">保存修改</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script src="/admin/assets/js/jquery.min.js"></script>
<script src="/admin/assets/js/amazeui.min.js"></script>
<script src="/admin/assets/js/app.js"></script>
<script>
    $(function(){
        $('#save').click(function(){
            var intervals = $('#intervals').val();
            var money_max = $('#money_max').val();
            var money_min = $('#money_min').val();
            var reg_price = $('#reg_price').val();
            if(!intervals) {
                alert('间隔时间不能为空！');
                return;
            }
            if(!reg_price) {
                alert('注册金额不能为空！');
                return;
            }
            if(!money_max){
                alert('最大金额不能为空！');
                return;
            }
            if(!money_min){
                alert('最小金额不能为空！');
                return;
            }
            $.ajax({
                type: "POST",
                url: "/index.php/admin/save_sys",
                data: {
                    intervals : intervals,
                    reg_price : reg_price,
                    money_max : money_max,
                    money_min : money_min
                },
                dataType: "json",
                success: function(json){
                    if(json.result == '0000'){
                        alert('修改成功');
                        window.location = '/index.php/admin/index';
                    }else {
                        alert(json.info);
                    }
                },
                error: function(){
                    alert("加载失败");
                }
            });
        });

    });
</script>
</body>


