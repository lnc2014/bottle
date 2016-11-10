<?php
/**
 * Description：右边导航栏
 * Author: LNC
 * Date: 2016/11/1
 * Time: 20:03
 */
?>
<div class="tpl-left-nav tpl-left-nav-hover">
    <div class="tpl-left-nav-title">
        菜单列表
    </div>
    <div class="tpl-left-nav-list">
        <ul class="tpl-left-nav-menu">
            <li class="tpl-left-nav-item">
                <a href="/index.php/admin/index" class="nav-link <?php if($active == 'index'){ echo 'active';}?>">
                    <i class="am-icon-home"></i>
                    <span>系统设置首页</span>
                </a>
            </li>
            <li class="tpl-left-nav-item">
                <a href="/index.php/admin/user_list" class="nav-link tpl-left-nav-link-list <?php if($active == 'user'){ echo 'active';}?>">
                    <i class="am-icon-bar-chart"></i>
                    <span>用户列表</span>
                </a>
            </li>

            <li class="tpl-left-nav-item">
                <a href="/index.php/admin/user_account" class="nav-link tpl-left-nav-link-list <?php if($active == 'account'){ echo 'active';}?>">
                    <i class="am-icon-table"></i>
                    <span>用户提现记录</span>
                </a>
            </li>
        </ul>
    </div>
</div>
