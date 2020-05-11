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
    <h2>Edit Category</h2>
    <form action="/admin/updateCategory/{{$category->id}}" method="post">
        {{csrf_field()}}
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Category Name" value="{{$category->name}}">
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Update</button>
    </form>
</div>


      </table>
</div>

@endsection



