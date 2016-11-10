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
    <?php $this->load->view('common/left');?>
    <div class="tpl-content-wrapper">
        <div class="tpl-portlet-components">
            <div class="portlet-title">
                <div class="caption font-green bold">
                    用户提现页面
                </div>
            </div>
            <div class="tpl-block">
                <div class="am-g">
                    <div class="am-u-sm-12">
                            <table class="am-table am-table-striped am-table-hover table-main">
                                <thead>
                                <tr>
                                    <th class="table-title">用户ID</th>
                                    <th class="table-title">用户提现金额</th>
                                    <th class="table-type">用户提现时间</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach($user_account as $value){ ?>
                                        <tr>
                                            <td><?php echo $value['user_id']; ?></td>
                                            <td><?php echo $value['price']; ?></td>
                                            <td class="am-hide-sm-only"><?php echo $value['get_time']; ?></td>
                                        </tr>
                                 <?php }
                                ?>

                                </tbody>
                            </table>
                            <hr>
                    </div>

                </div>
            </div>
            <div class="tpl-alert"></div>
        </div>

    </div>
</div>
<script src="/admin/assets/js/jquery.min.js"></script>
<script src="/admin/assets/js/amazeui.min.js"></script>
<script src="/admin/assets/js/app.js"></script>
</body>


