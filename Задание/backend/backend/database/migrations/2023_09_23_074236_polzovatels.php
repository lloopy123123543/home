<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polzovatels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('login');
            $table->string('password');
            $table->integer("role");
            $table->string("token")->nullable();
            $table->string("group")->nullable();
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
        //
    }
};
