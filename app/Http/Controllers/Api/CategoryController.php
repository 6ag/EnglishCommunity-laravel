<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use App\Http\Model\Video;
use App\Http\Model\VideoInfo;

use App\Http\Requests;

class CategoryController extends BaseController
{
    /**
     * @api {get} /category/{category}/video 视频信息列表
     * @apiDescription 根据分类id查询视频信息列表
     * @apiGroup Category
     * @apiPermission none
     * @apiParam {Number} page  页码
     * @apiParam {Number} [count]  每页数量,默认10条
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "查询视频列表成功",
     *           "data": {
     *           "total": 25,
     *           "rows": 2,
     *           "current_page": 1,
     *           "data": [
     *               {
     *                   "id": 25,
     *                   "title": "这是一个测试标题",
     *                   "intro": "这是一些简介这是一些简介这是一些简介",
     *                   "photo": "uploads/2c9337d98f69cd02cbbab4ae0e1cd118.jpg",
     *                   "view": 0,
     *                   "category_id": 3,
     *                   "teacher": "苍老师",
     *                   "type": "youku",
     *                   "created_at": "2016-08-01 05:29:44",
     *                   "updated_at": "2016-08-01 06:22:49"
     *                   },
     *                   {
     *                   "id": 24,
     *                   "title": "这是一个测试标题",
     *                   "intro": "这是一些简介这是一些简介这是一些简介",
     *                   "photo": "uploads/7f32770735063583890994798c4300d3.jpg",
     *                   "view": 0,
     *                   "category_id": 3,
     *                   "teacher": "苍老师",
     *                   "type": "youku",
     *                   "created_at": "2016-08-01 05:29:44",
     *                   "updated_at": "2016-08-01 05:29:44"
     *                   }
     *               ]
     *           }
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "查询视频列表失败"
     *      }
     */
    public function getVideInfosList(Request $request, $category_id)
    {
        // 分类访问量自增 1
        $category = Category::find($category_id);
        $category->increment('view');

        if (empty($category)) {
            return $this->respondWithErrors('查询指定分类视频列表失败');
        }

        $videoInfos = VideoInfo::where('category_id', $category_id)->orderBy('id', 'desc')->paginate($request->count != 0 ?: 10);
        if (!count($videoInfos)) {
            return $this->respondWithErrors('查询指定分类视频列表失败');
        }

        return $this->respondWithSuccess([
            'total' => $videoInfos->total(),
            'rows' => $videoInfos->perPage(),
            'current_page' => $videoInfos->currentPage(),
            'data' => $videoInfos->all()
        ], '查询指定分类视频列表成功');

    }

    /**
     * @api {get} /category 分类列表
     * @apiDescription 获取所有分类信息
     * @apiGroup Category
     * @apiPermission none
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "查询分类列表成功",
     *           "data": [
     *               {
     *                   "id": 1,
     *                   "name": "音标",
     *                   "view": 0,
     *                   "pid": 0
     *               },
     *               {
     *                   "id": 2,
     *                   "name": "单词",
     *                   "view": 0,
     *                   "pid": 0
     *               },
     *               {
     *                   "id": 3,
     *                   "name": "语法",
     *                   "view": 4,
     *                   "pid": 0
     *               },
     *               {
     *                   "id": 4,
     *                   "name": "口语",
     *                   "view": 0,
     *                   "pid": 0
     *               },
     *               {
     *                   "id": 5,
     *                   "name": "听力",
     *                   "view": 0,
     *                   "pid": 0
     *               }
     *           ]
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "查询分类列表失败"
     *      }
     */
    public function getCategoryies()
    {
        $categories = Category::orderBy('order', 'asc')->get(['id', 'name', 'view', 'pid']);
        if (empty($categories)) {
            return $this->respondWithErrors('查询分类列表失败');
        }

        return $this->respondWithSuccess($categories, '查询分类列表成功');
    }

}
