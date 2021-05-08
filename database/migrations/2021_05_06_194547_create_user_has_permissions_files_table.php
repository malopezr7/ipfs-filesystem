<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHasPermissionsFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_has_permissions_element', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('can_read');
            $table->boolean('can_write');
            $table->boolean('can_delete');
            $table->integer('id_user')->unsigned()->nullable();
            $table->foreign('id_user')->references('id')->on('users');
            $table->integer('id_document_element')->unsigned()->nullable();
            $table->foreign('id_document_element')->references('id')->on('document_elements');
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
        Schema::dropIfExists('user_has_permissions_files');
    }
}
