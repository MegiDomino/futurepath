<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('questions', function (Blueprint $table) {
      $table->id('question_id');
      $table->text('text');
      $table->string('category', 255); // e.g., "math", "science", "arts", ...
      $table->timestamps();
    });
  }
  public function down(): void { Schema::dropIfExists('questions'); }
};
