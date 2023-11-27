<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Tpetry\PostgresqlEnhanced\Schema\Blueprint;
use Tpetry\PostgresqlEnhanced\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->timestamp('published_at');
            $table->unsignedBigInteger('event_id');
            $table->foreignId('game_id')->constrained();
            $table->foreignId('rater_id')->constrained();
            $table->unsignedTinyInteger('rating');
            $table->text('review');
            $table->boolean('visible')->default(true);
            $table->boolean('has_review')->default(false);
            $table->unique(['event_id']);
            $table->index(['game_id', 'visible', 'has_review']);
            $table->index(['rater_id', 'visible', 'has_review']);
            $table->index(['visible', 'has_review']);
            $table->index(['published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
