<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;
//首页
Route::rule('/','index/Cn/shouye');
//退出登录
Route::rule('out','index/Cn/out');
//注册
Route::rule('login','index/Cn/login');
//登录
Route::rule('logon','index/Cn/logon');
//个人信息
Route::rule('message','index/Cn/message');
//个人信息修改
Route::rule('update','index/Cn/update');

//中文首页
Route::rule('indexcn','index/Cn/Index');
//新闻动态
Route::rule('newsxq','index/Cn/newsxq');
//案例详情
Route::rule('casean','index/Cn/casean');
//航独院介绍
Route::rule('introduce','index/Cn/introduce');
//专家团队
Route::rule('team','index/Cn/team');
//专家详情
Route::rule('expert','index/Cn/expert');
//航空大都市理论单页
Route::rule('theory','index/Cn/theory');
//服务案例列表
Route::rule('caselist','index/Cn/caselist');
//新闻动态
Route::rule('newslist','index/Cn/newslist');
//加入AIC
Route::rule('aic','index/Cn/aic');
//加入我们
Route::rule('women','index/Cn/women');
//科学文献
Route::rule('datum','index/Cn/datum');
//搜索
Route::rule('search','index/Cn/search');
//足迹
Route::rule('regions','index/Cn/regions');
//开放职位
Route::rule('position','index/Cn/position');




//英文文首页
Route::rule('indexen','index/En/Index');
//新闻动态
Route::rule('newsxqe','index/En/newsxq');
//案例详情
Route::rule('caseane','index/En/casean');
//航独院介绍
Route::rule('introducee','index/En/introduce');
//专家团队
Route::rule('teame','index/En/team');
//专家详情
Route::rule('experte','index/En/expert');
//航空大都市理论单页
Route::rule('theorye','index/En/theory');
//服务案例列表
Route::rule('caseliste','index/En/caselist');
//新闻动态
Route::rule('newsliste','index/En/newslist');
//加入AIC
Route::rule('aice','index/En/aic');
//加入我们
Route::rule('womene','index/En/women');
//科学文献
Route::rule('datume','index/En/datum');
//搜索
Route::rule('searche','index/En/search');
//足迹
Route::rule('regionse','index/En/regions');
//开放职位
Route::rule('positione','index/En/position');
return [
    //别名配置,别名只能是映射到控制器且访问时必须加上请求的方法
    '__alias__'   => [
    ],
    //变量规则
    '__pattern__' => [
    ],
//        域名绑定到模块
//        '__domain__'  => [
//            'admin' => 'admin',
//            'api'   => 'api',
//        ],
];