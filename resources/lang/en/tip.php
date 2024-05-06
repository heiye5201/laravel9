<?php

// english

return [
    'error'                             =>  'operation failed.',
    'success'                           =>  'Operation successful.',
    'failed'                            =>  'Abnormal error.',
    'loginOk'                           =>  'Login successful.',
    'loginErr'                          =>  'Login failed.',
    'loginThr'                          =>  'Login exception.',
    'loginOut'                          =>  'Logout successful.',
    'loginInv'                          =>  'Invalid account.',
    'pmsThr'                            =>  'Permission exception.',
    'pwdErr'                            =>  'Password error.',
    'userThr'                           =>  'Account number exception.',
    'oauthThr'                          =>  'OAuth exception.',
    'configThr'                         =>  'Abnormal configuration information.',
    'phoneThr'                          =>  'Wrong mobile number.',
    'userExist'                         =>  'Wrong mobile number.',
    'phoneExist'                        =>  'Mobile number already exists.',

    // 订单状态
    'orderCancel'                                  =>   'Order cancellation',
    'waitPay'                                      =>   'Waiting for payment',
    'waitSend'                                     =>   'Waiting for shipment',
    'waitRec'                                      =>   'Waiting for receipt',
    'orderConfirm'                                 =>   'Waiting for receipt ', // confirm receipt
    'waitComment'                                  =>   'Waiting for comment',
    'orderRefund'                                  =>   'After sales refund',
    'orderReturned'                                =>   'After sales return',
    'orderRefundOver'                              =>   'After sales completion',
    'orderCompletion'                              =>   'Order completion',


    'waitStatus'                                   =>    'To be reviewed',
    'applyStatusSuccess'                           =>    'Approved',
    'applyStatusCancel'                            =>    'Refuse to pass',
    'orderCanApplyStatus'                          =>    'Sorry, the data you selected contains approved orders',

    'this_order_cancel'                            =>    'Sorry, the order you selected has been cancelled！',
    'this_order_wait_pay'                          =>    'Sorry, the order you selected has not been paid yet！',

    'systemHandleMoney'                            =>   'System processing',

    // Payment type
    'paymentWechat'                                =>   'Wechat payment',
    'paymentAli'                                   =>   'Alipay payment',
    'paymentMoney'                                 =>   'Balance payment',


    // Some Chinese of permission
    'permission' => [
        'view'      =>  'see',
        'store'     =>  'add to',
        'update'    =>  'edit',
        'destroy'   =>  'delete',
        'index'     =>  'list',
    ],

    // Uploaded error messages
    'upload' => [
        'fileNotFound'  =>  'Upload file not found.',
        'invalidFile'   =>  'Invalid file upload.',
        'notAllow'      =>  'File type cannot be uploaded.',
        'uploadThr'     =>  'Upload exception.',
    ],

    // SMS related SMS
    'sms' => [
        'phoneError'    =>  'Incorrect mobile phone number.',
        'signEmpty'     =>  'Signature does not exist.',
        'sendErr'       =>  'Sending SMS failed.',
        'smsErr'        =>  'Verification code error.',
        'smsInvalid'    =>  'Verification code failure.',
        'reSend'        =>  'Please do not send frequently.',
        'phoneExists'   =>  'Mobile number already exists.',
        'phoneNoExists' =>  'Mobile number does not exist.',
    ],

    // Payment related
    'payment' => [
        'orderErr'          =>  'Order information error.',
        'onlineRecharge'    =>  'Online recharge',
        'orderPay'          =>  'Order payment',
        'paymentFailed'     =>  'Failed to retrieve payment.',
    ],

    // Store related
    'store' => [
        'defined'       =>  'Store already exists.',
        'notMall'       =>  'You are not the store owner.',
        'subLimit'      =>  'Sub accounts are not allowed to open stores.',
    ],
    // Withdrawal
    'cash' => [
        'notCheck'          =>  'Please fill in the bank information after user authentication.',
        'moneyZero'         =>  'Amount cannot be 0.',
        'moneyNotEnough'    =>  'Insufficient withdrawal balance.',
    ],

    // commodity
    'goods' => [
        'checkSku'          =>  'Please select product specification.',
    ],

    // Marketing
    'discount' => [
        'over100'           =>  'Discount cannot exceed 100.',
        'need'              =>  'The number of people in a group cannot be less than 2.',
        'couponStockErr'    =>  'Coupon has been collected.',
        'couponExists'      =>  'Coupon does not exist.',
        'couponHas'         =>  'Coupon has been collected.',
    ],

    // order
    'order' => [
        'error'     =>  'Illegal order.',
        'empty'     =>  'Order not found.',
        'handleErr' =>  'Order operation failed.',
        'stockErr'  =>  'Insufficient inventory.',
        'addrErr'   =>  'Address cannot be empty.',
        'paymentErr' =>  'Illegal payment method.',
        'payed'     =>  'This order has been paid.',
        'payErr'    =>  'Payment failed.',
        'moneyNotEnough'    =>  'Sorry, your credit is running low.',
        'moneyPay'  =>  'Duplicate create payment order.',
        'deliveryEmpty'  =>  'Logistics information cannot be empty.',
        'orderSettlement'  =>  'System settlement.',
        'orderSettlementHandle'  =>  'Manual settlement.',
        'goodsCommission'  =>  'Commodity Commission',
    ],
    'menu'=>[
        "work"=>"workbench",
        "goods_center"=>"Commodity Center",
        "store_center"=>"Commodity Center",
        "system_center"=>"System center",
        "user_manager"=>"user management",
        "role_manager"=>"Role management",
        "attribute_center"=>"Attribute specification",
        "attribute_manager"=>"Attribute management",
        "specs_manager"=>"Specification management",
        "goods_manager"=>"Commodity management",
        "store_config"=>"Store configuration",
        "store_money"=>"Store fund",
        "order_settlements"=>"Order settlement",
        "cashes"=>"Withdrawal of funds",
        "statistics"=>"data statistics",
        "discount_center"=>"Marketing Center",
        "order_center"=>"Order center",
        "order_manager"=>"Order management",
        "refunds_order"=>"Refund order",
        "refunds_return"=>"Return order",
        "order_comments"=>"Order comment",
        "distribution_manager"=>"Distribution management",
        "discount_manager"=>"Coupon management",
        "seckill_manager"=>"Seckill management",
        "collage_manager"=>"Group management",
        "full_manager"=>"Full reduction management",
        "sales_analysis"=>"Sales volume analysis",
        "freight_config"=>"Freight configuration",
        "all_order"=>"All orders",
        "wait_order"=>"Pending order",
        "distributions_logs"=>"Distribution log",
        "coupons_manager"=>"Coupon management",
        "coupons_logs"=>"Coupon log",
        "dashboard"=>"Dashboard",
        "chats"=>"Customer service chat",
    ]
];
