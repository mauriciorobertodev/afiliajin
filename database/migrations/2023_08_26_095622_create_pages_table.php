<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cloned_from');
            $table->string('slug')->unique();
            $table->boolean('whatsapp_show')->default(false);
            $table->string('whatsapp_number')->nullable();
            $table->text('whatsapp_message')->nullable();
            $table->boolean('more_18')->default(false);
            $table->foreignIdFor(User::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
