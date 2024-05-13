<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('configs', function(Blueprint $table) {
            $table->increments('id');
			$table->string('name', 15)->default('')->comment('名称');
            $table->text('content')->nullable()->comment('内容');
            $table->string('description', 20)->default('')->nullable()->comment('简介');
            $table->boolean('is_type')->default(false)->nullable()->comment('序列化');
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
		Schema::drop('configs');
	}
};
