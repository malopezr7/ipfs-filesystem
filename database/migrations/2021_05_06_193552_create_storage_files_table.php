<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorageFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folders_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('hash')->nullable();
            $table->integer('id_user_uploaded')->unsigned()->nullable();
            $table->foreign('id_user_uploaded')->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->integer('id_folder')->unsigned()->nullable();
            $table->foreign('id_folder')->references('id')->on('folders_files')->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('hash');
            $table->string('content_type');
            $table->string('url')->nullable();
            $table->integer('parent_folder')->nullable();
            $table->integer('id_folder')->unsigned()->nullable();
            $table->foreign('id_folder')->references('id')->on('folders_files')->onUpdate('restrict')->onDelete('restrict');
            $table->integer('id_user_uploaded')->unsigned()->nullable();
            $table->foreign('id_user_uploaded')->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('storage_files');
    }
}
