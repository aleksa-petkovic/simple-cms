<?php

declare(strict_types=1);

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
    public function up(): void
    {
        Schema::create('articles', static function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->bigInteger('page_id')->unsigned();
            $table->string('title');
            $table->string('slug');
            $table->string('template');
            $table->text('lead')->nullable();
            $table->text('content')->nullable();
            $table->string('image_main')->nullable();
            $table->timestamps();

            $table->softDeletes();

            // The foreign key to the parent pages.
            $table->index('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onUpdate('cascade')->onDelete('cascade');

            // MySQL storage engine.
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::drop('articles');
    }
}
