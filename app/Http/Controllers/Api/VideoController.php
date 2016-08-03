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
    
    /**
     * @api {get} /parse1 解析优酷视频1
     * @apiDescription 根据url/id解析flv视频列表,可供分段下载
     * @apiGroup Video
     * @apiPermission none
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "解析视频地址成功",
     *           "data": {
     *               "normal": {
     *                   "count": "2",
     *                   "data": [
     *                       "http://k.youku.com/player/getFlvPath/sid/847022969297012c1d9f3_00/st/flv/fileid/030002020057A01079076B31F0446F4CC58682-901F-3DB9-6F28-0B6148C748B7?K=a506ff12854c8ebe282b9f1b&ctype=12&ev=1&token=3704&oip=3549804647&ep=eiaTGkuPX8gJ5yrYiD8bNC22fSEMXP4J9h%2BFg9JgALshT5m%2FmD7Wzp23SI1BF48ZdiYAZu%2BC2NXvbEgWYflDqB4Q3DraMPrmiPLr5a0hwpEEbmoxdsWls1SdRDD1&ymovie=1",
     *                       "http://k.youku.com/player/getFlvPath/sid/847022969297012c1d9f3_01/st/flv/fileid/030002020157A01079076B31F0446F4CC58682-901F-3DB9-6F28-0B6148C748B7?K=32258eefe0579806261f2881&ctype=12&ev=1&token=3704&oip=3549804647&ep=eiaTGkuPX8gJ5yrYiD8bNC22fSEMXP4J9h%2BFg9JgALohT5m%2FmD7Wzp23SI1BF48ZdiYAZu%2BC2NXvbEgWYflDqB4Q3DraMPrmiPLr5a0hwpEEbmoxdsWls1SdRDD1&ymovie=1"
     *                   ]
     *               },
     *               "high": {
     *                   "count": "2",
     *                   "data": [
     *                       "http://k.youku.com/player/getFlvPath/sid/847022969297012c1d9f3_00/st/mp4/fileid/030008020057A01347076B31F0446F4CC58682-901F-3DB9-6F28-0B6148C748B7?K=99121930a5baabe32412b1e7&ctype=12&ev=1&token=3704&oip=3549804647&ep=eiaTGkuPX8gJ5yrYiD8bNC22fSEMXP4J9h%2BFidJgALshT5m%2FmD3VwJ23SI1BF48ZdiYAZu%2BC2NXvbEgWYflDqB4Q3DraMPrmiPLr5a0hwpEEbmoxdsWls1SdRDD1",
     *                       "http://k.youku.com/player/getFlvPath/sid/847022969297012c1d9f3_01/st/mp4/fileid/030008020157A01347076B31F0446F4CC58682-901F-3DB9-6F28-0B6148C748B7?K=8aabf523c76432272412b1e7&ctype=12&ev=1&token=3704&oip=3549804647&ep=eiaTGkuPX8gJ5yrYiD8bNC22fSEMXP4J9h%2BFidJgALohT5m%2FmD3VwJ23SI1BF48ZdiYAZu%2BC2NXvbEgWYflDqB4Q3DraMPrmiPLr5a0hwpEEbmoxdsWls1SdRDD1"
     *                   ]
     *               },
     *               "hyper": {
     *                   "count": "3",
     *                   "data": [
     *                       "http://k.youku.com/player/getFlvPath/sid/847022969297012c1d9f3_00/st/flv/fileid/030001030057A013C5076B31F0446F4CC58682-901F-3DB9-6F28-0B6148C748B7?K=0926bb69b555efc3261f2881&ctype=12&ev=1&token=3704&oip=3549804647&ep=eiaTGkuPX8gJ5yrYiD8bNC22fSEMXP4J9h%2BFgNJhALshT5m%2FmD2iwp23SI1BF48ZdiYAZu%2BC2NXvbEgWYflDqB4Q3DraMPrmiPLr5a0hwpEEbmoxdsWls1SdRDD1",
     *                       "http://k.youku.com/player/getFlvPath/sid/847022969297012c1d9f3_01/st/flv/fileid/030001030157A013C5076B31F0446F4CC58682-901F-3DB9-6F28-0B6148C748B7?K=53e8c1867c4d32f2261f2881&ctype=12&ev=1&token=3704&oip=3549804647&ep=eiaTGkuPX8gJ5yrYiD8bNC22fSEMXP4J9h%2BFgNJhALohT5m%2FmD2iwp23SI1BF48ZdiYAZu%2BC2NXvbEgWYflDqB4Q3DraMPrmiPLr5a0hwpEEbmoxdsWls1SdRDD1",
     *                       "http://k.youku.com/player/getFlvPath/sid/847022969297012c1d9f3_02/st/flv/fileid/030001030257A013C5076B31F0446F4CC58682-901F-3DB9-6F28-0B6148C748B7?K=e8d08cbef327713e261f2881&ctype=12&ev=1&token=3704&oip=3549804647&ep=eiaTGkuPX8gJ5yrYiD8bNC22fSEMXP4J9h%2BFgNJhALkhT5m%2FmD2iwp23SI1BF48ZdiYAZu%2BC2NXvbEgWYflDqB4Q3DraMPrmiPLr5a0hwpEEbmoxdsWls1SdRDD1"
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
    public function parseYouku1(Request $request)
    {
        $data = ParseVideo::parseYouku1($request->url);
        if (count($data)) {
            return $this->respondWithSuccess($data, '解析视频地址成功');
        } else {
            return $this->respondWithErrors('解析视频地址失败');
        }
    }

    public function parseYouku2(Request $request)
    {

    }
    
    public function parseYouku3(Request $request)
    {

    }
}
