<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('question_options', function (Blueprint $table) {
      $table->id('ques_opt_id');
      $table->foreignId('question_id')->constrained('questions','question_id')->cascadeOnDelete();
      $table->text('text');
      $table->integer('weight'); // Likert 1..5
      $table->timestamps();
    });
  }
  public function down(): void { Schema::dropIfExists('question_options'); }
};
