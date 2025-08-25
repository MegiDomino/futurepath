<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('user_responses', function (Blueprint $table) {
      $table->id('user_res_id');
      $table->foreignId('profile_id')->constrained('profiles','profile_id')->cascadeOnDelete();
      $table->foreignId('question_id')->constrained('questions','question_id')->cascadeOnDelete();
      $table->foreignId('selected_column_id')->constrained('question_options','ques_opt_id');
      $table->timestamps();
    });
  }
  public function down(): void { Schema::dropIfExists('user_responses'); }
};
