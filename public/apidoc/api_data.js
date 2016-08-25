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
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"登录成功\",\n    \"result\": {\n        \"token\": \"xxxx.xxxxxxx.xxxxxxxx\",\n        \"id\": 4,\n        \"nickname\": \"佚名\",\n        \"say\": null,\n        \"avatar\": \"http://www.english.com/uploads/user/avatar.jpg\",\n        \"mobile\": null,\n        \"email\": null,\n        \"sex\": 0,\n        \"qqBinding\": 0,\n        \"weixinBinding\": 0,\n        \"weiboBinding\": 0,\n        \"emailBinding\": 0,\n        \"mobileBinding\": 0,\n        \"followersCount\": 32,\n        \"followingCount\": 2,\n        \"registerTime\": \"1471685857\",\n        \"lastLoginTime\": \"1471685891\"\n    }\n}",
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
    "name": "PostAuthLoginApi"
  },
  {
    "type": "post",
    "url": "/auth/modifyUserPassword.api",
    "title": "修改用户密码",
    "group": "Auth",
    "permission": [
      {
        "name": "Token"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>登录成功返回的token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\" : \"Bearer {token}\"\n}",
          "type": "json"
        }
      ]
    },
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
    "filename": "app/Http/Controllers/Api/AuthenticateController.php",
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
            "description": "<p>注册类型(username)</p>"
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
          "content": "{\n      \"status\": \"error\",\n      \"code\": 400,\n      \"message\": \"用户名已经存在\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/AuthenticateController.php",
    "groupTitle": "Auth",
    "name": "PostAuthRegisterApi"
  },
  {
    "type": "post",
    "url": "/auth/retrievePasswordWithSendEmail.api",
    "title": "重置密码邮件",
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
            "field": "identifier",
            "description": "<p>username账号</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": "<p>绑定的邮箱</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n      \"status\": \"success\",\n      \"code\": 200,\n      \"message\": \"邮件发送成功\",\n      \"data\": null\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 404,\n      \"message\": \"邮件发送失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/AuthenticateController.php",
    "groupTitle": "Auth",
    "name": "PostAuthRetrievepasswordwithsendemailApi"
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
          "content": "{\n      \"status\": \"error\",\n      \"code\": 400,\n      \"message\": \"验证码发送失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/AuthenticateController.php",
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
            "field": "user_id",
            "description": "<p>当前用户id 未登录不传或者传0</p>"
          },
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
          "content": "{\n        \"status\": \"success\",\n        \"code\": 200,\n        \"message\": \"查询分类列表成功\",\n        \"result\": [\n        {\n        \"id\": 1,\n        \"name\": \"音标\",\n        \"alias\": \"yinbiao\",\n        \"view\": 31,\n        \"videoInfoList\": [\n        {\n            \"id\": 13,\n            \"title\": \"零基础学习英语音标视频教程\",\n            \"cover\": \"http://www.english.com/uploads/video-info/74ceb292408d6718cb818293b039c5e2.jpg\",\n            \"view\": 39,\n            \"teacherName\": \"Nickcen\",\n            \"videoType\": \"youku\",\n            \"recommended\": 0,\n            \"collected\": 0,\n            \"videoCount\": 16,\n            \"commentCount\": 0,\n            \"collectionCount\": 0\n        },\n        {\n            \"id\": 12,\n              \"title\": \"48个国际音标发音视频教程全集\",\n              \"cover\": \"http://www.english.com/uploads/video-info/f05d2843f5ecf9ec9448c98a9e6bbe80.jpg\",\n              \"view\": 17,\n              \"teacherName\": \"佚名\",\n              \"videoType\": \"youku\",\n              \"recommended\": 0,\n              \"collected\": 0,\n              \"videoCount\": 21\n            }\n        ]\n        },\n        {\n            \"id\": 2,\n          \"name\": \"单词\",\n          \"alias\": \"danci\",\n          \"view\": 8,\n          \"videoInfoList\": [\n            {\n                \"id\": 87,\n          \"title\": \"英语单词拼读视频教程全集\",\n          \"cover\": \"http://www.english.com/uploads/video-info/245894d3fc2312adc2df4d70ac38abfe.jpg\",\n          \"view\": 4,\n          \"teacherName\": \"阿明\",\n          \"videoType\": \"youku\",\n          \"recommended\": 0,\n          \"collected\": 0,\n          \"videoCount\": 15\n        },\n        {\n            \"commentCount\": 0,\n          \"collectionCount\": 0,\n          \"id\": 86,\n          \"title\": \"快速记单词视频教程全集\",\n          \"cover\": \"http://www.english.com/uploads/video-info/feef4bc8174da15db4207262d38f980f.jpg\",\n          \"view\": 0,\n          \"teacherName\": \"阿明\",\n          \"videoType\": \"youku\",\n          \"recommended\": 0,\n          \"collected\": 0,\n          \"videoCount\": 14\n        }\n      ]\n    }\n]\n}",
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
    "filename": "app/Http/Controllers/Api/CategoryController.php",
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
            "optional": true,
            "field": "user_id",
            "description": "<p>当前用户id 未登录不传或者传0</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
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
            "field": "recommend",
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
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"查询指定分类视频列表成功\",\n    \"result\": {\n        \"pageInfo\": {\n            \"total\": 13,\n            \"currentPage\": 1\n        },\n        \"data\": [\n            {\n                \"id\": 13,\n                \"title\": \"零基础学习英语音标视频教程\",\n                \"cover\": \"http://www.english.com/uploads/video-info/74ceb292408d6718cb818293b039c5e2.jpg\",\n                \"view\": 39,\n                \"teacherName\": \"Nickcen\",\n                \"videoType\": \"youku\",\n                \"recommended\": 0,\n                \"collected\": 0,\n                \"videoCount\": 21,\n                \"commentCount\": 0,\n                \"collectionCount\": 0\n            },\n            {\n                \"id\": 12,\n                \"title\": \"48个国际音标发音视频教程全集\",\n                \"cover\": \"http://www.english.com/uploads/video-info/f05d2843f5ecf9ec9448c98a9e6bbe80.jpg\",\n                \"view\": 17,\n                \"teacherName\": \"佚名\",\n                \"videoType\": \"youku\",\n                \"recommended\": 0,\n                \"collected\": 0,\n                \"videoCount\": 21,\n                \"commentCount\": 0,\n                \"collectionCount\": 0\n            }\n        ]\n    }\n}",
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
    "name": "GetGetvideoinfoslistApi"
  },
  {
    "type": "get",
    "url": "/getCollectionList.api",
    "title": "获取收藏列表",
    "description": "<p>获取指定用户的收藏列表</p>",
    "group": "Collection",
    "permission": [
      {
        "name": "Token"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>登录成功返回的token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\" : \"Bearer {token}\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"查询动弹列表成功\",\n    \"result\": {\n        \"pageInfo\": {\n            \"total\": 2,\n            \"currentPage\": 1\n        },\n        \"data\": [\n            {\n                \"id\": 1,\n                \"title\": \"音标学习视频教程全集\",\n                \"cover\": \"http://www.english.com/uploads/video-info/49a201b6868097e4762928e767f0c429.jpg\",\n                \"view\": 1,\n                \"teacherName\": \"佚名\",\n                \"videoType\": \"youku\",\n                \"recommended\": 0,\n                \"videoCount\": 45,\n                \"collected\": 1\n            },\n            {\n                \"id\": 2,\n                \"title\": \"英语国际英标逆向学习法视频教程全集\",\n                \"cover\": \"http://www.english.com/uploads/video-info/82603b4674f15eb07eb031906b04b3a4.jpg\",\n                \"view\": 4,\n                \"teacherName\": \"佚名\",\n                \"videoType\": \"youku\",\n                \"recommended\": 0,\n                \"videoCount\": 12,\n                \"collected\": 1\n            }\n        ]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 400,\n      \"message\": \"获取收藏列表失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/CollectionController.php",
    "groupTitle": "Collection",
    "name": "GetGetcollectionlistApi"
  },
  {
    "type": "post",
    "url": "/addOrCancelCollectVideoInfo.api",
    "title": "收藏视频",
    "description": "<p>收藏视频信息</p>",
    "group": "Collection",
    "permission": [
      {
        "name": "Token"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>登录成功返回的token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\" : \"Bearer {token}\"\n}",
          "type": "json"
        }
      ]
    },
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
            "type": "Number",
            "optional": false,
            "field": "video_info_id",
            "description": "<p>视频信息的id</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"收藏视频信息成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 400,\n      \"message\": \"收藏视频信息失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/CollectionController.php",
    "groupTitle": "Collection",
    "name": "PostAddorcancelcollectvideoinfoApi"
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
            "description": "<p>类型:tweet/video_info</p>"
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
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"查询评论列表成功\",\n    \"result\": {\n        \"pageInfo\": {\n            \"total\": 2,\n            \"currentPage\": 1\n        },\n        \"data\": [\n            {\n                \"id\": 6,\n                \"type\": \"tweet\",\n                \"sourceId\": 5,\n                \"content\": \"[怒][怒]\",\n                \"publishTime\": \"1471619839\",\n                \"author\": {\n                    \"id\": 10000,\n                    \"nickname\": \"管理员\",\n                    \"avatar\": \"http://www.english.com/uploads/user/avatar/9f4ed11179f6962bd57cf9635474446b.jpg\"\n                }\n            },\n            {\n                \"id\": 5,\n                \"type\": \"tweet\",\n                \"sourceId\": 5,\n                \"content\": \"[吃惊]还可以\",\n                \"publishTime\": \"1471608154\",\n                \"author\": {\n                    \"id\": 10000,\n                    \"nickname\": \"管理员\",\n                    \"avatar\": \"http://www.english.com/uploads/user/avatar/9f4ed11179f6962bd57cf9635474446b.jpg\"\n                }\n            }\n        ]\n    }\n}",
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
    "filename": "app/Http/Controllers/Api/CommentController.php",
    "groupTitle": "Comment",
    "name": "GetGetcommentlistApi"
  },
  {
    "type": "post",
    "url": "/postComment.api",
    "title": "发布评论",
    "description": "<p>发布或者回复一条评论</p>",
    "group": "Comment",
    "permission": [
      {
        "name": "Token"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>登录成功返回的token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\" : \"Bearer {token}\"\n}",
          "type": "json"
        }
      ]
    },
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
            "description": "<p>类型:tweet/video_info</p>"
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
            "optional": false,
            "field": "pid",
            "description": "<p>为0则评论当前主题.为其他评论id则是回复评论</p>"
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
    "filename": "app/Http/Controllers/Api/CommentController.php",
    "groupTitle": "Comment",
    "name": "PostPostcommentApi"
  },
  {
    "type": "get",
    "url": "/addOrCancelFriend.api",
    "title": "添加或删除关注",
    "description": "<p>添加或删除关注</p>",
    "group": "Friend",
    "permission": [
      {
        "name": "Token"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>登录成功返回的token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\" : \"Bearer {token}\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "user_id",
            "description": "<p>当前用户的id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "relation_user_id",
            "description": "<p>关注或移除关注的用户的id</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"关注成功\",\n    \"result\": null\n}",
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
    "filename": "app/Http/Controllers/Api/FriendController.php",
    "groupTitle": "Friend",
    "name": "GetAddorcancelfriendApi"
  },
  {
    "type": "get",
    "url": "/getFriendList.api",
    "title": "朋友关系列表",
    "description": "<p>获取朋友关系列表(关注、粉丝)</p>",
    "group": "Friend",
    "permission": [
      {
        "name": "Token"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>登录成功返回的token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\" : \"Bearer {token}\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "user_id",
            "description": "<p>当前用户的id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "relation",
            "description": "<p>关系类型 0粉丝 1关注</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"查询朋友关系列表成功\",\n    \"result\": [\n        {\n            \"relationUserId\": 10001,\n            \"relationNickname\": \"王麻子\",\n            \"relationAvatar\": \"http://www.english.com/uploads/user/default/avatar.jpg\"\n        },\n        {\n            \"relationUserId\": 10002,\n            \"relationNickname\": \"李二狗\",\n            \"relationAvatar\": \"http://www.english.com/uploads/user/default/avatar.jpg\"\n        }\n    ]\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 404,\n      \"message\": \"没有查询到朋友关系数据\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/FriendController.php",
    "groupTitle": "Friend",
    "name": "GetGetfriendlistApi"
  },
  {
    "type": "get",
    "url": "/getGramarManual.api",
    "title": "获取语法手册数据",
    "description": "<p>获取所有语法数据,并存储到客户端</p>",
    "group": "Grammar",
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
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"查询动弹列表成功\",\n    \"data\": {\n        \"total\": 55,\n        \"rows\": 2,\n        \"current_page\": 1,\n        \"data\": [\n            {\n                \"id\": 1,\n                \"title\": \"关于词类和句子成分\",\n                \"content\": \"根据词的形式、意义及其在句中的功用将词分为若干类，叫做词类。一个句子由各个功用不同的部分所构成，这些部分叫做句子成分。\\n\",\n                \"created_at\": null,\n                \"updated_at\": null\n            },\n            {\n                \"id\": 2,\n                \"title\": \"英语词法和句法\",\n                \"content\": \"1.词法(morphology)词法研究的对象是各种词的形式及其用法。\\n英语词类的形式变化有：名词和代词的数、格和性的形式变化；动词的人称、时态、语态、语气等形式变化；以及形容词和副词比较等级的形式变化。\\n\",\n                \"created_at\": null,\n                \"updated_at\": null\n            }\n        ]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 400,\n      \"message\": \"失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/GrammarController.php",
    "groupTitle": "Grammar",
    "name": "GetGetgramarmanualApi"
  },
  {
    "type": "post",
    "url": "/addOrCancelLikeRecord.api",
    "title": "添加删除赞",
    "description": "<p>添加或删除赞</p>",
    "group": "LikeRecord",
    "permission": [
      {
        "name": "Token"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>登录成功返回的token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\" : \"Bearer {token}\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "user_id",
            "description": "<p>当前用户id</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "type",
            "description": "<p>赞类型 video_info或者tweet</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "source_id",
            "description": "<p>视频或者动弹的id</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"赞成功\",\n    \"result\": {\n        \"type\": \"add\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 400,\n      \"message\": \"赞操作失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/LikeRecordController.php",
    "groupTitle": "LikeRecord",
    "name": "PostAddorcancellikerecordApi"
  },
  {
    "type": "get",
    "url": "/getMessageList.api",
    "title": "获取消息列表",
    "description": "<p>获取个人消息列表,包括at和回复</p>",
    "group": "Message",
    "permission": [
      {
        "name": "Token"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>登录成功返回的token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\" : \"Bearer {token}\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"获取消息列表成功\",\n    \"result\": {\n        \"pageInfo\": {\n            \"total\": 2,\n            \"currentPage\": 1\n        },\n        \"data\": [\n            {\n            \"byUser\": {\n                \"id\": 10000,\n                \"nickname\": \"管理员\",\n                \"avatar\": \"http://www.english.com/uploads/user/avatar/db2b62230870b0d8506f4c106b80693b.jpg\",\n                \"sex\": 1\n            },\n            \"toUser\": {\n                \"id\": 10001,\n                \"nickname\": \"王麻子\",\n                \"avatar\": \"http://www.english.com/uploads/user/default/avatar.jpg\",\n                \"sex\": 0\n            },\n            \"id\": 5,\n            \"messageType\": \"at\",\n            \"type\": \"tweet\",\n            \"sourceId\": 11,\n            \"content\": \"@王麻子 @李二狗 测试结果[怒]\",\n            \"looked\": 0,\n            \"publishTime\": \"1471920464\",\n            \"sourceContent\": \"王麻子:@王麻子 @李二狗 测试结果[怒]\"\n            },\n            {\n            \"byUser\": {\n                \"id\": 10000,\n                \"nickname\": \"管理员\",\n                \"avatar\": \"http://www.english.com/uploads/user/avatar/db2b62230870b0d8506f4c106b80693b.jpg\",\n                \"sex\": 1\n            },\n            \"toUser\": {\n                \"id\": 10001,\n                \"nickname\": \"王麻子\",\n                \"avatar\": \"http://www.english.com/uploads/user/default/avatar.jpg\",\n                \"sex\": 0\n            },\n            \"id\": 2,\n            \"messageType\": \"comment\",\n            \"type\": \"tweet\",\n            \"sourceId\": 3,\n            \"content\": \"我们一起努力加油[怒][怒]\",\n            \"looked\": 0,\n            \"publishTime\": \"1471919753\",\n            \"sourceContent\": \"王麻子:我也来测试一发，这是管理员的照片！[偷笑][偷笑][偷笑]\"\n            }\n        ]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 400,\n      \"message\": \"获取消息列表失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/MessageRecordController.php",
    "groupTitle": "Message",
    "name": "GetGetmessagelistApi"
  },
  {
    "type": "get",
    "url": "/getUnlookedMessageCount.api",
    "title": "获取未读消息数量",
    "description": "<p>获取未读消息数量</p>",
    "group": "Message",
    "permission": [
      {
        "name": "Token"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>登录成功返回的token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\" : \"Bearer {token}\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "user_id",
            "description": "<p>用户id</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"获取消息数量成功\",\n    \"result\": {\n\n     }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 400,\n      \"message\": \"获取消息数量失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/MessageRecordController.php",
    "groupTitle": "Message",
    "name": "GetGetunlookedmessagecountApi"
  },
  {
    "type": "post",
    "url": "/clearUnlookedMessage.api",
    "title": "清空未读消息",
    "description": "<p>清空未读消息记录</p>",
    "group": "Message",
    "permission": [
      {
        "name": "Token"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>登录成功返回的token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\" : \"Bearer {token}\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "user_id",
            "description": "<p>用户id</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"清空未读消息成功\",\n    \"result\": null\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 400,\n      \"message\": \"清空未读消息失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/MessageRecordController.php",
    "groupTitle": "Message",
    "name": "PostClearunlookedmessageApi"
  },
  {
    "type": "get",
    "url": "/getTweetsDetail.api",
    "title": "动弹详情",
    "description": "<p>获取动弹详情,获取动弹赞列表、评论列表是其他接口</p>",
    "group": "Tweet",
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
            "field": "tweet_id",
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
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"查询动弹详情成功\",\n    \"result\": {\n        \"id\": 1,\n        \"appClient\": 0,\n        \"content\": \"[害羞]这是一条测试数据啊，你别看错了啊，这是一条测试数据。这是一条测试数据啊。\",\n        \"commentCount\": 0,\n        \"likeCount\": 0,\n        \"liked\": 0,\n        \"publishTime\": \"1471576204\",\n        \"author\": {\n            \"id\": 10000,\n            \"nickname\": \"管理员\",\n            \"avatar\": \"http://www.english.com/uploads/user/avatar/9f4ed11179f6962bd57cf9635474446b.jpg\"\n        },\n        \"images\": [\n            {\n                \"href\": \"http://www.english.com/uploads/tweets/2016-08-19/d1c632b1b01a665e09665d53ba2a18f9.jpg\",\n                \"thumb\": \"http://www.english.com/uploads/tweets/2016-08-19/d1c632b1b01a665e09665d53ba2a18f9_thumb.jpg\"\n            }\n        ]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n    \"status\": \"error\",\n    \"code\": 400,\n    \"message\": \"tweet_id不能为空\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/TweetsController.php",
    "groupTitle": "Tweet",
    "name": "GetGettweetsdetailApi"
  },
  {
    "type": "get",
    "url": "/getTweetsList.api",
    "title": "动弹列表",
    "description": "<p>获取动弹列表,可根据参数返回不同的数据</p>",
    "group": "Tweet",
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
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"查询动弹列表成功\",\n    \"result\": {\n        \"pageInfo\": {\n            \"total\": 8,\n            \"currentPage\": 1\n        },\n        \"data\": [\n            {\n            \"id\": 8,\n            \"appClient\": 0,\n            \"content\": \"[可爱][可爱]\",\n            \"commentCount\": 0,\n            \"likeCount\": 1,\n            \"liked\": 0,\n            \"publishTime\": \"1471687444\",\n            \"author\": {\n                \"id\": 10000,\n                \"nickname\": \"管理员\",\n                \"avatar\": \"http://www.english.com/uploads/user/avatar/9f4ed11179f6962bd57cf9635474446b.jpg\"\n            },\n            \"images\": [\n                {\n                    \"href\": \"http://www.english.com/uploads/tweets/2016-08-20/acc95cb2adb4efbf9837dfdd74681571.jpg\",\n                    \"thumb\": \"http://www.english.com/uploads/tweets/2016-08-20/acc95cb2adb4efbf9837dfdd74681571_thumb.jpg\"\n                }\n            ]\n            },\n            {\n            \"id\": 7,\n            \"appClient\": 0,\n            \"content\": \"三张\",\n            \"commentCount\": 1,\n            \"likeCount\": 1,\n            \"liked\": 0,\n            \"publishTime\": \"1471576544\",\n            \"author\": {\n                \"id\": 10000,\n                \"nickname\": \"管理员\",\n                \"avatar\": \"http://www.english.com/uploads/user/avatar/9f4ed11179f6962bd57cf9635474446b.jpg\"\n            },\n            \"images\": [\n                {\n                    \"href\": \"http://www.english.com/uploads/tweets/2016-08-19/e1e7ec0fe33ee7290f90337bf94cad1a.jpg\",\n                    \"thumb\": \"http://www.english.com/uploads/tweets/2016-08-19/e1e7ec0fe33ee7290f90337bf94cad1a_thumb.jpg\"\n                },\n                {\n                    \"href\": \"http://www.english.com/uploads/tweets/2016-08-19/cbe5cf86c5138f520fc6cec43ec5fa0b.jpg\",\n                    \"thumb\": \"http://www.english.com/uploads/tweets/2016-08-19/cbe5cf86c5138f520fc6cec43ec5fa0b_thumb.jpg\"\n                },\n                {\n                    \"href\": \"http://www.english.com/uploads/tweets/2016-08-19/faf969467dea3ddf1dcd403852a3d68e.jpg\",\n                    \"thumb\": \"http://www.english.com/uploads/tweets/2016-08-19/faf969467dea3ddf1dcd403852a3d68e_thumb.jpg\"\n                }\n            ]\n            }\n        ]\n    }\n}",
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
    "filename": "app/Http/Controllers/Api/TweetsController.php",
    "groupTitle": "Tweet",
    "name": "GetGettweetslistApi"
  },
  {
    "type": "post",
    "url": "/postTweets.api",
    "title": "发布动弹",
    "description": "<p>发布一条新的动弹</p>",
    "group": "Tweet",
    "permission": [
      {
        "name": "Token"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>登录成功返回的token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\" : \"Bearer {token}\"\n}",
          "type": "json"
        }
      ]
    },
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
            "type": "JSON",
            "optional": true,
            "field": "photos",
            "description": "<p>['base64'] 动弹配图,base64编码的图片数组</p>"
          },
          {
            "group": "Parameter",
            "type": "JSON",
            "optional": true,
            "field": "atUsers",
            "description": "<p>[{'id':'10000','nickname':'管理员'}] 被at的用户</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "app_client",
            "description": "<p>客户端类型 0iOS 1Android</p>"
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
    "filename": "app/Http/Controllers/Api/TweetsController.php",
    "groupTitle": "Tweet",
    "name": "PostPosttweetsApi"
  },
  {
    "type": "get",
    "url": "/getOtherUserInfomation.api",
    "title": "他人用户信息",
    "description": "<p>获取他人的用户信息</p>",
    "group": "User",
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
            "description": "<p>当前登录的用户id</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "other_user_id",
            "description": "<p>需要用户信息的用户id</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"获取用户信息成功\",\n    \"result\": {\n        \"id\": 10000,\n        \"nickname\": \"管理员\",\n        \"say\": \"Hello world!\",\n        \"avatar\": \"http://www.english.com/uploads/user/avatar/9f4ed11179f6962bd57cf9635474446b.jpg\",\n        \"sex\": 1,\n        \"followersCount\": 32,\n        \"followingCount\": 2,\n        \"registerTime\": \"1471437181\",\n        \"lastLoginTime\": \"1471715751\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 400,\n      \"message\": \"获取用户信息失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "User",
    "name": "GetGetotheruserinfomationApi"
  },
  {
    "type": "get",
    "url": "/getUserInfomation.api",
    "title": "自己用户信息",
    "description": "<p>获取自己的用户信息</p>",
    "group": "User",
    "permission": [
      {
        "name": "Token"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>登录成功返回的token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\" : \"Bearer {token}\"\n}",
          "type": "json"
        }
      ]
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "user_id",
            "description": "<p>用户id</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"获取用户信息成功\",\n    \"result\": {\n        \"id\": 10000,\n        \"nickname\": \"管理员\",\n        \"say\": \"Hello world!\",\n        \"avatar\": \"http://www.english.com/uploads/user/avatar/9f4ed11179f6962bd57cf9635474446b.jpg\",\n        \"mobile\": \"15626427299\",\n        \"email\": \"admin@6ag.cn\",\n        \"sex\": 1,\n        \"qqBinding\": 0,\n        \"weixinBinding\": 0,\n        \"weiboBinding\": 0,\n        \"emailBinding\": 1,\n        \"mobileBinding\": 1,\n        \"followersCount\": 32,\n        \"followingCount\": 2,\n        \"registerTime\": \"1471437181\",\n        \"lastLoginTime\": \"1471715751\"\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 400,\n      \"message\": \"获取用户信息失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "User",
    "name": "GetGetuserinfomationApi"
  },
  {
    "type": "post",
    "url": "/postFeedback.api",
    "title": "意见反馈",
    "description": "<p>提交意见反馈信息</p>",
    "group": "User",
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
            "field": "contact",
            "description": "<p>联系方式</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "content",
            "description": "<p>反馈内容</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"提交反馈信息成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 400,\n      \"message\": \"contact不能为空\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/FeedbackController.php",
    "groupTitle": "User",
    "name": "PostPostfeedbackApi"
  },
  {
    "type": "post",
    "url": "/updateUserInfomation.api",
    "title": "更新用户信息",
    "description": "<p>更新用户信息</p>",
    "group": "User",
    "permission": [
      {
        "name": "Token"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>登录成功返回的token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\" : \"Bearer {token}\"\n}",
          "type": "json"
        }
      ]
    },
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
            "optional": true,
            "field": "nickname",
            "description": "<p>昵称</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "sex",
            "description": "<p>0女 1男</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "say",
            "description": "<p>个性签名</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"更新用户信息成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 400,\n      \"message\": \"更新用户信息失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "User",
    "name": "PostUpdateuserinfomationApi"
  },
  {
    "type": "post",
    "url": "/uploadUserAvatar.api",
    "title": "上传用户头像",
    "description": "<p>上传用户头像</p>",
    "group": "User",
    "permission": [
      {
        "name": "Token"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>登录成功返回的token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\" : \"Bearer {token}\"\n}",
          "type": "json"
        }
      ]
    },
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
            "field": "photo",
            "description": "<p>base64编码的图片</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"上传头像成功\",\n    \"data\": null\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 400,\n      \"message\": \"上传头像失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/UserController.php",
    "groupTitle": "User",
    "name": "PostUploaduseravatarApi"
  },
  {
    "type": "get",
    "url": "/getVideoDownloadList.api",
    "title": "视频下载地址",
    "description": "<p>根据url/id解析flv视频列表,可供分段下载 ffmpeg合成</p>",
    "group": "Video",
    "permission": [
      {
        "name": "Token"
      }
    ],
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "token",
            "description": "<p>登录成功返回的token</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Header-Example:",
          "content": "{\n    \"Authorization\" : \"Bearer {token}\"\n}",
          "type": "json"
        }
      ]
    },
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
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"解析视频地址成功\",\n    \"result\": {\n        \"normal\": {\n            \"count\": \"3\",\n            \"data\": [\n                \"http://k.youku.com/player/getFlvPath/sid/347183583803712c9019d_00/st/flv/fileid/.........\",\n                \"http://k.youku.com/player/getFlvPath/sid/347183583803712c9019d_01/st/flv/fileid/.........\",\n                \"http://k.youku.com/player/getFlvPath/sid/347183583803712c9019d_02/st/flv/fileid/.........\"\n            ]\n        },\n        \"high\": {\n            \"count\": \"2\",\n            \"data\": [\n                \"http://k.youku.com/player/getFlvPath/sid/347183583803712c9019d_00/st/mp4/fileid/.........\",\n                \"http://k.youku.com/player/getFlvPath/sid/347183583803712c9019d_01/st/mp4/fileid/.........\"\n            ]\n        },\n        \"hyper\": {\n            \"count\": \"4\",\n            \"data\": [\n                \"http://k.youku.com/player/getFlvPath/sid/347183583803712c9019d_00/st/flv/fileid/.........\",\n                \"http://k.youku.com/player/getFlvPath/sid/347183583803712c9019d_01/st/flv/fileid/.........\",\n                \"http://k.youku.com/player/getFlvPath/sid/347183583803712c9019d_02/st/flv/fileid/.........\",\n                \"http://k.youku.com/player/getFlvPath/sid/347183583803712c9019d_03/st/flv/fileid/.........\"\n            ]\n        }\n    }\n}",
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
    "filename": "app/Http/Controllers/Api/VideoController.php",
    "groupTitle": "Video",
    "name": "GetGetvideodownloadlistApi"
  },
  {
    "type": "get",
    "url": "/getVideoInfoDetail.api",
    "title": "视频信息详情",
    "description": "<p>根据分类id查询视频信息列表</p>",
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
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "user_id",
            "description": "<p>当前用户id 未登录不传或者传0</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"查询视频信息详情成功\",\n    \"result\": {\n           \"id\": 13,\n            \"title\": \"零基础学习英语音标视频教程\",\n            \"cover\": \"http://www.english.com/uploads/video-info/74ceb292408d6718cb818293b039c5e2.jpg\",\n            \"view\": 39,\n            \"teacherName\": \"Nickcen\",\n            \"videoType\": \"youku\",\n            \"recommended\": 0,\n            \"collected\": 0,\n            \"videoCount\": 21,\n            \"commentCount\": 0,\n            \"collectionCount\": 0\n     }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 404,\n      \"message\": \"查询视频信息详情失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/VideoController.php",
    "groupTitle": "Video",
    "name": "GetGetvideoinfodetailApi"
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
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"查询视频播放列表成功\",\n    \"result\": [\n        {\n            \"id\": 161,\n            \"title\": \"郝彬音标超级训练第01课\",\n            \"videoInfoId\": 7,\n            \"videoUrl\": \"http://v.youku.com/v_show/id_XMTczNDQyOTY4.html\",\n            \"order\": 1\n        },\n        {\n            \"id\": 162,\n            \"title\": \"郝彬音标超级训练第02课\",\n            \"videoInfoId\": 7,\n            \"videoUrl\": \"http://v.youku.com/v_show/id_XMTczNDQwODU2.html\",\n            \"order\": 2\n        }\n    ]\n}",
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
    "name": "GetGetvideolistApi"
  },
  {
    "type": "get",
    "url": "/playVideo.api",
    "title": "视频真实地址",
    "description": "<p>传入URL,返回m3u8列表可直接播放</p>",
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
            "description": "<p>视频地址 http://v.youku.com/v_show/id_XOTA5NjIyMTIw.html</p>"
          }
        ]
      }
    },
    "version": "0.0.1",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "#EXTM3U\n#EXT-X-TARGETDURATION:12\n#EXT-X-VERSION:3\n#EXTINF:6.0,\n......\n#EXT-X-ENDLIST",
          "type": "m3u8"
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
    "filename": "app/Http/Controllers/Api/VideoController.php",
    "groupTitle": "Video",
    "name": "GetPlayvideoApi"
  },
  {
    "type": "get",
    "url": "/searchVideoInfoList.api",
    "title": "搜索视频信息列表",
    "description": "<p>搜索视频信息列表</p>",
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
            "field": "keyword",
            "description": "<p>搜索关键词</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "user_id",
            "description": "<p>当前用户id 未登录不传或者传0</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
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
          "content": "{\n    \"status\": \"success\",\n    \"code\": 200,\n    \"message\": \"搜索视频信息列表成功\",\n    \"result\": {\n        \"pageInfo\": {\n            \"total\": 13,\n            \"currentPage\": 1\n        },\n        \"data\": [\n            {\n                \"id\": 13,\n                \"title\": \"零基础学习英语音标视频教程\",\n                \"cover\": \"http://www.english.com/uploads/video-info/74ceb292408d6718cb818293b039c5e2.jpg\",\n                \"view\": 39,\n                \"teacherName\": \"Nickcen\",\n                \"videoType\": \"youku\",\n                \"recommended\": 0,\n                \"collected\": 0,\n                \"videoCount\": 21,\n                \"commentCount\": 0,\n                \"collectionCount\": 0\n            },\n            {\n                \"id\": 12,\n                \"title\": \"48个国际音标发音视频教程全集\",\n                \"cover\": \"http://www.english.com/uploads/video-info/f05d2843f5ecf9ec9448c98a9e6bbe80.jpg\",\n                \"view\": 17,\n                \"teacherName\": \"佚名\",\n                \"videoType\": \"youku\",\n                \"recommended\": 0,\n                \"collected\": 0,\n                \"videoCount\": 21,\n                \"commentCount\": 0,\n                \"collectionCount\": 0\n            }\n        ]\n    }\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n      \"status\": \"error\",\n      \"code\": 404,\n      \"message\": \"搜索视频信息列表失败\"\n }",
          "type": "json"
        }
      ]
    },
    "filename": "app/Http/Controllers/Api/VideoController.php",
    "groupTitle": "Video",
    "name": "GetSearchvideoinfolistApi"
  }
] });
