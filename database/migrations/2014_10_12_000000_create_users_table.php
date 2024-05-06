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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('belong_id')->default(0)->comment('所属');
            $table->string('username')->comment('账号');
            $table->string('password')->comment('密码');
            $table->string('phone', 32)->comment('手机号');
            $table->string('nickname', 32)->comment('昵称');
            $table->tinyInteger('sex')->default(0)->comment('性别');
            $table->string('avatar', 150)->nullable()->comment('头像');
            $table->string('pay_password', 60)->comment('支付密码');
            $table->string('email')->unique()->comment('邮箱');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->decimal('money', 8, 2)->comment('钱包金额');
            $table->decimal('frozen_money', 8, 2)->comment('冻结金额');
            $table->decimal('integral', 8, 2)->comment('积分');
            $table->unsignedInteger('inviter_id')->default(0)->nullable()->comment('邀请人ID');
            $table->tinyInteger('status')->default(0)->comment('状态');
            $table->timestamp('invalid_time')->nullable()->comment('过期时间');
            $table->string('ip', 45)->nullable()->comment('登陆IP');
            $table->timestamp('login_time')->nullable()->comment('登陆时间');
            $table->timestamp('last_login_time')->nullable()->comment('最后一次登陆');
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
        Schema::dropIfExists('users');
    }
};
