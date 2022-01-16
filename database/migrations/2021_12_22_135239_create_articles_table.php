<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
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
            $table->string('name')->comment('Название');
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnUpdate()->onDelete('SET NULL')->comment('Категория');
            $table->text('text')->nullable()->comment('Текст');
            $table->text('images')->nullable()->comment('Изображение');
            $table->text('publish_at')->nullable()->comment('Дата публикации');
            $table->boolean('is_active')->default(true);
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
}
