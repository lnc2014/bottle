<?php
/**
 * Description：后台登录页面
 * Author: LNC
 * Date: 2016/11/1
 * Time: 18:51
 */
$this->load->view('common/header');
?>

<body data-type="login">

<div class="am-g myapp-login">
    <div class="myapp-login-logo-block  tpl-login-max">
        <div class="myapp-login-logo-text">
            <div class="myapp-login-logo-text">
               后台登录<span> Login</span> <i class="am-icon-skyatlas"></i>

            </div>
        </div>
        <div class="am-u-sm-10 login-am-center">
            <div class="am-form">
                <fieldset>
                    <div class="am-form-group">
                        <input type="text" class="username" id="doc-ipt-email-1" placeholder="请输入账户">
                    </div>
                    <div class="am-form-group">
                        <input type="password" class="psw" id="doc-ipt-pwd-1" placeholder="请输入密码">
                    </div>
                    <p><button type="submit" id="login" class="am-btn am-btn-default">登录</button></p>
                </fieldset>
            </div>
        </div>
    </div>
</div>

<script src="/admin/assets/js/jquery.min.js"></script>
<script src="/admin/assets/js/amazeui.min.js"></script>
<script src="/admin/assets/js/app.js"></script>
<script>
    $(function(){
        $('#login').click(function(){
            var username = $('.username').val();
            var password = $('.psw').val();
            if(!username) {
                alert('账号不能为空！');
                return;
            }
            if(!password){
                alert('密码不能为空！');
                return;
            }
            $.ajax({
                type: "POST",
                url: "/index.php/admin/login_check",
                data: {
                    username : username,
                    psw : password
                },
                dataType: "json",
                success: function(json){
                    if(json.result == '0000'){
                        alert('登录成功');
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

</html>
