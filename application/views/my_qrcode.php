<?php
/**
 * Description：个人中心的页面
 * Author: LNC
 * Date: 2016/11/1
 * Time: 22:03
 */
$this->load->view('common/wx_header');
?>

<div class="container" id="container" style="background:url(/static/images/back.jpeg); background-size:100%;">
        <div class="hd">
            <h1 class="page_title">推广二维码</h1>
        </div>
    <div class="hd" style="text-align:center">
        <img src="<?php echo $img_url; ?>" >
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


