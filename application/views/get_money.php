<?php
/**
 * Description：收取金钱的页面
 * Author: LNC
 * Date: 2016/11/1
 * Time: 22:03
 */
$this->load->view('common/wx_header');
?>
<style type="text/css">
    .time-item strong{background:#C71C60;color:#fff;line-height:49px;font-size:36px;font-family:Arial;padding:0 10px;margin-right:10px;border-radius:5px;box-shadow:1px 1px 3px rgba(0,0,0,0.2);}
    #day_show{float:left;line-height:49px;color:#c71c60;font-size:32px;margin:0 10px;font-family:Arial, Helvetica, sans-serif;}
    .item-title .unit{background:none;line-height:49px;font-size:24px;padding:0 10px;float:left;}
</style>
<div class="container" id="container">
    <div class="tabbar">
        <div class="weui_tab">
            <div class="weui_tab_bd" style="background:url(/static/images/back.jpeg); background-size:100%;">
                <?php
                if($is_can_get != 1){ ?>
                <div class="bd" style="margin-top: 80px;">
                    <div class="weui_cells_title" style="font-size: 16px;color: black;">你还剩</div>
                    <div class="weui_cell">
                        <div class="time-item" style="margin-left: auto;margin-right: auto;">
                            <strong id="minute_show">0分</strong>
                            <strong id="second_show">0秒</strong>
                        </div><!--倒计时模块-->
                    </div>
                    <div class="weui_cells_title" style="float: right;font-size: 16px;color: black;">领取大奖</div>
                </div>
                <?php }
                ?>
                <?php
                if($is_can_get == 1){ ?>
                    <div style="margin-top: 100%;width: 40%;margin-left: 30%;">
                        <a href="/index.php/wx/get_money_again" class="weui_btn weui_btn_warn">领取</a>
                    </div>
                <?php }
                ?>
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
    </div>
</div>
<script src="/admin/assets/js/jquery.min.js"></script>
<!--倒计时模块-->
<script type="text/javascript">
    var intDiff = parseInt(<?php echo $left_time; ?>);//倒计时总秒数量
    var is_can_get = <?php echo $is_can_get; ?>;//倒计时总秒数量
    function timer(intDiff){
        window.setInterval(function(){
            var day=0,
                hour=0,
                minute=0,
                second=0;//时间默认值
            if(intDiff > 0){
                day = Math.floor(intDiff / (60 * 60 * 24));
                hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
            }
            if (minute <= 9) minute = '0' + minute;
            if (second <= 9) second = '0' + second;
            $('#day_show').html(day+"天");
            $('#hour_show').html('<s id="h"></s>'+hour+'时');
            $('#minute_show').html('<s></s>'+minute+'分');
            $('#second_show').html('<s></s>'+second+'秒');
            intDiff--;
            if(intDiff < 0){
                clearInterval(intDiff);
                location.reload();
            }
        }, 1000);
    }
    $(function(){
        if(is_can_get != 1){
            timer(intDiff);
        }
    });
</script>
</body>
</html>
