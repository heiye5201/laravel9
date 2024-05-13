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
        Schema::create('goods_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('pid')->default(0)->commentg('父栏目ID');
            $table->string('thumb', 150)->default('')->nullable()->commentg('缩略图');
            $table->string('name', 20)->default('')->comment('栏目名称');
            $table->string('simple_name', 64)->default('')->nullable()->comment('简称');
            $table->unsignedInteger('is_sort')->default(0)->comment('排序');
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
        Schema::dropIfExists('goods_classes');
    }
};
