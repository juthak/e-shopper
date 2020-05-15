<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use  App\Product;
use League\CommonMark\Inline\Element\Strong;

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
        Session()->flash("success", "เพิ่มสินค้าเรียบร้อยแล้ว");
        return redirect('admin/dashboard');

        //flash message
        //$request->session()->flash('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');
    }

    //EDIT แก้ไขข้อมูลสินค้า
    public function edit($id)
    {

        $product = product::find($id); //ดึงข้อมูลเก่ามาแสดงตอนแก้ไขข้อมูล
        return view('admin.editProductForm')
            ->with('categories', Category::all())
            ->with('product', Product::find($id));


        //->with('product', $product);
    }

    //EDIT แก้ไขรูปภาพ
    public function editImage($id)
    {

        $product = product::find($id); //ดึงข้อมูลเก่ามาแสดงตอนแก้ไขข้อมูล
        return view('admin.editProductImage')->with('product', $product);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',      //ชนิดตัวเลขเท่านั้น
        ]);

        $product = Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        //เช็คว่ามีส่ง quest มาจาก category หรือเปล่า ถ้ามีแสดงว่ามีตัวเลือกใหม่
        if ($request->category) {
            $product->category_id = $request->category;
        }
        $product->save();
        Session()->flash("success", "แก้ไขข้อมูลเรียบร้อยแล้ว");
        return redirect('admin/dashboard');
    }


    //UPDATE IMAGE
    public function   updateImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|file|image|mimes:jpeg,png,jpg|max:5000'  //ชนิดไฟล์+รูปภาพ+ขนาดสูงสุด5000kb
        ]);
        if ($request->hasFile("image")) {
            $product = Product::find($id);
            $exists = Storage::disk('local')->exists("public/product_image" . $product->image);
            if ($exists) {
                Storage::delete("public/product_image" . $product->image);
            }
            $request->image->storeAs('public/product_image', $product->image);
            Session()->flash("success", "แก้ไขรูปภาพเรียบร้อยแล้ว");
            return redirect('admin/dashboard');
        }
    }


    //DELETE ข้อมูลสินค้า
    public function delete($id)
    {
        $product = Product::find($id);
        $exists = Storage::disk('local')->exists("public/product_image/" . $product->image);
        if ($exists) {
            Storage::delete("public/product_image/" . $product->image);
        }
        Product::destroy($id);
        Session()->flash("delete", "ลบข้อมูลสินค้าเรียบร้อยแล้ว");
        return redirect('admin/dashboard');
    }
}
