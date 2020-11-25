<?php
return [
    'button' => [
        [
            'type' => 'click',
            'name' => '首页',
            'key' => '首页001'
        ],
        [
            'name' => '最新活动',
            'sub_button' => [
                [
                    'type' => 'view',
                    'name' => '搜索',
                    'url' => 'http://www.soso.com/'
                ],
                [
                    'type' => 'click',
                    'name' => '客服',
                    'key' => '客服001'
                ],
                [
                    'type' => 'click',
                    'name' => '不能点',
                    'key' => '不能点'
                ],
                [
                    'type' => 'pic_sysphoto',
                    'name' => '系统拍照发图',
                    'key' => 'photo001'
                ],
                [
                    'type' => 'location_select',
                    'name' => '发送位置',
                    'key' => '位置信息'
                ]
            ]
        ],
        [
            'type' => 'view',
            'name' => '个人中心',
            'url' => 'http://m.baidu.com/'
        ]
    ]
];

