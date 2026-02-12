<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ld_posts', function (Blueprint $table) {
            $table->json('blocks')->nullable()->after('content');
            $table->string('editor_mode')->default('classic')->after('blocks'); // classic, builder
            $table->json('builder_data')->nullable()->after('editor_mode'); // GrapesJS full state
        });
    }

    public function down(): void
    {
        Schema::table('ld_posts', function (Blueprint $table) {
            $table->dropColumn(['blocks', 'editor_mode', 'builder_data']);
        });
    }
};
