<?php


return [
    'common' => [
        'sure' => 'Submit',
        'cancel' => 'Cancel',
        'money_unit' => '￥',
        'select' => [
            'defult'=> 'Please choose',
            'one'=> 'Buy the course wrong',
            'two'=> 'No time to learn',
            'three'=> 'would like to change another one',
            'four'=> 'others',
        ],
        'refund_header' => [
            'apply'=> 'Application for refund',
            'process'=> ' Handles the refund application',
            'result'=> 'refund finished',

        ],
        'course_info' => [
            'title'=> 'Order details',
            'order_id'=> 'Order number',
            'cur_price'=> 'Order amount',
            'pay_type'=> 'Order payment method',
            'wx'=> 'Wechat',
            'alipay'=> 'Ailpay',

        ],
        'application_info' => [
            'refund_id'=> 'Refund number',
            'add_time'=> 'Application time',
            'refund_money'=> 'Refund amount',
            'refund_instructions' => 'Refund instruction',
            'reason' => 'Refund reason',

        ],
    ],
    'apply' => [
        'section_content' => [
            'reason' => 'Reason',
            'select' => [
                'defult'=> 'Please choose',
                'one'=> 'Buy the course wrong',
                'two'=> 'No time to learn',
                'three'=> 'would like to change another one',
                'four'=> 'others',
            ],
            'refund_amount' => 'Amount',
            'refund_instructions' => 'Instruction',
            'placeholder' => 'Within 200 words',
        ],
    ],

    'process' => [
        'section_content' => [
            'refunc_type' => 'The application has been submitted. Please wait for the seller to deal with it.',
            'prompting_start' => 'The seller will handle in ',
            'prompting_in' => '03Days00Minutse00Seconds',
            'prompting_end' => ' if more than time, the automatic default application will be passed.',
            'cancel' => 'You can also',
            'cancelrefund' => 'cancel',
            'select' => [
                'defult'=> 'Please choose',
                'one'=> 'Buy the course wrong',
                'two'=> 'No time to learn',
                'three'=> 'would like to change another one',
                'four'=> 'others',
            ],
            'refund_amount' => 'Refund amount',
            'refund_instructions' => 'Refund instruction',
            'placeholder' => 'Within 200 words',
        ],
    ],
    'result' => [
        'section_content' => [
            'refund_result' => [
                'two' => [
                    'status' => '2',
                    'value' => 'Refund succeed',
                    'text' => 'The refund will be returned to your purchase account in 2-7 working days.',
                ],
                'three' => [
                    'status' => '3',
                    'value' => 'Refund closed',
                    'text' => 'As you revoke the refund application,the refund has been closed and the closing time is',
                ],
                'four' => [
                    'status' => '2',
                    'value' => 'Refund succeed',
                    'text' => 'Refundable time',
                ],

            ],
        ],
    ],

];

