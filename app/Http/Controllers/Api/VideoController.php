<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Video;
use App\Http\Model\VideoInfo;
use App\Http\ParseVideo;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class VideoController extends BaseController
{
    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.api.auth', [
            'except' => [
                'getVideoList',
                'playVideo'
            ]
        ]);
    }

    /**
     * @api {get} /getVideoList.api 视频播放列表
     * @apiDescription 根据视频信息id查询视频播放列表
     * @apiGroup Video
     * @apiPermission none
     * @apiParam {Number} video_info_id  视频信息id
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "查询视频播放列表成功",
     *           "result": [
     *               {
     *                   "id": 161,
     *                   "title": "郝彬音标超级训练第01课",
     *                   "videoInfoId": 7,
     *                   "videoUrl": "http://v.youku.com/v_show/id_XMTczNDQyOTY4.html",
     *                   "order": 1
     *               },
     *               {
     *                   "id": 162,
     *                   "title": "郝彬音标超级训练第02课",
     *                   "videoInfoId": 7,
     *                   "videoUrl": "http://v.youku.com/v_show/id_XMTczNDQwODU2.html",
     *                   "order": 2
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
    public function getVideoList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video_info_id' => ['required', 'exists:video_infos,id']
        ], [
            'video_info_id.required' => 'video_info_id不能为空',
            'video_info_id.exists' => '视频信息不存在'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        $videoInfo = VideoInfo::find($request->video_info_id);
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
     * @api {get} /playVideo.api 视频真实地址
     * @apiDescription 传入URL,返回m3u8列表可直接播放
     * @apiGroup Video
     * @apiPermission none
     * @apiParam {String} url 视频地址 http://v.youku.com/v_show/id_XOTA5NjIyMTIw.html
     * @apiVersion 0.0.1
     * @apiSuccessExample {m3u8} Success-Response:
     *       #EXTM3U
     *       #EXT-X-TARGETDURATION:12
     *       #EXT-X-VERSION:3
     *       #EXTINF:6.0,
     *       ......
     *       #EXT-X-ENDLIST
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "解析视频地址失败"
     *      }
     */
    public function playVideo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => ['required']
        ], [
            'url.required' => 'urlbunweik'
        ]);
        if ($validator->fails()) {
            return $this->respondWithSuccess($validator);
        }

        $parseVideo = new ParseVideo();
        return $this->respondWithSuccess([
            'videoUrl' => $parseVideo->getYoukuM3u8($request->url)
        ], '解析播放地址成功');
    }
    
    /**
     * @api {get} /getVideoDownloadList.api 视频下载地址
     * @apiDescription 根据url/id解析flv视频列表,可供分段下载 ffmpeg合成
     * @apiGroup Video
     * @apiPermission Token
     * @apiHeader {String} token 登录成功返回的token
     * @apiHeaderExample {json} Header-Example:
     *      {
     *          "Authorization" : "Bearer {token}"
     *      }
     * @apiParam {String} url 视频地址
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "解析视频地址成功",
     *           "result": {
     *               "normal": {
     *                   "count": "3",
     *                   "data": [
     *                       "http://k.youku.com/player/getFlvPath/sid/347183583803712c9019d_00/st/flv/fileid/.........",
     *                       "http://k.youku.com/player/getFlvPath/sid/347183583803712c9019d_01/st/flv/fileid/.........",
     *                       "http://k.youku.com/player/getFlvPath/sid/347183583803712c9019d_02/st/flv/fileid/........."
     *                   ]
     *               },
     *               "high": {
     *                   "count": "2",
     *                   "data": [
     *                       "http://k.youku.com/player/getFlvPath/sid/347183583803712c9019d_00/st/mp4/fileid/.........",
     *                       "http://k.youku.com/player/getFlvPath/sid/347183583803712c9019d_01/st/mp4/fileid/........."
     *                   ]
     *               },
     *               "hyper": {
     *                   "count": "4",
     *                   "data": [
     *                       "http://k.youku.com/player/getFlvPath/sid/347183583803712c9019d_00/st/flv/fileid/.........",
     *                       "http://k.youku.com/player/getFlvPath/sid/347183583803712c9019d_01/st/flv/fileid/.........",
     *                       "http://k.youku.com/player/getFlvPath/sid/347183583803712c9019d_02/st/flv/fileid/.........",
     *                       "http://k.youku.com/player/getFlvPath/sid/347183583803712c9019d_03/st/flv/fileid/........."
     *                   ]
     *               }
     *           }
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "解析视频地址失败"
     *      }
     */
    public function getVideoDownloadList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => ['required']
        ], [
            'url.required' => 'url不能为空'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        $parseVideo = new ParseVideo();
        $data = $parseVideo->getVideoDownloadList($request->url);
        if (count($data)) {
            return $this->respondWithSuccess($data, '解析视频地址成功');
        } else {
            return $this->respondWithErrors('解析视频地址失败,已经放弃治疗', 500);
        }
    }

}
