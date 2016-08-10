<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;

class CommentController extends BaseController
{
    /**
     * @api {get} /postComment.api 发布评论
     * @apiDescription 发布或者回复一条评论
     * @apiGroup Comment
     * @apiPermission none
     * @apiParam {Number} user_id 用户id
     * @apiParam {String} type 类型:trends/video
     * @apiParam {Number} source_id 动弹或视频信息的id
     * @apiParam {String} content 评论内容
     * @apiParam {Number} [pid] 默认0,评论当前主题.为其他评论id则是回复评论
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "发布评论信息成功",
     *           "data": null
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "发布评论信息失败"
     *      }
     */
    public function postComment()
    {
        
    }

    /**
     * @api {get} /getCommentList.api 获取评论列表
     * @apiDescription 获取动弹或视频信息的评论列表
     * @apiGroup Comment
     * @apiPermission none
     * @apiParam {String} type 类型:trends/video
     * @apiParam {Number} source_id 动弹或视频信息的id
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     * {
     *
     * }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 400,
     *           "message": "获取评论列表失败"
     *      }
     */
    public function getCommentList()
    {

    }
}
