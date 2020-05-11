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
    <h2>Edit Product</h2>
    <form action="/admin/updateProduct/{{$product->id}}" method="post">
        {{csrf_field()}}


        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Product Name" value="{{$product->name}}">
        </div>


        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" id="description" placeholder="Description" value="{{$product->description}}">
        </div>





        <div class="form-group">
            <label for="type">Price</label>
            <input type="text" class="form-control" name="price" id="price" placeholder="Price" required value="{{$product->price}}">
        </div>




        <button type="submit" name="submit" class="btn btn-primary">Update</button>
    </form>



</div>


@endsection
