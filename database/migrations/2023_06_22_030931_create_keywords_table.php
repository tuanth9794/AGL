<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('keywords', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->integer('google_rank');
            $table->double('gooole_searches');
            $table->integer('yahoo_rank');
            $table->double('yahoo_searches');
            $table->unsignedBigInteger('website_id')->nullable();;
            $table->foreign('website_id')->references('id')->on('websites')->onDelete('cascade');
            $table->mediumInteger('is_active');
            $table->mediumInteger('is_publish');
            $table->string('create_by', 100)->nullable();
            $table->string('update_by', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keywords');
    }
};
