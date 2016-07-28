<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Feedback;
use Illuminate\Http\Request;

use App\Http\Requests;

class FeedbackController extends BaseController
{
    // get admin/feedback  全部反馈列表
    public function index()
    {
        $feedbacks = Feedback::orderBy('id', 'desc')->paginate(10);
        return view('admin.feedback.index', compact('feedbacks'));
    }

    // get admin/feedback/{feedback} 显示单个反馈信息
    public function show()
    {

    }

    // get admin/feedback/create 添加反馈 create、store是连续的操作,create获取创建前需要的数据,store存储数据
    public function create()
    {
        
    }

    // post admin/feedback 添加反馈提交处理
    public function store(Request $request)
    {

    }

    // get admin/feedback/{feedback}/edit 编辑反馈 edit、update也是一组连续的操作,edit获取需要编辑的数据的信息,update更新修改后的信息
    public function edit($id)
    {

    }

    // put admin/feedback/{feedback} 更新反馈
    public function update(Request $request, $id)
    {
        
    }

    // delete admin/feedback/{feedback} 删除反馈
    public function destroy($id)
    {
        
    }
}
