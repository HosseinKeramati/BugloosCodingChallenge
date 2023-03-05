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
        Schema::create('microservice_logs', function (Blueprint $table) {
            $table->id();
            $table->string('service_name')->index();
            $table->string('request_line');
            $table->unsignedSmallInteger('status_code')->index();
            $table->date('date')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('microservice_logs');
    }
};
