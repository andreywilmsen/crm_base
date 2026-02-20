<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('reference_date');
            $table->decimal('value', 15, 2)->nullable();
            $table->text('description');
            $table->string('status');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('records_categories')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
