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
        Schema::create('discount_rules', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->tinyInteger('enabled')->default(1)->comment('1开启，0关闭');
            $table->tinyInteger('combining')->default(0)->comment('1可叠加折扣');
            $table->tinyInteger('exclusive')->default(0)->comment('是否是独有折扣');
            $table->tinyInteger('is_code')->default(0)->comment('1优惠码折扣');
            $table->string('title',100)->nullable(true)->index()->comment('优惠券名称');
            $table->text('description')->nullable(true)->comment('折扣描述');
            $table->dateTime('starts_at')->nullable(true)->index()->comment('开始时间');
            $table->dateTime('ends_at')->nullable(true)->index()->comment('结束时间');
            $table->string('allocation_method', 64)->comment('折扣应用方式');
            $table->string('discount_class', 64)->comment('折扣分类');
            $table->string('discount_type', 64)->comment('折扣类型');
            $table->json('filters')->nullable(true)->comment('折扣过滤器');
            $table->json('conditions')->nullable(true)->comment('折扣生效的先决条件');
            $table->json('adjustments')->nullable(true)->comment('折扣计算规则');
            $table->unsignedInteger('usage_counts')->default(0)->comment('折扣被使用的次数限制（0 不限制）');
            $table->unsignedInteger('usage_limit_per_user')->default(0)->comment('每位客户最多使用次数限制（0 不限制）');
            $table->unsignedInteger('usage_limit')->default(0)->comment('最大折扣使用次数，该优惠码被应用多少次后失效（0 不限制）');
            $table->decimal('max_discount_sum', 14, 2)->default(0)->nullable(false)->comment('每笔订单最高优惠金额限制（0 不限制）');
            $table->integer('usage_counts')->comment('折扣被使用的次数限制')->change();
            $table->string('preference_type')->comment('优惠类型');
            $table->string('adjustment_type')->comment('计算类型');
            $table->tinyInteger('real_bulk_discount')->default(0)->comment('是否是真实的梯度优惠');
            $table->decimal('total_sales', 14, 2)->default(0)->nullable(false)->comment('销售总额');
            $table->decimal('total_discount', 14, 2)->default(0)->nullable(false)->comment('折扣总额');
            $table->tinyInteger('is_new_rule')->default(0)->comment('是否是新折扣');
            $table->softDeletes()->comment('删除时间');
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
        Schema::dropIfExists('discount_rules');
    }
};
