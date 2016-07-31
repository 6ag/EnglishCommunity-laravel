<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use App\Http\Model\Video;
use Illuminate\Http\Request;

use App\Http\Requests;

class VideoController extends BaseController
{
    // get admin/video  全部视频列表
    public function index()
    {
        $videos = Video::orderBy('id', 'desc')->paginate(15);
        return view('admin/video/index', compact('videos'));
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
