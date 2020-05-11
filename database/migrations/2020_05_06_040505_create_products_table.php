<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');          //ชื่อสินค้า
            $table->text('description');     //รายละเอียดสินค้า
            $table->string('image');         //ชื่อรูปภาพสินค้า
            $table->decimal('price', 8, 2);  //ราคาสินค้า 8 หลัก  จุดทศนิยม 2
            $table->integer('category_id');  //foreign key *สำคัญ* สิ่งที่มากำหนดความสัมพันธ์ตาราง
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
