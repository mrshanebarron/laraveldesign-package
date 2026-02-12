<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ld_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->unique(); // header, footer, sidebar
            $table->timestamps();
        });

        Schema::create('ld_menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('ld_menus')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('ld_menu_items')->nullOnDelete();
            $table->string('label');
            $table->string('type')->default('custom'); // custom, post, page, category
            $table->string('url')->nullable();
            $table->unsignedBigInteger('linkable_id')->nullable();
            $table->string('linkable_type')->nullable();
            $table->string('target')->default('_self'); // _self, _blank
            $table->string('css_class')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index(['menu_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ld_menu_items');
        Schema::dropIfExists('ld_menus');
    }
};
