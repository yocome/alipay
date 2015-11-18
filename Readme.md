# 支付宝SDK

## [官方文档](http://doc.open.alipay.com/doc2/alipayDocIndex.htm)
 1. [手机网站支付](http://doc.open.alipay.com/doc2/detail?treeId=60&articleId=103564&docType=1)


## Requirements
   1. PHP 5.4 或以上
   2. 系统安装 CURL, OpenSSL
      `yum install curl curl-devel openssl openssl-devel`

## Installtion
  `composer require yocome/alipay`

## Description
代码是下载官方的SDK，做了简单整理。目前只用到手机网站支付，其它以后慢慢整进来：）

## Usage

```
$config = [
    'partner' => '2088208820882088',                        //合作身份者id，以2088开头的16位纯数字
    'seller_id' => '2088208820882088',                      //收款支付宝账号，一般情况下收款账号就是签约账号
    'private_key_path' => 'key/rsa_private_key.pem',        //商户的私钥（后缀是.pen）文件相对路径
    'ali_public_key_path' => 'key/alipay_public_key.pem',   //支付宝公钥（后缀是.pen）文件相对路径
    'cacert' => 'key/cacert.pem',                           //ca证书路径地址，用于curl中ssl校验
    ];

$parameter = [
    "notify_url"	=> 'http://商户网关地址/notify_url.php',  //服务器异步通知页面路径
    "return_url"	=> 'http://商户网关地址/return_url.php',  //页面跳转同步通知页面路径
    "out_trade_no"	=> 20151118012346,                      //商户订单号
    "subject"	=> 'iPhone 6s 64G',                         //订单名称
    "total_fee"	=> '0.01',                                  //付款金额
    "show_url"	=> 'http://www.商户网址.com/myorder.html',    //商品展示地址
    ];


$pay = new \Yocome\Alipay\AlipayApi($config);

//设置订单参数
$pay->setParameter($parameter);

//创建支付请求
echo $pay->createRequest();
```

## License
MIT License

## Contact
yocome@gmail.com