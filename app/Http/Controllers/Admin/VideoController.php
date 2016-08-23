<?php

namespace App\Http\Controllers\Admin;

use App\Http\JPush;
use App\Http\Model\Category;
use App\Http\Model\Video;
use App\Http\Model\VideoInfo;
use App\Http\ResizeImage;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class VideoController extends BaseController
{
    // get admin/video  全部视频列表
    public function index(Request $request)
    {
        if (isset($request->category_id) && $request->category_id != 0) {
            $videoInfos = VideoInfo::where('category_id', $request->category_id)
                ->orderBy('id', 'desc')
                ->paginate(15);
            $categories = Category::all();
            $currentCategory = Category::findOrFail($request->category_id);
            return view('admin/video/index', compact('videoInfos', 'categories', 'currentCategory'));
        } else {
            $videoInfos = VideoInfo::orderBy('id', 'desc')
                ->paginate(15);
            $categories = Category::all();
            return view('admin/video/index', compact('videoInfos', 'categories'));
        }

    }

    // get admin/video/{video} 显示单个视频信息
    public function show()
    {

    }

    // get admin/video/create 添加视频 create、store是连续的操作,create获取创建前需要的数据,store存储数据
    public function create()
    {
        $categories = Category::all();
        return view('admin/video/create', compact('categories'));
    }

    // post admin/video 添加视频提交处理
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'photo' => 'required',
            'intro' => 'required',
            'video_urls' => 'required'
        ], [
            'title.required' => '标题必须填写',
            'photo.required' => '缩略图必须上传',
            'intro.required' => '简介必须填写',
            'video_urls.required' => '视频列表不能为空'
        ]);

        if ($validator->fails()) {
            $request->flashExcept('_token');
            return back()->withErrors($validator);
        }

        // 创建视频信息
        $videoInfo = new VideoInfo();
        $videoInfo->title = $request->title;
        $videoInfo->intro = $request->intro;
        $videoInfo->photo = $this->savePhoto($request->photo);
        $videoInfo->category_id = $request->category_id;
        empty($request->teacher) ?: $videoInfo->teacher = $request->teacher;
        $videoInfo->type = $request->type;
        !isset($request->recommend) ?: $videoInfo->recommend = $request->recommend;
        $videoInfo->save();

        // 拆分视频地址列表
        $listString = trim($request->video_urls);
        $listArray = explode("\r\n", $listString);

        // 创建视频列表信息
        foreach ($listArray as $key => $item) {
            $videos = explode(',', $item);
            $video = new Video();
            $video->title = $videos[0];
            $video->video_url = $videos[1];
            $video->video_info_id = $videoInfo->id;
            $video->order = $key + 1;
            $video->save();
        }

        return back()->with('errors', '创建视频集成功');
    }

    /**
     * 保存图片
     * @param $imagePath
     */
    private function savePhoto($imagePath) {

        $allowExtensionNames = ['jpeg', 'jpg', 'png', 'wbmp'];
        $extension = substr($imagePath, strrpos($imagePath, '.') + 1);
        if (!in_array($extension, $allowExtensionNames)) {
            return back()->with('errors', '文件类型不在允许范围内');
        }

        // 目录是否存在 不存在则创建
        $directory = 'uploads/';

        if (!file_exists($directory)) {
            if (!(mkdir($directory, 0777, true) && chmod($directory, 0777))) {
                return back()->with('errors', '无权限创建路径,请设置public下的uploads目录权限为777');
            }
        }

        $fileName = md5(uniqid(microtime(true), true)) . '.jpg';
        $destinationPath = $directory . $fileName;

        try {
            $obj = new ReSizeImage();
            $obj->setSourceFile($imagePath);
            $obj->setDstFile($destinationPath);
            $obj->setWidth(300);
            $obj->setHeight(250);
            $obj->draw();
        } catch (Exception $ex) {
            return back()->with('errors', '图片压缩失败,请放弃治疗');
        }

        // 修改保存的图片权限
        @chmod($imagePath, 0777);
        // 清除临时图片
        @unlink($imagePath);
        return $destinationPath;

    }

    // get admin/video/{video}/edit 编辑视频 edit、update也是一组连续的操作,edit获取需要编辑的数据的信息,update更新修改后的信息
    public function edit($id)
    {
        $videoInfo = VideoInfo::findOrFail($id);
        $categories = Category::all();

        // 合并视频地址列表
        $videos = Video::where('video_info_id', $videoInfo->id)->get();
        $video_urls = '';
        foreach ($videos as $key => $video) {
            $video_urls .= $video->title;
            $video_urls .= ',';
            $video_urls .= $video->video_url;
            $key == count($videos) - 1 ?: $video_urls .= "\r\n";
        }

        return view('admin.video.edit', compact('videoInfo', 'categories', 'video_urls'));
    }

    // put admin/video/{video} 更新视频
    public function update(Request $request, $id)
    {
        // 更新视频集信息
        $videoInfo = VideoInfo::findOrFail($id);
        $videoInfo->title = $request->title;
        $videoInfo->intro = $request->intro;
        $videoInfo->photo = $this->savePhoto($request->photo);
        $videoInfo->category_id = $request->category_id;
        empty($request->teacher) ?: $videoInfo->teacher = $request->teacher;
        $videoInfo->type = $request->type;
        !isset($request->recommend) ?: $videoInfo->recommend = $request->recommend;
        $videoInfo->save();

        // 清空旧视频地址列表
        Video::where('video_info_id', $videoInfo->id)->delete();

        // 拆分视频地址列表
        $listString = trim($request->video_urls);
        $listArray = explode("\r\n", $listString);

        // 创建新的视频列表信息
        foreach ($listArray as $key => $item) {
            $videos = explode(',', $item);
            $video = new Video();
            $video->title = $videos[0];
            $video->video_url = $videos[1];
            $video->video_info_id = $videoInfo->id;
            $video->order = $key + 1;
            $video->save();
        }

        return redirect()->route('admin.video.index');
    }

    // delete admin/video/{video} 删除视频
    public function destroy($id)
    {
        // 更新视频集信息
        $videoInfo = VideoInfo::findOrFail($id);
        Video::where('video_info_id', $videoInfo->id)->delete();
        $videoInfo->delete();

        return [
            'status' => 1,
            'msg' => '删除成功'
        ];
    }

    /**
     * 上传图片到临时目录,并返回路径 public/temp
     * @param Request $request
     * @return string 图片相对网站根目录路径
     */
    public function uploadImage(Request $request)
    {
        $file = $request->file('Filedata');
        if ($file->isValid()) {
            $file->move('temp', $file->getClientOriginalName());
            $tempPath = 'temp/'.$file->getClientOriginalName();
            return $tempPath;
        }
    }

    /**
     * 发送远程推送 如果参数id不等于 -1 则表示需要跳转
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function push($id)
    {
        $videoInfo = VideoInfo::find($id);
        return view('admin.video.push', compact('videoInfo'));
    }

    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'push_content' => ['required'],
            'id' => ['exists:video_infos'],
        ], [
            'push_content.required' => '推送内容不能为空',
            'id.exists' => '视频信息不存在'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        // 发送推送
        $push = new JPush();
        $result = $push->sendRemoteNotification('all', $request->push_content, [
            'id' => isset($request->info) ? $request->id : -1
        ]);

        return redirect()->route('admin.video.index')->with(['errors' => $result]);

    }
}
