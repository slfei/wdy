<?php


return [
    'common' => [
        'sure' => '提交申请',
        'cancel' => '取消申请',
        'money_unit' => '￥',
        'select' => [
            'defult'=> '请选择',
            'one'=> '买错课了',
            'two'=> '没时间学',
            'three'=> '想换一个别的课程',
            'four'=> '其他',
        ],
        'refund_header' => [
            'apply'=> '买家申请退款',
            'process'=> '卖家处理退款申请',
            'result'=> '退款完毕',

        ],
        'course_info' => [
            'title'=> '订单详情',
            'order_id'=> '订单号',
            'cur_price'=> '订单金额',
            'pay_type'=> '订单支付方式',
            'wx'=> '微信',
            'alipay'=> '支付宝',

        ],
        'application_info' => [
            'refund_id'=> '退款编号',
            'add_time'=> '申请时间',
            'refund_money'=> '退款金额',
            'refund_instructions' => '退款说明',
            'reason' => '退款原因',

        ],
    ],
    'apply' => [
        'section_content' => [
            'reason' => '退款原因',
            'select' => [
                'defult'=> '请选择',
                'one'=> '买错课了',
                'two'=> '没时间学',
                'three'=> '想换一个别的课程',
                'four'=> '其他',
            ],
            'refund_amount' => '退款金额',
            'refund_instructions' => '退款说明',
            'placeholder' => '200字以内',
        ],
    ],

    'process' => [
        'section_content' => [
            'refunc_type' => '申请已提交，请等待卖家处理。',
            'prompting_start' => '卖家会在',
            'prompting_in' => '03天00时00秒',
            'prompting_end' => '内处理，如超过时间，则自动默认申请通过!',
            'cancel' => '您还可以',
            'cancelrefund' => '取消退款申请',
            'select' => [
                'defult'=> '请选择',
                'one'=> '买错课了',
                'two'=> '没时间学',
                'three'=> '想换一个别的课程',
                'four'=> '其他',
            ],
            'refund_amount' => '退款金额',
            'refund_instructions' => '退款说明',
            'placeholder' => '200字以内',
        ],
    ],
    'result' => [
        'section_content' => [
            'refund_result' => [
                'two' => [
                    'status' => '2',
                    'value' => '退款成功',
                    'text' => '退款成功退款会在2-7个工作日退还到您的购买账户',
                ],
                'three' => [
                    'status' => '3',
                    'value' => '退款关闭',
                    'text' => '因您撤销退款申请，退款已关闭，关闭时间为',
                ],
                'four' => [
                    'status' => '2',
                    'value' => '退款成功',
                    'text' => '退款成功时间',
                ],

            ],
        ],
    ],

];

