<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Video;
use App\Http\Model\VideoInfo;
use App\Http\ParseVideo;
use Illuminate\Http\Request;

use App\Http\Requests;

class VideoController extends BaseController
{
    /**
     * @api {get} /video/{video} 视频播放列表
     * @apiDescription 根据视频信息id查询视频播放列表
     * @apiGroup Video
     * @apiPermission none
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "查询视频播放列表成功",
     *           "data": [
     *               {
     *                   "id": 137,
     *                   "title": "音标学习",
     *                   "video_info_id": 25,
     *                   "video_url": "http://v.youku.com/v_show/id_XNzg3NTcxMDA=.html",
     *                   "created_at": "2016-08-01 06:22:49",
     *                   "updated_at": "2016-08-01 06:22:49",
     *                   "order": 0
     *               },
     *               {
     *                   "id": 138,
     *                   "title": "语法学习",
     *                   "video_info_id": 25,
     *                   "video_url": "http://v.youku.com/v_show/id_XNzg3NTcxMDA=.html",
     *                   "created_at": "2016-08-01 06:22:49",
     *                   "updated_at": "2016-08-01 06:22:49",
     *                   "order": 1
     *               },
     *               {
     *                   "id": 139,
     *                   "title": "牛逼学习",
     *                   "video_info_id": 25,
     *                   "video_url": "http://v.youku.com/v_show/id_XNzg3NTcxMDA=.html",
     *                   "created_at": "2016-08-01 06:22:49",
     *                   "updated_at": "2016-08-01 06:22:49",
     *                   "order": 2
     *               },
     *               {
     *                   "id": 140,
     *                   "title": "傻逼学习",
     *                   "video_info_id": 25,
     *                   "video_url": "http://v.youku.com/v_show/id_XNzg3NTcxMDA=.html",
     *                   "created_at": "2016-08-01 06:22:49",
     *                   "updated_at": "2016-08-01 06:22:49",
     *                   "order": 3
     *               }
     *           ]
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "查询视频播放列表失败"
     *      }
     */
    public function getVideoList($video_id)
    {
        $videoInfo = VideoInfo::find($video_id);
        if (empty($videoInfo)) {
            return $this->respondWithErrors('查询视频播放列表失败');
        }
        $videos = Video::where('video_info_id', $videoInfo->id)->get();

        return $this->respondWithSuccess($videos, '查询视频播放列表成功');
    }

    public function test()
    {
//        Wallpaper::where('category_id', $category_id)->orderBy('id', 'desc')->paginate(21);
//        $url = 'http://v.youku.com/v_show/id_XMTUwNjQ0NDQ4MA==.html';
//        $data = ParseVideo::parseYouku($url);
//        dd($data);
    }
}