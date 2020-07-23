<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('pages', static function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug');
            $table->string('template');
            $table->boolean('show_in_navigation')->default(false);
            $table->boolean('selectable_in_navigation')->default(true);
            $table->boolean('show_articles_in_navigation')->default(true);
            $table->integer('articles_per_page')->default(10);
            $table->text('lead')->nullable();
            $table->text('content')->nullable();
            $table->string('image_main')->nullable();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::drop('pages');
    }
}
