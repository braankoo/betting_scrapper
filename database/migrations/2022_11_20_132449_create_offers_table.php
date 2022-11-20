<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->char('first');
            $table->char('second');
            $table->char('time')->nullable();
            $table->char('final_1')->nullable();
            $table->char('final_2')->nullable();
            $table->char('draw')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->primary(['category_id', 'first', 'second', 'time' ]);
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
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('offers');
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
