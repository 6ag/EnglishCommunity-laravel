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
     * @api {get} /getVideoList.api 视频播放列表
     * @apiDescription 根据视频信息id查询视频播放列表
     * @apiGroup Video
     * @apiPermission none
     * @apiParam {Number} video_info_id  视频信息id
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "查询视频播放列表失败"
     *      }
     */
    public function getVideoList(Request $request)
    {
        $videoInfo = VideoInfo::find($request->video_info_id);
        if (! isset($videoInfo)) {
            return $this->respondWithErrors('video_info_id不存在', 400);
        }

        // 视频浏览量自增1
        $videoInfo->increment('view');
        $videos = Video::where('video_info_id', $videoInfo->id)->get();

        $result = null;
        foreach ($videos as $key => $video) {
            $result[$key]['id'] = $video->id;
            $result[$key]['title'] = $video->title;
            $result[$key]['videoInfoId'] = $video->video_info_id;
            $result[$key]['videoUrl'] = $video->video_url;
            $result[$key]['order'] = $video->order;
        }

        return $this->respondWithSuccess($result, '查询视频播放列表成功');
    }
    
    /**
     * @api {get} /parseYouku1.api 解析优酷视频1
     * @apiDescription 根据url/id解析flv视频列表,可供分段下载 ffmpeg合成
     * @apiGroup Video
     * @apiPermission none
     * @apiParam {String} url 视频地址
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "解析视频地址失败"
     *      }
     */
    public function parseYouku1(Request $request)
    {
        $data = ParseVideo::parseYouku1($request->url);
        if (count($data)) {
            return $this->respondWithSuccess($data, '解析视频地址成功');
        } else {
            return $this->respondWithErrors('解析视频地址失败,已经放弃治疗', 500);
        }
    }

}
