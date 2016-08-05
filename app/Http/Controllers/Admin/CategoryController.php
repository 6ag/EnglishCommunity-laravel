<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{
    // get admin/category  全部分类列表
    public function index()
    {
        $categories = Category::orderBy('id', 'asc')->paginate(15);
        return view('admin/category/index', compact('categories'));
    }

    // get admin/category/{category} 显示单个分类信息
    public function show()
    {
        
    }

    // get admin/category/create 添加分类 create、store是连续的操作,create获取创建前需要的数据,store存储数据
    public function create()
    {
        return view('admin/category/create');
    }

    // post admin/category 添加分类提交处理
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:categories'],
            'alias' => ['required', 'unique:categories'],
        ], [
            'name.required' => '名称不能为空',
            'name.unique' => '名称已经存在',
            'alias.required' => '别名不能为空',
            'alias.unique' => '别名已经存在',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        // 创建分类
        Category::create($request->except('_token'));
        return redirect()->route('admin.category.index');
    }

    // get admin/category/{category}/edit 编辑分类 edit、update也是一组连续的操作,edit获取需要编辑的数据的信息,update更新修改后的信息
    public function edit($id)
    {

    }

    // put admin/category/{category} 更新分类
    public function update($id)
    {

    }

    // delete admin/category/{category} 删除分类
    public function destroy($id)
    {

    }
}
