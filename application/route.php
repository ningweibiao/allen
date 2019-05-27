<?php
    /*
     * 批量路由
     */

        return [
            //用户
            '[user]' => [
                'user_list'     =>'admin/User/lists',
                'user_login'    =>'admin/User/login',
                'user_logout'   =>'admin/User/logout',
                'user_add'      =>'admin/User/add',
                'user_edit'     =>'admin/User/edit',
                'user_del'      =>'admin/User/del',
            ],
            //后台首页
            '[home]' => [
                'index'         =>'admin/Home/index',
            ],
            '[menu]' => [
                'menu_list'     =>'admin/Menu/lists',
                'menu_add'      =>'admin/Menu/add',
                'menu_edit'     =>'admin/Menu/edit',
                'menu_del'      =>'admin/Menu/del',
            ],
            '[order]' => [
                'order_list'     =>'admin/Order/lists',
                'order_add'     =>'admin/Order/add',
            ],

        ];

