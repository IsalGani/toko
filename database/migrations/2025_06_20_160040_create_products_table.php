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
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('category_id')->nullable(); // ✅ kolom benar

            $table->integer('stok')->default(0);
            $table->decimal('harga', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('category_id') // ✅ sesuai kolom di atas
                ->references('id')       // ✅ sesuai kolom di categories
                ->on('categories')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
