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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('pid')->default(0)->comment('上级ID');
            $table->unsignedInteger('belong_id')->default(0)->comment('所属用户');
            $table->string('name', 35)->default('')->comment('标题');
            $table->string('type', 35)->default('')->comment('类型');
            $table->text('content')->nullable()->comment('内容');
            $table->integer('click')->default(0)->nullable()->comment('点击次数');
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
        Schema::dropIfExists('articles');
    }
};
