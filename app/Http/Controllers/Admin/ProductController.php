<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use  App\Product;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.ProductDashboard')->with('products', Product::paginate(5));   //แสดงผลข้อมูล product ที่หน้า ProductDashboard
    }



    public function create()
    {
        return view('admin.ProductForm')->with('categories', Category::all());  //โยนค่าไปแสดงผลที่แบบฟอร์ม
    }


    public function store(Request $request)
    {
        //เช็คฟอร์มกรอกข้อมูล product
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',      //ชนิดตัวเลขเท่านั้น
            'image' => 'required|file|image|mimes:jpeg,png,jpg|max:5000',   //ชนิดไฟล์+รูปภาพ+ขนาดสูงสุด5000kb
        ]);

        //แปลงรูปภาพใหม่
        $stringImageReFormat = base64_encode('_' . time());    //กรณีอัพภาพที่ชื่อเหมือนกันจะมีการเข้ารหัสด้วย ตั้งชื่อรูปใหม่
        $ext = $request->file('image')->getClientOriginalExtension(); //ใส่นามสกุลไฟล์รูป
        $imageName = $stringImageReFormat . "." . $ext;    //ชื่อรูปใหม่+ใส่นามสกุลเดิมของรูปภาพ
        $imageEncode = File::get($request->image);         //เอารูปภาพอัพโหลดมาใช้งาน


        //อัพโหลด ใช้ file system มาจัดการ
        Storage::disk('local')->put('public/product_image/' . $imageName, $imageEncode); //อัพโหลดรูปภาพขึั้นไปเก็บที่ storage/app/public/product_image/

        //บันทึกข้อมูล
        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->category_id = $request->category;
        $product->price = $request->price;
        $product->image = $imageName;
        $product->save();
        return redirect('admin/dashboard');
    }

    //EDIT แก้ไขข้อมูลสินค้า
    public function edit($id)
    {

        $product = product::find($id); //ดึงข้อมูลเก่ามาแสดงตอนแก้ไขข้อมูล
        return view('admin.editProductForm')->with('product', $product);
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',      //ชนิดตัวเลขเท่านั้น
        ]);
        $product = Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();
        return redirect('admin/dashboard');
    }
    //DELETE ข้อมูลสินค้า
    public function delete($id)
    {
        Product::destroy($id);
        return redirect('admin/dashboard');
    }
}
