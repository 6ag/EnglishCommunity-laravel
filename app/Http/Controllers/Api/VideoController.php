<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Collection;
use App\Http\Model\Comment;
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
                'playVideo',
                'getVideoInfoDetail',
                'searchVideoInfoList'
            ]
        ]);
    }

    /**
     * @api {get} /getVideoInfoDetail.api 视频信息详情
     * @apiDescription 根据分类id查询视频信息列表
     * @apiGroup Video
     * @apiPermission none
     * @apiParam {Number} video_info_id  视频信息id
     * @apiParam {Number} [user_id] 当前用户id 未登录不传或者传0
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "查询视频信息详情成功",
     *           "result": {
     *                  "id": 13,
     *                   "title": "零基础学习英语音标视频教程",
     *                   "cover": "http://www.english.com/uploads/video-info/74ceb292408d6718cb818293b039c5e2.jpg",
     *                   "view": 39,
     *                   "teacherName": "Nickcen",
     *                   "videoType": "youku",
     *                   "recommended": 0,
     *                   "collected": 0,
     *                   "videoCount": 21,
     *                   "commentCount": 0,
     *                   "collectionCount": 0
     *            }
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "查询视频信息详情失败"
     *      }
     */
    public function getVideoInfoDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video_info_id' => ['required', 'exists:video_infos,id'],
        ], [
            'video_info_id.required' => 'video_info_id不能为空',
            'video_info_id.exists' => '视频信息不存在'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // user_id默认为0
        $user_id = isset($request->user_id) ? $request->user_id : 0;

        // 只读一次到内存,节省资源
        $comments = Comment::where('type', 'video_info')->get();
        $collections = Collection::all();

        $videoInfo = VideoInfo::find($request->video_info_id);
        $collection = Collection::where('user_id', $user_id)->where('video_info_id', $videoInfo->id)->first();
        $result['id'] = $videoInfo->id;
        $result['title'] = $videoInfo->title;
        $result['cover'] = url($videoInfo->photo);
        $result['view'] = $videoInfo->view;
        $result['teacherName'] = $videoInfo->teacher;
        $result['videoType'] = $videoInfo->type;
        $result['recommended'] = $videoInfo->recommend;
        $result['collected'] = isset($collection) ? 1 : 0;
        $result['videoCount'] = Video::where('video_info_id', $videoInfo->id)->count();
        $result['commentCount'] = $comments->where('source_id', $videoInfo->id)->count();
        $result['collectionCount'] = $collections->where('source_id', $videoInfo->id)->count();

        return $this->respondWithSuccess($result, '查询指定分类视频列表成功');

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
            'url.required' => 'url不能为空'
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

    /**
     * @api {get} /searchVideoInfoList.api 搜索视频信息列表
     * @apiDescription 搜索视频信息列表
     * @apiGroup Video
     * @apiPermission none
     * @apiParam {String} keyword 搜索关键词
     * @apiParam {Number} [user_id] 当前用户id 未登录不传或者传0
     * @apiParam {Number} [page] 页码
     * @apiParam {Number} [count] 每页数量,默认10条
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "搜索视频信息列表成功",
     *           "result": {
     *               "pageInfo": {
     *                   "total": 13,
     *                   "currentPage": 1
     *               },
     *               "data": [
     *                   {
     *                       "id": 13,
     *                       "title": "零基础学习英语音标视频教程",
     *                       "cover": "http://www.english.com/uploads/video-info/74ceb292408d6718cb818293b039c5e2.jpg",
     *                       "view": 39,
     *                       "teacherName": "Nickcen",
     *                       "videoType": "youku",
     *                       "recommended": 0,
     *                       "collected": 0,
     *                       "videoCount": 21,
     *                       "commentCount": 0,
     *                       "collectionCount": 0
     *                   },
     *                   {
     *                       "id": 12,
     *                       "title": "48个国际音标发音视频教程全集",
     *                       "cover": "http://www.english.com/uploads/video-info/f05d2843f5ecf9ec9448c98a9e6bbe80.jpg",
     *                       "view": 17,
     *                       "teacherName": "佚名",
     *                       "videoType": "youku",
     *                       "recommended": 0,
     *                       "collected": 0,
     *                       "videoCount": 21,
     *                       "commentCount": 0,
     *                       "collectionCount": 0
     *                   }
     *               ]
     *           }
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "搜索视频信息列表失败"
     *      }
     */
    public function searchVideoInfoList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keyword' => ['required']
        ], [
            'keyword.required' => '搜索关键词不能为空'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // user_id默认为0
        $user_id = isset($request->user_id) ? $request->user_id : 0;

        $videoInfos = VideoInfo::where('title','like','%'.$request->keyword.'%')->orderBy('id', 'desc')->paginate(isset($request->count) ? $request->count : 10);
        if (! count($videoInfos)) {
            return $this->respondWithErrors('未搜索到任何数据');
        }

        // 只读一次到内存,节省资源
        $comments = Comment::where('type', 'video_info')->get();
        $collections = Collection::all();

        $result = null;
        $data = $videoInfos->all();
        foreach ($data as $key => $videoInfo) {
            $collection = Collection::where('user_id', $user_id)->where('video_info_id', $videoInfo->id)->first();
            $result[$key]['id'] = $videoInfo->id;
            $result[$key]['title'] = $videoInfo->title;
            $result[$key]['cover'] = url($videoInfo->photo);
            $result[$key]['view'] = $videoInfo->view;
            $result[$key]['teacherName'] = $videoInfo->teacher;
            $result[$key]['videoType'] = $videoInfo->type;
            $result[$key]['recommended'] = $videoInfo->recommend;
            $result[$key]['collected'] = isset($collection) ? 1 : 0;
            $result[$key]['videoCount'] = Video::where('video_info_id', $videoInfo->id)->count();
            $result[$key]['commentCount'] = $comments->where('source_id', $videoInfo->id)->count();
            $result[$key]['collectionCount'] = $collections->where('source_id', $videoInfo->id)->count();
        }

        return $this->respondWithSuccess([
            'pageInfo' => [
                'total' => $videoInfos->total(),
                'currentPage' => $videoInfos->currentPage(),
            ],
            'data' => $result
        ], '搜索视频信息列表成功');

    }

}
