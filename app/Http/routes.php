<?php

// 首页直接跳转到后台
Route::get('/', function () {
    return redirect()->route('admin.index');
});

// 后台路由组
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    // 注册
    Route::any('register', 'UserController@register')->name('admin.register')->middleware('check.register');

    // 登录
    Route::any('login', 'UserController@login')->name('admin.login');

    // 注销
    Route::get('logout', 'UserController@logout')->name('admin.logout');

    // 已经登录
    Route::group(['middleware' => ['admin.login']], function () {
    
        // 后台首页
        Route::get('/', 'IndexController@index')->name('admin.index');
        
        // 文档
        Route::get('apidoc', function () {
            return view('admin.apidoc');
        });

        // 修改密码
        Route::any('modify', 'UserController@modify')->name('admin.modify');

        // 分类
        Route::resource('category', 'CategoryController');

        // 视频
        Route::resource('video', 'VideoController');
        Route::post('upload', 'VideoController@uploadImage')->name('admin.upload');

        // 配置
        Route::resource('option', 'OptionController');

        // 反馈信息
        Route::resource('feedback', 'FeedbackController');
    });
});

// api路由组
Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {

    Route::group(['prefix' => 'auth'], function () {
        // 发送验证码
        Route::post('seedCode.api', 'AuthenticateController@sendCkeckCode');
        // 注册
        Route::post('register.api', 'AuthenticateController@register');
        // 登录
        Route::post('login.api', 'AuthenticateController@login');
        // 修改密码
        Route::post('modifyUserPassword.api', 'AuthenticateController@modifyUserPassword');
    });

    // 查询所有分类列表
    Route::get('getAllCategories.api', 'CategoryController@getCategoryies');

    // 根据分类id查询视频信息列表
    Route::get('getVideoInfosList.api', 'CategoryController@getVideoInfosList');

    // 根据视频信息id 获取视频信息
    Route::get('getVideoList.api', 'VideoController@getVideoList');
    
    // 解析视频 - flv视频片段,可缓存
    Route::get('parseYouku1.api', 'VideoController@parseYouku1');

    // 动弹列表
    Route::get('getTweetsList.api', 'TweetsController@getTweetsList');

    // 动弹详情
    Route::get('getTweetsDetail.api', 'TweetsController@getTweetsDetail');

    // 发布动弹
    Route::post('postTweets.api', 'TweetsController@postTweets');
    
    // 发布评论
    Route::post('postComment.api', 'CommentController@postComment');

    // 评论列表
    Route::get('getCommentList.api', 'CommentController@getCommentList');

    // 获取语法手册
    Route::get('getGramarManual.api', 'GrammarController@getGramarManual');

    // 收藏视频
    Route::post('collectVideoInfo.api', 'CollectionController@collectVideoInfo');

    // 获取收藏信息列表
    Route::get('getCollectionList.api', 'CollectionController@getCollectionList');

    // 获取朋友关系列表
    Route::get('getFriendList.api', 'FriendController@getFriendList');

});
