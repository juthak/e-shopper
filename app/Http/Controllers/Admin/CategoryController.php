<?php

//dd($category);  เอาไว้ดูข้อมูล
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{

    //SELECT *
    public function index()
    {

        //$categories =
        return view('admin.CategoryForm')->with('categories', Category::paginate(5));  //แสดงหมายเลขหน้าประเภทสินค้า
    }

    //INSERT เพิ่มข้อมูล(ใช้ validate ห้ามมีค่า null และ ชื่อประเภทไม่ซ้ำ)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories',
        ]);

        //เพิ่มข้อมูล(ลงตาราง)
        $category = new Category;
        $category->name = $request->name;
        $category->save();
        Session()->flash("success", "เพิ่มหมวดหมู่สินค้าเรียบร้อยแล้ว");
        return redirect('/admin/createCategory');
    }

    //EDIT แก้ไขข้อมูล
    public function edit($id)
    {
        //dd($id);
        $category = category::find($id); //ดึงข้อมูลเก่ามาแสดงตอนแก้ไขข้อมูล
        return view('admin.EditCategoryForm', ['category' => $category]);
    }


    //UPDATE ข้อมูล  (Edit+Store)
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:categories',
        ]);

        $category = Category::find($id); //ดึงข้อมูลเก่ามาแสดงตอนแก้ไขข้อมูล
        $category->name = $request->name;
        $category->save();  //บันทึกข้อมูลซ้ำ
        //return view('admin.EditCategoryForm', ['category' => $category]);
        Session()->flash("success", "แก้ไขข้อมูลเรียบร้อยแล้ว");
        return redirect('/admin/createCategory');
    }
    //DELETE ข้อมูล
    public function delete($id)
    {
        //เช็คว่าหมวดหมู่มีสินค้าอยู่ไหม ถ้ามีลบไม่ได้
        $category = Category::find($id);
        if ($category->products->count() > 0) {
            Session()->flash("failed", "ไม่สามารถลบหมวดหมู่ได้ เนื่องจากมีสินค้าใช้งานหมวดหมู่นี้อยู่!");
            return redirect()->back();  //กลับหน้าเดิมไม่มีการลบ
        }

        $category::destroy($id);
        Session()->flash("delete", "ลบหมวดหมู่สินค้าเรียบร้อยแล้ว");
        return redirect('/admin/createCategory');
    }
}
