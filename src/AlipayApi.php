<?php
/**
 * HomePage: https://github.com/yocome
 * Modifier by Yong
 * Date: 2015/11/17
 * Time: 20:04
 */

namespace Yocome\Alipay;


class AlipayApi
{
    //签名方式 不需修改
    public $signType = 'RSA';

    //字符编码格式 目前支持 gbk 或 utf-8
    public $inputCharset = 'utf-8';

    //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
    protected $_transport = 'http';

    //支付类型
    protected $paymentType = "1";
    //必填，不能修改


    //商户配置信息
    protected $_config = [];

    //参数数组
    protected $_parameter = [];


    /**
     * AlipayApi constructor.
     * @param array $args
     *
     * <code>
     *  $args = [
     *      'partner'=>'123456',                                    //必填，合作身份者id，以2088开头的16位纯数字
     *      'seller_id'=>'123456',                                  //必填，收款支付宝账号，一般情况下收款账号就是签约账号
     *      'private_key_path'=>'alipay/rsa_private_key.pem',       //必填，商户的私钥（后缀是.pen）文件相对路径，
     *      'ali_public_key_path'=>'alipay/alipay_public_key.pem',  //必填，支付宝公钥（后缀是.pen）文件相对路径
     *      'cacert'=>'alipay/cacert.pem',                          //必填,ca证书路径地址，用于curl中ssl校验
     *      'sign_type=>'RSA'，                                     //选填，签名方式 不需修改
     *      'input_charset'=>'utf-8',                               //选填，字符编码格式 目前支持 gbk 或 utf-8
     *      'transport'=>'http'                                     //选填，访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
     *  ];
     * </code>
     *
     *
     */
    public function __construct(array $args)
    {

        $this->_config = [
            'partner' => trim($args['partner']),
            'seller_id' => trim($args['seller_id']),
            'private_key_path' => $args['private_key_path'],
            'ali_public_key_path' => $args['ali_public_key_path'],
            'cacert' => $args['cacert'],
            'sign_type' => isset($args['sign_type'])?strtoupper($args['sign_type']):$this->signType,
            'input_charset' => isset($args['input_charset'])?trim(strtolower($args['input_charset'])):$this->inputCharset,
            'transport' =>isset($args['transport'])?strtolower($args['transport']):$this->_transport
        ];

    }

    /**
     * @param array $args
     *  * <code>
     *  $args = [
     *      'notify_url'=>'服务器异步通知页面路径',    //必填，需http://格式的完整路径，不能加?id=123这类自定义参数
     *      'return_url'=>'页面跳转同步通知页面路径',  //必填，需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
     *      'out_trade_no'=>123,                    //必填，商户订单号，商户网站订单系统中唯一订单号，
     *      'subject'=>'订单名称',                   //必填
     *      'total_fee'=>100,                       //必填,付款金额
     *      'show_url=>'商品展示地址'，               //必填，需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
     *      'body'=>'订单描述',                      //选填
     *      'timeout'=>60,                          //选填，超时时间
     *      'extern_token'=>'abcdefg'               //选填，钱包token
     *  ];
     * </code>
     *
     */
    public function setParameter(array $args)
    {
        $this->_parameter = [
            "service" => "alipay.wap.create.direct.pay.by.user",
            "partner" => $this->_config['partner'],
            "seller_id" => $this->_config['seller_id'],
            "payment_type"	=> $this->paymentType,
            "notify_url"	=> $args['notify_url'],
            "return_url"	=> $args['return_url'],
            "out_trade_no"	=> $args['out_trade_no'],
            "subject"	=> $args['subject'],
            "total_fee"	=> $args['total_fee'],
            "show_url"	=> $args['show_url'],
            "_input_charset"	=> $this->_config['input_charset']
        ];

        if(isset($args['body']))
            $this->_parameter['body'] = $args['body'];

        if(isset($args['timeout']))
            $this->_parameter['it_b_pay'] = $args['timeout'];

        if(isset($args['extern_token']))
            $this->_parameter['extern_token'] = $args['extern_token'];
    }

    /**
     * 建立支付请求表单
     * @param string $method
     * @param string $button_name
     * @return 提交表单HTML文本
     */
    public function createRequest($method='get', $button_name='确认')
    {
        $alipay = new Submit($this->_config);

        return  $alipay->buildRequestForm($this->_parameter, $method, $button_name);
    }

}