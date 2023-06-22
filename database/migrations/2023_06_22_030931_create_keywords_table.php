<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create('keywords', function (Blueprint $table) {
                     $table->id();
                                 $table->string('name',20);
                                 $table->string('slug',20);
                                 $table->integer('rank');
                                 $table->double('searches');
                     $table->unsignedBigInteger('website_id');
                     $table->foreign('website_id')->references('id')->on('websites');
                                 $table->mediumInteger('is_active');
                                 $table->mediumInteger('is_publish');
                                 $table->string('create_by',20);
                                 $table->string('update_by',20);
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