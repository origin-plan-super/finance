<?php if (!defined('THINK_PATH')) exit();?><form id='alipaysubmit' name='alipaysubmit' action='https://mapi.alipay.com/gateway.do?_input_charset=utf-8' method='get'><input type='hidden' name='_input_charset' value='utf-8'/><input type='hidden' name='body' value='http://120.78.162.200:12138/finance/Home/zfb/notify'/><input type='hidden' name='notify_url' value='/finance/index.php/Home/Zfb/alipay_notify.html'/><input type='hidden' name='out_trade_no' value='9143'/><input type='hidden' name='partner' value='2088811669460032'/><input type='hidden' name='payment_type' value='1'/><input type='hidden' name='seller_id' value='2088811669460032'/><input type='hidden' name='service' value='create_direct_pay_by_user'/><input type='hidden' name='subject' value='【财金通】购物订单，订单编号：9143'/><input type='hidden' name='total_fee' value='0.01'/><input type='hidden' name='sign' value='ba4e66232a5e7b44f0b00d6e9924b2b2'/><input type='hidden' name='sign_type' value='MD5'/><input type='submit'  value='确认' style='display:none;'></form><script>document.forms['alipaysubmit'].submit();</script>