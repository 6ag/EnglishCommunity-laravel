define({ "api": [
  {
    "type": "post",
    "url": "/auth/login.api",
    "title": "app登录",
    "group": "Auth",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>登录类型(username email mobile qq weixin weibo)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "identifier",
            "description": "<p>唯一标识</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "credential",
            "description": "<p>凭证</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n      \"status\": \"success\",\n      \"code\": 200,\n      \"message\": \"登录成功\",\n      \"data\": {\n          \"token\": \"xxxx.xxxx.xxx-xx\",\n          \"id\": 1,\n          \"username\": \"admin\",\n          \"nickname\": \"管理员\",\n          \"say\": null,\n          \"avatar\": \"uploads/user/avatar.jpg\",\n          \"mobile\": null,\n          \"sex\": 0,\n          \"qq_binding\": 0,\n          \"weixin_binding\": 0,\n          \"weibo_binding\": 0,\n          \"phone_binding\": 0,\n          \"email_binding\": 0,\n          \"register_time\": 1470797736\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 404,\n      \"message\": \"用户不存在\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "App/Http/Controllers/Api/AuthenticateController.php",
    "groupTitle": "Auth",
    "name": "PostAuthLoginApi"
  },
  {
    "type": "post",
    "url": "/auth/modifyUserPassword.api",
    "title": "修改用户密码",
    "group": "Auth",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "user_id",
            "description": "<p>用户id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "credential_old",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "credential_new",
            "description": "<p>新密码</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n      \"status\": \"success\",\n      \"code\": 200,\n      \"message\": \"修改密码成功\",\n      \"data\": null\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 404,\n      \"message\": \"旧密码错误\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "App/Http/Controllers/Api/AuthenticateController.php",
    "groupTitle": "Auth",
    "name": "PostAuthModifyuserpasswordApi"
  },
  {
    "type": "post",
    "url": "/auth/register.api",
    "title": "app注册",
    "group": "Auth",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>注册类型(username email mobile qq weixin weibo)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "identifier",
            "description": "<p>唯一标识</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "credential",
            "description": "<p>凭证</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n      \"status\": \"success\",\n      \"code\": 200,\n      \"message\": \"注册成功\",\n      \"data\": null\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 404,\n      \"message\": \"用户名已经存在\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "App/Http/Controllers/Api/AuthenticateController.php",
    "groupTitle": "Auth",
    "name": "PostAuthRegisterApi"
  },
  {
    "type": "post",
    "url": "/auth/seedCode.api",
    "title": "发送验证码",
    "group": "Auth",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "mobile",
            "description": "<p>手机号码</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n      \"status\": \"success\",\n      \"code\": 200,\n      \"message\": \"验证码发送成功\",\n      \"data\": null\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 404,\n      \"message\": \"验证码发送失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "App/Http/Controllers/Api/AuthenticateController.php",
    "groupTitle": "Auth",
    "name": "PostAuthSeedcodeApi"
  },
  {
    "type": "get",
    "url": "/getAllCategories.api",
    "title": "所有分类信息",
    "description": "<p>获取所有分类信息</p>",
    "group": "Category",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "have_data",
            "description": "<p>是否返回带数据的分类信息数据, 1有 0无</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "count",
            "description": "<p>每个分类信息返回多少条视频数据</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"查询分类列表成功\",\n    \"data\": [\n        {\n            \"id\": 1,\n            \"name\": \"音标\",\n            \"view\": 0,\n            \"pid\": 0\n        },\n        {\n            \"id\": 2,\n            \"name\": \"单词\",\n            \"view\": 0,\n            \"pid\": 0\n        },\n        {\n            \"id\": 3,\n            \"name\": \"语法\",\n            \"view\": 4,\n            \"pid\": 0\n        },\n        {\n            \"id\": 4,\n            \"name\": \"口语\",\n            \"view\": 0,\n            \"pid\": 0\n        },\n        {\n            \"id\": 5,\n            \"name\": \"听力\",\n            \"view\": 0,\n            \"pid\": 0\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 404,\n      \"message\": \"查询分类列表失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "App/Http/Controllers/Api/CategoryController.php",
    "groupTitle": "Category",
    "name": "GetGetallcategoriesApi"
  },
  {
    "type": "get",
    "url": "/getVideoInfosList.api",
    "title": "视频信息列表",
    "description": "<p>根据分类id查询视频信息列表</p>",
    "group": "Category",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "category_id",
            "description": "<p>分类id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "page",
            "description": "<p>页码</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "count",
            "description": "<p>每页数量,默认10条</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "recomend",
            "description": "<p>是否返回推荐的视频 1是 0否</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"查询视频列表成功\",\n    \"data\": {\n    \"total\": 25,\n    \"rows\": 2,\n    \"current_page\": 1,\n    \"data\": [\n        {\n            \"id\": 25,\n            \"title\": \"这是一个测试标题\",\n            \"intro\": \"这是一些简介这是一些简介这是一些简介\",\n            \"photo\": \"uploads/2c9337d98f69cd02cbbab4ae0e1cd118.jpg\",\n            \"view\": 0,\n            \"category_id\": 3,\n            \"teacher\": \"苍老师\",\n            \"type\": \"youku\",\n            \"created_at\": \"2016-08-01 05:29:44\",\n            \"updated_at\": \"2016-08-01 06:22:49\"\n            },\n            {\n            \"id\": 24,\n            \"title\": \"这是一个测试标题\",\n            \"intro\": \"这是一些简介这是一些简介这是一些简介\",\n            \"photo\": \"uploads/7f32770735063583890994798c4300d3.jpg\",\n            \"view\": 0,\n            \"category_id\": 3,\n            \"teacher\": \"苍老师\",\n            \"type\": \"youku\",\n            \"created_at\": \"2016-08-01 05:29:44\",\n            \"updated_at\": \"2016-08-01 05:29:44\"\n            }\n        ]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 404,\n      \"message\": \"查询视频列表失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "App/Http/Controllers/Api/CategoryController.php",
    "groupTitle": "Category",
    "name": "GetGetvideoinfoslistApi"
  },
  {
    "type": "get",
    "url": "/getCommentList.api",
    "title": "获取评论列表",
    "description": "<p>获取动弹或视频信息的评论列表</p>",
    "group": "Comment",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>类型:trends/video</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "source_id",
            "description": "<p>动弹或视频信息的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "page",
            "description": "<p>页码,默认当然是第1页</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "count",
            "description": "<p>每页数量,默认10条</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"查询评论列表成功\",\n    \"data\": {\n        \"total\": 4,\n        \"rows\": 2,\n        \"current_page\": 1,\n        \"data\": [\n            {\n                \"id\": 1,\n                \"type\": \"trends\",\n                \"source_id\": 43,\n                \"user_id\": 2,\n                \"content\": \"一起吃行不\",\n                \"pid\": 0,\n                \"created_at\": \"2016-08-10 14:40:12\",\n                \"updated_at\": \"2016-08-10 14:40:12\",\n                \"user_nickname\": \"王麻子\",\n                \"user_avatar\": \"uploads/user/avatar.jpg\"\n            },\n            {\n                \"id\": 2,\n                \"type\": \"trends\",\n                \"source_id\": 43,\n                \"user_id\": 1,\n                \"content\": \"完全可以啊\",\n                \"pid\": 1,\n                \"created_at\": \"2016-08-10 14:40:12\",\n                \"updated_at\": \"2016-08-10 14:40:12\",\n                \"user_nickname\": \"管理员\",\n                \"user_avatar\": \"uploads/user/avatar.jpg\",\n                \"puser_id\": 2,\n                \"puser_nickname\": \"王麻子\",\n                \"puser_avatar\": \"uploads/user/avatar.jpg\"\n            }\n        ]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 400,\n      \"message\": \"没有任何评论信息\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "App/Http/Controllers/Api/CommentController.php",
    "groupTitle": "Comment",
    "name": "GetGetcommentlistApi"
  },
  {
    "type": "get",
    "url": "/postComment.api",
    "title": "发布评论",
    "description": "<p>发布或者回复一条评论</p>",
    "group": "Comment",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "user_id",
            "description": "<p>用户id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>类型:trends/video</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "source_id",
            "description": "<p>动弹或视频信息的id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>评论内容</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "pid",
            "description": "<p>默认0,评论当前主题.为其他评论id则是回复评论</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"发布评论信息成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 400,\n      \"message\": \"发布评论信息失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "App/Http/Controllers/Api/CommentController.php",
    "groupTitle": "Comment",
    "name": "GetPostcommentApi"
  },
  {
    "type": "get",
    "url": "/getTrendsDetail.api",
    "title": "动弹详情",
    "description": "<p>获取动弹详情,获取动弹赞列表、评论列表是其他接口</p>",
    "group": "Trends",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "trends_id",
            "description": "<p>动弹id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "user_id",
            "description": "<p>访客用户id</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"查询动弹详情成功\",\n    \"data\": {\n        \"id\": 1,\n        \"user_id\": 1,\n        \"content\": \"今天吃屎非常合适\",\n        \"small_photo\": null,\n        \"photo\": null,\n        \"view\": 8,\n        \"created_at\": \"2016-08-10 14:40:12\",\n        \"updated_at\": \"2016-08-10 16:28:44\",\n        \"comment_count\": 3,\n        \"favorite_count\": 0,\n        \"is_favorite\": 0,\n        \"user_nickname\": \"管理员\",\n        \"user_avatar\": \"uploads/user/avatar.jpg\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n    \"status\": \"error\",\n    \"code\": 400,\n    \"message\": \"trends_id无效\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "App/Http/Controllers/Api/TrendsController.php",
    "groupTitle": "Trends",
    "name": "GetGettrendsdetailApi"
  },
  {
    "type": "get",
    "url": "/getTrendsList.api",
    "title": "动弹列表",
    "description": "<p>获取动弹列表,可根据参数返回不同的数据</p>",
    "group": "Trends",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "type",
            "description": "<p>返回类型 默认new, new最新 hot热门 me我的</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "page",
            "description": "<p>页码,默认当然是第1页</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "count",
            "description": "<p>每页数量,默认10条</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "user_id",
            "description": "<p>访客用户id,type为me,这个字段必须传,游客传0</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"查询动弹列表成功\",\n    \"data\": {\n    \"total\": 4,\n    \"rows\": \"2\",\n    \"current_page\": 1,\n    \"data\": [\n        {\n        \"id\": 4,\n        \"user_id\": 3,\n        \"content\": \"吃屎的这么这么多\",\n        \"photo\": null,\n        \"view\": 15,\n        \"created_at\": \"2016-08-08 15:57:08\",\n        \"updated_at\": \"2016-08-08 15:57:08\",\n        \"comment_count\": 0,\n        \"favorite_count\": 0,\n        \"user\": {\n            \"id\": 3,\n            \"nickname\": \"宝宝\",\n            \"say\": null,\n            \"avatar\": \"uploads/user/avatar.jpg\",\n            \"mobile\": null,\n            \"email\": null,\n            \"sex\": 0,\n            \"status\": 1,\n            \"is_admin\": 0,\n            \"qq_binding\": 0,\n            \"weixin_binding\": 0,\n            \"weibo_binding\": 0,\n            \"email_binding\": 0,\n            \"mobile_binding\": 0,\n            \"created_at\": \"2016-08-08 15:24:53\",\n            \"updated_at\": \"2016-08-08 15:24:53\"\n            }\n        },\n        {\n        \"id\": 3,\n        \"user_id\": 2,\n        \"content\": \"你们吃什么样的屎\",\n        \"photo\": null,\n        \"view\": 12,\n        \"created_at\": \"2016-08-08 15:55:08\",\n        \"updated_at\": \"2016-08-08 15:55:08\",\n        \"comment_count\": 0,\n        \"favorite_count\": 0,\n        \"user\": {\n            \"id\": 2,\n            \"nickname\": \"宝宝\",\n            \"say\": null,\n            \"avatar\": \"uploads/user/avatar.jpg\",\n            \"mobile\": null,\n            \"email\": null,\n            \"sex\": 0,\n            \"status\": 1,\n            \"is_admin\": 0,\n            \"qq_binding\": 0,\n            \"weixin_binding\": 0,\n            \"weibo_binding\": 0,\n            \"email_binding\": 0,\n            \"mobile_binding\": 0,\n            \"created_at\": \"2016-08-08 15:24:26\",\n            \"updated_at\": \"2016-08-08 15:24:26\"\n        }\n        }\n        ]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 404,\n      \"message\": \"查询动弹列表失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "App/Http/Controllers/Api/TrendsController.php",
    "groupTitle": "Trends",
    "name": "GetGettrendslistApi"
  },
  {
    "type": "get",
    "url": "/postTrends.api",
    "title": "发布动弹",
    "description": "<p>发布一条新的动弹</p>",
    "group": "Trends",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "user_id",
            "description": "<p>作者用户id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>动弹内容</p>"
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": true,
            "field": "photo",
            "description": "<p>配图,这个字段以图片上传方式提交即可</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"发布动弹成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 400,\n      \"message\": \"发布动弹失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "App/Http/Controllers/Api/TrendsController.php",
    "groupTitle": "Trends",
    "name": "GetPosttrendsApi"
  },
  {
    "type": "get",
    "url": "/getVideoList.api",
    "title": "视频播放列表",
    "description": "<p>根据视频信息id查询视频播放列表</p>",
    "group": "Video",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "video_info_id",
            "description": "<p>视频信息id</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"查询视频播放列表成功\",\n    \"data\": [\n        {\n            \"id\": 137,\n            \"title\": \"音标学习\",\n            \"video_info_id\": 25,\n            \"video_url\": \"http://v.youku.com/v_show/id_XNzg3NTcxMDA=.html\",\n            \"created_at\": \"2016-08-01 06:22:49\",\n            \"updated_at\": \"2016-08-01 06:22:49\",\n            \"order\": 0\n        },\n        {\n            \"id\": 138,\n            \"title\": \"语法学习\",\n            \"video_info_id\": 25,\n            \"video_url\": \"http://v.youku.com/v_show/id_XNzg3NTcxMDA=.html\",\n            \"created_at\": \"2016-08-01 06:22:49\",\n            \"updated_at\": \"2016-08-01 06:22:49\",\n            \"order\": 1\n        },\n        {\n            \"id\": 139,\n            \"title\": \"牛逼学习\",\n            \"video_info_id\": 25,\n            \"video_url\": \"http://v.youku.com/v_show/id_XNzg3NTcxMDA=.html\",\n            \"created_at\": \"2016-08-01 06:22:49\",\n            \"updated_at\": \"2016-08-01 06:22:49\",\n            \"order\": 2\n        },\n        {\n            \"id\": 140,\n            \"title\": \"傻逼学习\",\n            \"video_info_id\": 25,\n            \"video_url\": \"http://v.youku.com/v_show/id_XNzg3NTcxMDA=.html\",\n            \"created_at\": \"2016-08-01 06:22:49\",\n            \"updated_at\": \"2016-08-01 06:22:49\",\n            \"order\": 3\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 404,\n      \"message\": \"查询视频播放列表失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "App/Http/Controllers/Api/VideoController.php",
    "groupTitle": "Video",
    "name": "GetGetvideolistApi"
  },
  {
    "type": "get",
    "url": "/parseYouku1.api",
    "title": "解析优酷视频1",
    "description": "<p>根据url/id解析flv视频列表,可供分段下载 ffmpeg合成</p>",
    "group": "Video",
    "permission": [
      {
        "name": "none"
      }
    ],
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "url",
            "description": "<p>视频地址</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"解析视频地址成功\",\n    \"data\": {\n        \"normal\": {\n            \"count\": \"2\",\n            \"data\": [\n                \"http://k.youku.com/player/getFlvPath/sid/847022969297012c1d9f3_00/st/flv/fileid/030002020057A01079076B31F0446F4CC58682-901F-3DB9-6F28-0B6148C748B7?K=a506ff12854c8ebe282b9f1b&ctype=12&ev=1&token=3704&oip=3549804647&ep=eiaTGkuPX8gJ5yrYiD8bNC22fSEMXP4J9h%2BFg9JgALshT5m%2FmD7Wzp23SI1BF48ZdiYAZu%2BC2NXvbEgWYflDqB4Q3DraMPrmiPLr5a0hwpEEbmoxdsWls1SdRDD1&ymovie=1\",\n                \"http://k.youku.com/player/getFlvPath/sid/847022969297012c1d9f3_01/st/flv/fileid/030002020157A01079076B31F0446F4CC58682-901F-3DB9-6F28-0B6148C748B7?K=32258eefe0579806261f2881&ctype=12&ev=1&token=3704&oip=3549804647&ep=eiaTGkuPX8gJ5yrYiD8bNC22fSEMXP4J9h%2BFg9JgALohT5m%2FmD7Wzp23SI1BF48ZdiYAZu%2BC2NXvbEgWYflDqB4Q3DraMPrmiPLr5a0hwpEEbmoxdsWls1SdRDD1&ymovie=1\"\n            ]\n        },\n        \"high\": {\n            \"count\": \"2\",\n            \"data\": [\n                \"http://k.youku.com/player/getFlvPath/sid/847022969297012c1d9f3_00/st/mp4/fileid/030008020057A01347076B31F0446F4CC58682-901F-3DB9-6F28-0B6148C748B7?K=99121930a5baabe32412b1e7&ctype=12&ev=1&token=3704&oip=3549804647&ep=eiaTGkuPX8gJ5yrYiD8bNC22fSEMXP4J9h%2BFidJgALshT5m%2FmD3VwJ23SI1BF48ZdiYAZu%2BC2NXvbEgWYflDqB4Q3DraMPrmiPLr5a0hwpEEbmoxdsWls1SdRDD1\",\n                \"http://k.youku.com/player/getFlvPath/sid/847022969297012c1d9f3_01/st/mp4/fileid/030008020157A01347076B31F0446F4CC58682-901F-3DB9-6F28-0B6148C748B7?K=8aabf523c76432272412b1e7&ctype=12&ev=1&token=3704&oip=3549804647&ep=eiaTGkuPX8gJ5yrYiD8bNC22fSEMXP4J9h%2BFidJgALohT5m%2FmD3VwJ23SI1BF48ZdiYAZu%2BC2NXvbEgWYflDqB4Q3DraMPrmiPLr5a0hwpEEbmoxdsWls1SdRDD1\"\n            ]\n        },\n        \"hyper\": {\n            \"count\": \"3\",\n            \"data\": [\n                \"http://k.youku.com/player/getFlvPath/sid/847022969297012c1d9f3_00/st/flv/fileid/030001030057A013C5076B31F0446F4CC58682-901F-3DB9-6F28-0B6148C748B7?K=0926bb69b555efc3261f2881&ctype=12&ev=1&token=3704&oip=3549804647&ep=eiaTGkuPX8gJ5yrYiD8bNC22fSEMXP4J9h%2BFgNJhALshT5m%2FmD2iwp23SI1BF48ZdiYAZu%2BC2NXvbEgWYflDqB4Q3DraMPrmiPLr5a0hwpEEbmoxdsWls1SdRDD1\",\n                \"http://k.youku.com/player/getFlvPath/sid/847022969297012c1d9f3_01/st/flv/fileid/030001030157A013C5076B31F0446F4CC58682-901F-3DB9-6F28-0B6148C748B7?K=53e8c1867c4d32f2261f2881&ctype=12&ev=1&token=3704&oip=3549804647&ep=eiaTGkuPX8gJ5yrYiD8bNC22fSEMXP4J9h%2BFgNJhALohT5m%2FmD2iwp23SI1BF48ZdiYAZu%2BC2NXvbEgWYflDqB4Q3DraMPrmiPLr5a0hwpEEbmoxdsWls1SdRDD1\",\n                \"http://k.youku.com/player/getFlvPath/sid/847022969297012c1d9f3_02/st/flv/fileid/030001030257A013C5076B31F0446F4CC58682-901F-3DB9-6F28-0B6148C748B7?K=e8d08cbef327713e261f2881&ctype=12&ev=1&token=3704&oip=3549804647&ep=eiaTGkuPX8gJ5yrYiD8bNC22fSEMXP4J9h%2BFgNJhALkhT5m%2FmD2iwp23SI1BF48ZdiYAZu%2BC2NXvbEgWYflDqB4Q3DraMPrmiPLr5a0hwpEEbmoxdsWls1SdRDD1\"\n            ]\n        }\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 404,\n      \"message\": \"解析视频地址失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "App/Http/Controllers/Api/VideoController.php",
    "groupTitle": "Video",
    "name": "GetParseyouku1Api"
  }
] });
