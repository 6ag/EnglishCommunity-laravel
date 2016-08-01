define({ "api": [
  {
    "type": "post",
    "url": "/auth/login",
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
            "field": "username",
            "description": "<p>账号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n      \"status\": \"success\",\n      \"code\": 200,\n      \"message\": \"登录成功\",\n      \"data\": {\n          \"token\": \"xxxx.xxxx.xxx-xx\",\n          \"id\": 1,\n          \"username\": \"admin\",\n          \"nickname\": \"管理员\",\n          \"say\": null,\n          \"avatar\": null,\n          \"mobile\": null,\n          \"score\": 0,\n          \"sex\": 0,\n          \"qq_binding\": 0,\n          \"wx_binding\": 0,\n          \"wb_binding\": 0,\n          \"group\": \"一级会员\",\n          \"permission\": \"管理员\",\n          \"status\": 1,\n          \"register_time\": -62169984000\n      }\n  }",
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
    "filename": "app/Http/Controllers/Api/AuthenticateController.php",
    "groupTitle": "Auth",
    "name": "PostAuthLogin"
  },
  {
    "type": "post",
    "url": "/auth/register",
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
            "field": "username",
            "description": "<p>账号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": "<p>密码</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password_confirmation",
            "description": "<p>重复密码</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n      \"status\": \"success\",\n      \"code\": 200,\n      \"message\": \"注册成功\",\n      \"data\": {\n          \"username\": \"admin888\"\n      }\n  }",
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
    "filename": "app/Http/Controllers/Api/AuthenticateController.php",
    "groupTitle": "Auth",
    "name": "PostAuthRegister"
  },
  {
    "type": "get",
    "url": "/category/{category}/video",
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
            "field": "page",
            "description": "<p>页码</p>"
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
    "filename": "app/Http/Controllers/Api/CategoryController.php",
    "groupTitle": "Category",
    "name": "GetCategoryCategoryVideo"
  },
  {
    "type": "get",
    "url": "/video/{video}",
    "title": "视频播放列表",
    "description": "<p>根据视频信息id查询视频播放列表</p>",
    "group": "Video",
    "permission": [
      {
        "name": "none"
      }
    ],
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
    "filename": "app/Http/Controllers/Api/VideoController.php",
    "groupTitle": "Video",
    "name": "GetVideoVideo"
  }
] });
