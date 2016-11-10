<?php
/**
 * Description：支付注册页面
 * Author: LNC
 * Date: 2016/11/1
 * Time: 21:47
 */
?>
<script src="/admin/assets/js/jquery.min.js" type="text/javascript"> </script>
<script type="text/javascript">

    $(function(){
        callpay(<?php echo $jsApiParameters;?>);
    });
    //调用微信JS api 支付
    function jsApiCall(jsApiParameters)
    {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest',
            jsApiParameters,
            function(res){
                if (res.err_msg == 'get_brand_wcpay_request:ok') {
                    location.href = <?php echo $url; ?>;
                } else if (res.err_msg == 'get_brand_wcpay_request:cancel') {
                    alert('您已取消支付，支付失败！');
                } else if (res.err_msg == 'get_brand_wcpay_request:fail') {
                    alert('支付失败！');
                } else {
                    alert(res.err_code+res.err_desc+res.err_msg);
                }
                return;
            }
        );
    }

    function callpay(jsApiParameters)
    {
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        }else{
            jsApiCall(jsApiParameters);
        }
    }
</script>