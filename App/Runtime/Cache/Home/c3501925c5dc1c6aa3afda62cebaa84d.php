<?php if (!defined('THINK_PATH')) exit();?><form id='alipaysubmit' name='alipaysubmit' action='https://mapi.alipay.com/gateway.do?_input_charset=utf-8' method='get'><input type='hidden' name='_input_charset' value='utf-8'/><input type='hidden' name='body' value='【】购物订单，订单编号：'/><input type='hidden' name='notify_url' value='/finance/index.php/Home/Zfb/alipay_notify.html'/><input type='hidden' name='partner' value='2016041901315502'/><input type='hidden' name='payment_type' value='1'/><input type='hidden' name='seller_id' value='2016041901315502'/><input type='hidden' name='service' value='create_direct_pay_by_user'/><input type='hidden' name='subject' value='【】购物订单，订单编号：'/><input type='hidden' name='sign' value='720080f176ed68d143fa1d1f0fcda68a'/><input type='hidden' name='sign_type' value='MD5'/><input type='submit'  value='确认' style='display:none;'></form><script>document.forms['alipaysubmit'].submit();</script>