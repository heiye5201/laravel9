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
        Schema::create('discount_rule_filters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filter_type', 64)->default('')->comment('过滤规则类型');
            $table->string('operator', 32)->default('')->comment('过滤方式');

            $table->integer('object_id')->default(0)->comment('对象的id');
            $table->integer('discount_rule_id')->default(0)->comment('关联的折扣规则id');

            $table->tinyInteger('main_product')->default(0)->comment('是否为组合折扣主商品');
            $table->tinyInteger('is_code')->default(0)->comment('是否是优惠码');
            $table->timestamps();
            $table->softDeletes()->comment('删除时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_rule_filters');
    }
};
