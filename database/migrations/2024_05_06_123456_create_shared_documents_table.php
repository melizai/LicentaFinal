<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('shared_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'document_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('shared_documents');
    }
};
