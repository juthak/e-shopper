@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ข้อมูลส่วนตัว</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p><strong>ชื่อ : </strong>{!!  Auth::user()->name !!}</p>
                    <p><strong>อีเมล : </strong>{!!  Auth::user()->email !!}</p>
                    <a href="/home" class="btn btn-primary">กลับหน้าหลัก</a>
                    <a href="/admin/createProduct" class="btn btn-success">จัดการสินค้า</a>


                    <p>You are logged in!</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
