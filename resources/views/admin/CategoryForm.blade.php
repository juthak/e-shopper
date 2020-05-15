@extends('layouts.admin')
@section('body')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="table-responsive">
    <h2>Create New Category</h2>
    <form action="/admin/createCategory" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Category Name">
        </div>

        <button type="submit" name="submit" class="btn btn-success">Submit</button>

    </form>
</div>


@if($categories->count()>0)
<div class="table-responsive my-2">
    <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">รหัสสินค้า</th>
            <th scope="col">หมวดหมู่สินค้า</th>
            <th scope="col">จำนวนสินค้า</th>
            <th scope="col">Edit</th>
            <th scope="col">Remove</th>
          </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
          <tr>
            <th scope="row">{{$category->id}}</th>
            <td>{{$category->name}}</td>
            <td>{{$category->products->count()}}</td>
            <td> <a href="/admin/editCategory/{{$category->id}}" class="btn btn-primary">แก้ไข</td>

            <td> <a href="/admin/deleteCategory/{{$category->id}}" class="btn btn-danger" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่ ?')">ลบ</td>
          </tr>
        @endforeach

        </tbody>
      </table>
      {{$categories->links()}}
</div>

@else
    <div class="aler alert-danger my-2">
        <br />
            <p>ไม่มีข้อมูลประเภทสินค้า</p>
         <br />

    </div>
@endif
@endsection



