<?php
return [
    'adminEmail' => 'admin@example.com',
    'menus' =>[
        ['title'=>'文章管理',
            'icon'=>'icon-edit',
            'sons'=>[
                   ['title'=>'我的文章' ,'url'=>'/article/index'] ,
                   ['title'=>'写文章' ,'url'=>'/article/create'] ,

            ],

        ],
        ['title'=>'资料管理',
            'icon'=>'icon-folder-close',
            'sons'=>[
                ['title'=>'我的资料' ,'url'=>'/material/index'] ,
                ['title'=>'上传资料' ,'url'=>'/material/create'] ,
            ]
        ],
        ['title'=>'视频管理',
            'icon'=>'icon-film',
            'sons'=>[
                ['title'=>'我的视频' ,'url'=>'/video/index'] ,
                ['title'=>'上传视频' ,'url'=>'/video/create'] ,
            ]
        ],
        ['title'=>'书籍管理',
            'icon'=>'icon-book',
            'sons'=>[
                ['title'=>'我的书籍' ,'url'=>'/book/index'] ,
                ['title'=>'创建书籍' ,'url'=>'/book/create'] ,

            ]
        ],
//        ['title'=>'积分管理',
//            'icon'=>'',
//            'sons'=>[
//                ['title'=>'我的积分' ,'url'=>'/article/user'] ,
//                ['title'=>'获取积分' ,'url'=>'/article/love'] ,
//                ['title'=>'积分活动' ,'url'=>'/article/love'] ,
//            ]
//        ],
    ]
];
