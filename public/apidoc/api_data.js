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
    "filename": "app/Http/Api/AuthenticateController.php",
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
    "filename": "app/Http/Api/AuthenticateController.php",
    "groupTitle": "Auth",
    "name": "PostAuthRegister"
  }
] });
