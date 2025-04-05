<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_race', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('race_id')->constrained('races')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->integer('place');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_race');
    }
};
