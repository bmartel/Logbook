<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


class CreateLogEntriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_entries', function(Blueprint $table) {
            $table->increments('id');
            $table->string('property', 50)->default('');
            $table->text('old_value')->default('')->nullable();
            $table->text('new_value')->default('')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('model_id')->unsigned();
            $table->string('model_type');
            $table->enum('change_type', ['create', 'update', 'delete', 'restore'])->default('update');
            $table->string('change_set', 32)->default(null)->nullable();
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
        Schema::drop('log_entries');
    }

}
