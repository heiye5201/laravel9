<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_brands', function (Blueprint $table) {
            $table->id();
            $table->string('thumb', 150)->default('')->nullable()->comment('缩略图');
            $table->string('wap_logo', 150)->default('')->nullable()->comment('缩略图');
            $table->string('name', 20)->default('')->comment('品牌名称');
            $table->unsignedInteger('is_sort')->default(0)->comment('排序');
            $table->unsignedInteger('recommend')->default(0)->comment('推荐');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_brands');
    }
};
