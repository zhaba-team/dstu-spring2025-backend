<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table): void {
            $table->id();
            $table->integer('reaction_time')->nullable();
            $table->integer('boost')->nullable();
            $table->integer('max_speed')->nullable();
            $table->integer('speed_loss')->nullable();
            $table->integer('number')->unique();
            $table->string('color');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
