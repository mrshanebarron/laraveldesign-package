<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ld_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();

            $table->index('slug');
        });

        Schema::create('ld_post_tag', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained('ld_posts')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('ld_tags')->cascadeOnDelete();
            $table->primary(['post_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ld_post_tag');
        Schema::dropIfExists('ld_tags');
    }
};
