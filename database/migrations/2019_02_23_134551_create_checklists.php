<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChecklists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('object_id')->nullable();
            $table->string('object_domain')->nullable();
            $table->string('due_unit')->nullable();
            $table->integer('due_interval')->nullable();
            $table->integer('template_id')->nullable();
            $table->string('description');
            $table->integer('urgency');
            $table->boolean('is_completed')->nullable();
            $table->dateTimeTz('completed_at')->nullable();
            $table->dateTimeTz('due')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checklists');
    }
}
