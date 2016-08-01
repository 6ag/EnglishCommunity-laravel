<?php

namespace App\Http\Controllers\Admin;

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
    public function index()
    {
        $videoInfos = VideoInfo::orderBy('id', 'desc')->paginate(15);
        return view('admin/video/index', compact('videoInfos'));
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
            'teacher' => 'required',
            'photo' => 'required',
            'intro' => 'required',
            'video_urls' => 'required'
        ], [
            'title.required' => '标题必须填写',
            'teacher.required' => '讲师必须填写',
            'photo.required' => '缩略图必须上传',
            'intro.required' => '简介必须填写',
            'video_urls.required' => '视频列表不能为空'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        // 创建视频信息
        $videoInfo = new VideoInfo();
        $videoInfo->title = $request->title;
        $videoInfo->intro = $request->intro;
        $videoInfo->photo = $this->savePhoto($request->photo);
        $videoInfo->category_id = $request->category_id;
        $videoInfo->teacher = $request->teacher;
        $videoInfo->type = $request->type;
        $videoInfo->save();

        // 拆分视频地址列表
        $listString = trim($request->video_urls);
        $listArray = explode("\r\n", $listString);

        // 创建视频列表信息
        foreach ($listArray as $item) {
            $videos = explode(',', $item);
            $video = new Video();
            $video->title = $videos[0];
            $video->video_url = $videos[1];
            $video->video_info_id = $request->category_id;
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
            $obj->setWidth(187);
            $obj->setHeight(333);
            $obj->draw();
        } catch (Exception $ex) {
            return back()->with('errors', '图片压缩失败,请放弃治疗');
        }

        // 清除临时图片
        @unlink($imagePath);
        return $destinationPath;

    }

    // get admin/video/{video}/edit 编辑视频 edit、update也是一组连续的操作,edit获取需要编辑的数据的信息,update更新修改后的信息
    public function edit($id)
    {

    }

    // put admin/video/{video} 更新视频
    public function update($id)
    {

    }

    // delete admin/video/{video} 删除视频
    public function destroy($id)
    {

    }

    /**
     * 上传图片到临时目录,并返回路径
     * @param Request $request
     * @return string 图片相对网站根目录路径
     */
    public function uploadImage(Request $request)
    {
        // 单张图片处理
        $file = $request->file('Filedata');

        if ($file->isValid()) {
            $file->move('temp', $file->getClientOriginalName());
            $tempPath = 'temp/'.$file->getClientOriginalName();
            return $tempPath;
        }
    }
}
