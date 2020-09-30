<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->integer('price');
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedInteger('creator_id');
            $table->unsignedInteger('executor_id')->nullable();
            $table->timestamps();

            $table->foreign('creator_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->foreign('executor_id')
                ->references('id')
                ->on('users')
                ->onDelete('SET NULL')
                ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['executor_id']);
            $table->dropForeign(['creator_id']);
        });

        Schema::dropIfExists('tasks');
    }
}
