<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('article',function (Blueprint $table){
			$table->engine='MyISAM';
			$table->charset ='utf8';
			$table->collation = 'utf8_general_ci';
			$table->increments('id');
			$table->integer('category')->comment('分类ID');
			$table->string('title',100)->default('')->comment('标题');
			$table->string('tag',100)->default('')->comment('标签');
			$table->text('content')->notNull()->comment('文章');
			$table->boolean('status')->default(0)->comment('0正常,1删除');
			$table->string('from_url')->default('')->comment('来源地址');
			$table->string('author')->notNull()->comment('作者');
			$table->integer('user_id')->default(0)->comment('作者id');
			$table->integer('weight')->default(0)->comment('权重,倒序');
			$table->enum('source',['reprint','original','other'])->default('other')->comment('来源类型');
			$table->timestamps();
		}); 
		DB::statement('ALTER TABLE `article` ADD FULLTEXT(`content`)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('article'); 
    }
	
}
