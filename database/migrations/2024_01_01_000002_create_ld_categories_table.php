<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ld_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('ld_categories')->nullOnDelete();
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index('slug');
        });

        Schema::create('ld_category_post', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained('ld_categories')->cascadeOnDelete();
            $table->foreignId('post_id')->constrained('ld_posts')->cascadeOnDelete();
            $table->primary(['category_id', 'post_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ld_category_post');
        Schema::dropIfExists('ld_categories');
    }
};
