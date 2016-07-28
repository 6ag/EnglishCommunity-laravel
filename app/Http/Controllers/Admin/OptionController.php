<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Option;
use Illuminate\Http\Request;

use App\Http\Requests;

class OptionController extends BaseController
{
    // get admin/option  全部配置列表
    public function index()
    {
        $options = Option::all();
        return view('admin.option.index', compact('options'));
    }

    // get admin/option/{option} 显示单个配置信息
    public function show()
    {
        
    }

    // get admin/option/create 添加配置 create、store是连续的操作,create获取创建前需要的数据,store存储数据
    public function create()
    {
        
    }

    // post admin/option 添加配置提交处理
    public function store(Request $request)
    {
        // 创建空配置项
        Option::create();
    }

    // get admin/option/{option}/edit 编辑配置 edit、update也是一组连续的操作,edit获取需要编辑的数据的信息,update更新修改后的信息
    public function edit($id)
    {

    }

    // put admin/option/{option} 更新配置
    public function update(Request $request, $id)
    {
        $input = $request->except(['_token', '_method']);
        $result = Option::find($id)->update($input);
        if ($result) {
            // 还没处理提示
            return back()->with('errors', '更新配置成功');
        } else {
            return back()->with('errors', '更新配置失败');
        }
    }

    // delete admin/option/{option} 删除配置
    public function destroy($id)
    {
        $result = Option::find($id)->delete();
        if ($result) {
            $data = [
                'status' => 1,
                'msg' => '删除配置项成功',
            ];
        } else {
            $data = [
                'status' => 0,
                'msg' => '删除配置项失败',
            ];
        }

        return $data;
    }
}
