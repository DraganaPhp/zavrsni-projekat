<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->integer('priority')->default(0);
            $table->bigInteger('on_index_page')->default(0)->comment('if slide should be displayed on index page');
            $table->string('subject');
            $table->string('link_title');
            $table->string('link_url');
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('slides');
    }

}
