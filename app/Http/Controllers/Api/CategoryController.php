<?php

namespace App\Http\Controllers\Api;

use App\Http\Model\Category;
use App\Http\Model\Collection;
use App\Http\Model\Comment;
use Illuminate\Http\Request;
use App\Http\Model\Video;
use App\Http\Model\VideoInfo;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{
    public function __construct()
    {
        // 执行 jwt.auth 认证
        $this->middleware('jwt.api.auth', [
            'except' => [
                'getVideoInfosList',
                'getCategoryies',
            ]
        ]);
    }
    
    /**
     * @api {get} /getVideoInfosList.api 视频信息列表
     * @apiDescription 根据分类id查询视频信息列表
     * @apiGroup Category
     * @apiPermission none
     * @apiParam {Number} category_id  分类id
     * @apiParam {Number} [user_id] 当前用户id 未登录不传或者传0
     * @apiParam {Number} [page]  页码
     * @apiParam {Number} [count]  每页数量,默认10条
     * @apiParam {Number} [recommend]  是否返回推荐的视频 1是 0否
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *           "status": "success",
     *           "code": 200,
     *           "message": "查询指定分类视频列表成功",
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
     *           "message": "查询视频列表失败"
     *      }
     */
    public function getVideoInfosList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => ['required'],
            'recommend' => ['in:0,1']
        ], [
            'category_id.required' => 'category_id不能为空',
            'recommend.in' => 'recommend只能传0、1'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        // user_id默认为0
        $user_id = isset($request->user_id) ? $request->user_id : 0;

        $videoInfos = null;
        if ($request->category_id == 0) {
            // 分类id为0则查询所有分类
            $videoInfos = VideoInfo::where('recommend', '>=', (isset($request->recommend) && $request->recommend == 1) ? 1 : 0)
                ->orderBy('id', 'desc')
                ->paginate(isset($request->count) ? $request->count : 10);
            if (! count($videoInfos)) {
                return $this->respondWithErrors('没有查到视频信息');
            }
        } else {
            // 否则查询指定分类
            $category = Category::find($request->category_id);
            $category->increment('view');
            if (! isset($category)) {
                return $this->respondWithErrors('category_id错误', 400);
            }
            $videoInfos = VideoInfo::where('category_id', $request->category_id)
                ->where('recommend', '>=', (isset($request->recommend) && $request->recommend == 1) ? 1 : 0)
                ->orderBy('id', 'desc')
                ->paginate(isset($request->count) ? $request->count : 10);
            if (! count($videoInfos)) {
                return $this->respondWithErrors('没有查到视频信息');
            }
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
        ], '查询指定分类视频列表成功');

    }

    /**
     * @api {get} /getAllCategories.api 所有分类信息
     * @apiDescription 获取所有分类信息
     * @apiGroup Category
     * @apiPermission none
     * @apiParam {Number} [user_id] 当前用户id 未登录不传或者传0
     * @apiParam {Number} [have_data]  是否返回带数据的分类信息数据, 1有 0无
     * @apiParam {Number} [count]  每个分类信息返回多少条视频数据
     * @apiVersion 0.0.1
     * @apiSuccessExample {json} Success-Response:
     *       {
     *               "status": "success",
     *               "code": 200,
     *               "message": "查询分类列表成功",
     *               "result": [
     *               {
     *               "id": 1,
     *               "name": "音标",
     *               "alias": "yinbiao",
     *               "view": 31,
     *               "videoInfoList": [
     *               {
     *                   "id": 13,
     *                   "title": "零基础学习英语音标视频教程",
     *                   "cover": "http://www.english.com/uploads/video-info/74ceb292408d6718cb818293b039c5e2.jpg",
     *                   "view": 39,
     *                   "teacherName": "Nickcen",
     *                   "videoType": "youku",
     *                   "recommended": 0,
     *                   "collected": 0,
     *                   "videoCount": 16,
     *                   "commentCount": 0,
     *                   "collectionCount": 0
     *               },
     *               {
     *                   "id": 12,
     *                     "title": "48个国际音标发音视频教程全集",
     *                     "cover": "http://www.english.com/uploads/video-info/f05d2843f5ecf9ec9448c98a9e6bbe80.jpg",
     *                     "view": 17,
     *                     "teacherName": "佚名",
     *                     "videoType": "youku",
     *                     "recommended": 0,
     *                     "collected": 0,
     *                     "videoCount": 21
     *                   }
     *               ]
     *               },
     *               {
     *                   "id": 2,
     *                 "name": "单词",
     *                 "alias": "danci",
     *                 "view": 8,
     *                 "videoInfoList": [
     *                   {
     *                       "id": 87,
     *                 "title": "英语单词拼读视频教程全集",
     *                 "cover": "http://www.english.com/uploads/video-info/245894d3fc2312adc2df4d70ac38abfe.jpg",
     *                 "view": 4,
     *                 "teacherName": "阿明",
     *                 "videoType": "youku",
     *                 "recommended": 0,
     *                 "collected": 0,
     *                 "videoCount": 15
     *               },
     *               {
     *                   "commentCount": 0,
     *                 "collectionCount": 0,
     *                 "id": 86,
     *                 "title": "快速记单词视频教程全集",
     *                 "cover": "http://www.english.com/uploads/video-info/feef4bc8174da15db4207262d38f980f.jpg",
     *                 "view": 0,
     *                 "teacherName": "阿明",
     *                 "videoType": "youku",
     *                 "recommended": 0,
     *                 "collected": 0,
     *                 "videoCount": 14
     *               }
     *             ]
     *           }
     *       ]
     *       }
     * @apiErrorExample {json} Error-Response:
     *     {
     *           "status": "error",
     *           "code": 404,
     *           "message": "查询分类列表失败"
     *      }
     */
    public function getCategoryies(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'have_data' => ['required', 'in:0,1']
        ], [
            'have_data.required' => 'have_data不能为空',
            'have_data.in' => 'have_data只能为0或1'
        ]);
        if ($validator->fails()) {
            return $this->respondWithFailedValidation($validator);
        }

        $categories = Category::orderBy('order', 'asc')->get(['id', 'name', 'alias', 'view']);
        if (count($categories) == 0) {
            return $this->respondWithErrors('没有查到任何分类');
        }

        // 如果不带数据,则直接返回分类信息
        if ($request->have_data == 0) {
            return $this->respondWithSuccess($categories, '查询分类列表成功');
        }

        // user_id默认为0
        $user_id = isset($request->user_id) ? $request->user_id : 0;

        // 如果带数据,则返回带数据的分类信息
        foreach ($categories as $key => $category) {
            $videoInfos = VideoInfo::where('category_id', $category->id)
                ->orderBy('id', 'desc')
                ->take(isset($request->count) ? $request->count : 4)
                ->get();

            // 只读一次到内存,节省资源
            $comments = Comment::where('type', 'video_info')->get();
            $collections = Collection::all();

            $result = null;
            foreach ($videoInfos as $k => $videoInfo) {
                $collection = Collection::where('user_id', $user_id)->where('video_info_id', $videoInfo->id)->first();
                $result[$k]['id'] = $videoInfo->id;
                $result[$k]['title'] = $videoInfo->title;
                $result[$k]['cover'] = url($videoInfo->photo);
                $result[$k]['view'] = $videoInfo->view;
                $result[$k]['teacherName'] = $videoInfo->teacher;
                $result[$k]['videoType'] = $videoInfo->type;
                $result[$k]['recommended'] = $videoInfo->recommend;
                $result[$k]['collected'] = isset($collection) ? 1 : 0;
                $result[$k]['videoCount'] = Video::where('video_info_id', $videoInfo->id)->count();
                $result[$k]['commentCount'] = $comments->where('source_id', $videoInfo->id)->count();
                $result[$k]['collectionCount'] = $collections->where('source_id', $videoInfo->id)->count();
            }
            
            $categories[$key]['videoInfoList'] = $result;
        }
        
        return $this->respondWithSuccess($categories, '查询分类列表成功');
    }

}
