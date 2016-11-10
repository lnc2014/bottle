<?php
/**
 * Description：个人中心的页面
 * Author: LNC
 * Date: 2016/11/1
 * Time: 22:03
 */
$this->load->view('common/wx_header');
?>
<style>
    .head_img img{ border-radius:50%}
    .user_name{
        float: left;
        position: relative;
        padding-top: -25px;
        z-index: 99;
        margin-top: -86px;
        margin-left: 100px;
        font-size: 16px;
    }
    .user_money{
        float: left;
        position: relative;
        padding-top: -25px;
        z-index: 99;
        margin-top: -50px;
        margin-left: 100px;
        font-size: 14px;
        color: #a4a1a7;
    }
</style>
<div class="container" id="container" style="background:url(/static/images/back.jpeg); background-size:100%;">
    <div class="repair_info" >
        <div class="head_img">
            <img src="<?php
            if(!empty($user['head_img'])){
                echo $user['head_img'];
            }else{
                echo '/admin/assets/img/head.jpeg';
            } ?>"  style="margin-top: 20px;width: 80px">
        </div>
        <div class="user_name">
            <?php echo $user['user_name']; ?>
        </div>
        <div class="user_money">
            可提现：<?php echo $user['get_all_money']; ?>
        </div>
    </div>
    <div class="weui_cells weui_cells_access">
        <a class="weui_cell" href="javascript:;" style="color: red">
            <div class="weui_cell_hd"><img src="/admin/assets/img/exchange.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
            <div class="weui_cell_bd weui_cell_primary">
                <p>可提现：<?php echo $user['get_all_money']; ?></p>
            </div>
        </a>
        <?php
        foreach($can_withdraw as $value){ ?>
            <a class="weui_cell" href="javascript:;">
                <div class="weui_cell_hd"><img src="/admin/assets/img/Money.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <p>申请提现<?php echo $value['price']; ?></p>
                </div>
            </a>
        <?php }
        ?>
    </div>
    <div class="weui_cells weui_cells_access">
        <a class="weui_cell" href="/index.php/wx/qcode">
            <div class="weui_cell_hd"><img src="/admin/assets/img/Bar_Code.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
            <div class="weui_cell_bd weui_cell_primary">
                <p>推广二维码</p>
            </div>
        </a>
    </div>
    <div class="weui_cells weui_cells_access">
        <a class="weui_cell" href="javascript:;">
            <div class="weui_cell_hd"><img src="/admin/assets/img/Bar_Code.png" alt="" style="width:20px;margin-right:5px;display:block"></div>
            <div class="weui_cell_bd weui_cell_primary">
                <p>产品说明</p>
            </div>
        </a>
    </div>
    <div class="weui_tabbar">
        <a href="/index.php/wx/get_money" class="weui_tabbar_item">
            <div class="weui_tabbar_icon">
                <img src="/static/images/icon_nav_article.png" alt="">
            </div>
            <p class="weui_tabbar_label">获取金钱</p>
        </a>
        <a href="/index.php/wx/my_account" class="weui_tabbar_item">
            <div class="weui_tabbar_icon">
                <img src="/static/images/icon_nav_cell.png" alt="">
            </div>
            <p class="weui_tabbar_label">个人中心</p>
        </a>
    </div>
</div>
<script src="/admin/assets/js/jquery.min.js"></script>
</body>


