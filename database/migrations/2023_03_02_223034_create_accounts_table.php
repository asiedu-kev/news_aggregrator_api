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
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255);
            $table->string('timezone', 120)->nullable();
            $table->string('country', 120)->nullable();
            $table->char('locale', 2)->default('en');
            $table->uuid('owner_id');
            $table->uuid('preference_id');
            $table->enum('status', ['active', 'suspended', 'closed'])->default('active');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('owner_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('preference_id')
                ->references('id')
                ->on('preferences')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
