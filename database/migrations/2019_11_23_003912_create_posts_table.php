<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('cat_id');
            $table->string('photo')->default('');
            $table->string('option')->default('normal'); // notice / main / normal
            $table->string('thumb_path')->default('');
            $table->string('title');
            $table->text('content')->default('');
            $table->string('iframe_src')->default('');
            $table->string('outlink1')->default('');
            $table->string('outlink2')->default('');
            $table->string('thumb')->default('');
            $table->integer('visits')->default(1);
            
            $table->timestamps();

            $table->index(['cat_id', 'option']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
