<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedBigInteger('template_id')->default(1)->after('id');

            // If you have a foreign key relationship with the templates table
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            // Drop the foreign key constraint first if it exists
            $table->dropForeign(['template_id']);
            $table->dropColumn('template_id');
        });
    }
};
