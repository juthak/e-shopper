@extends('layouts.admin')
@section('body')

@if($products->count()>0)
<div class="table-responsive my-2">
    <h2>Product Dashboard</h2>
    <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Price</th>
            <th scope="col">Edit Image</th>
            <th scope="col">Edit</th>
            <th scope="col">Remove</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <th scope="row">{{$product->id}}</th>
                    <td>
                        <img src="{{asset('storage')}}/product_image/{{$product->image}}" alt="" width="100px" height="100px">
                    </td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->description}}</td>
                    <td>{{number_format($product->price)}}</td>

                      <td> <a href="/admin/editProduct/{{$product->image}}" class="btn btn-success">แก้ไขรูปภาพ</td>
                     <td> <a href="/admin/editProduct/{{$product->id}}" class="btn btn-primary">แก้ไข</td>
                      <td> <a href="/admin/deleteProduct/{{$product->id}}" class="btn btn-danger" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')">ลบ</td>
                    </tr>
                    @endforeach

        </tbody>
      </table>
      {{$products->links()}}

</div>

@else
    <div class="aler alert-danger my-2">
        <br />
            <p>ไม่มีข้อมูลสินค้า</p>
         <br />

    </div>
@endif
@endsection



