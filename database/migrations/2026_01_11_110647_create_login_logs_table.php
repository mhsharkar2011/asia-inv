<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('login_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('login_type')->default('web'); // web, api, mobile, etc.
            $table->string('status')->default('success'); // success, failed, blocked
            $table->text('failure_reason')->nullable();
            $table->timestamp('logged_in_at');
            $table->timestamp('logged_out_at')->nullable();
            $table->integer('session_duration')->nullable(); // in seconds
            $table->timestamps();

            // Indexes for performance
            $table->index('user_id');
            $table->index('logged_in_at');
            $table->index(['user_id', 'logged_in_at']);
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('login_logs');
    }
};
