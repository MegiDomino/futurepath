<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void {
    Schema::create('assessment_results', function (Blueprint $table) {
      $table->id('assess_id');
      $table->foreignId('profile_id')->constrained('profiles','profile_id')->cascadeOnDelete();
      $table->json('results');     // { top: [ {program, score}, ... ] }
      $table->text('top_program'); // convenience
      $table->timestamps();
    });
  }
  public function down(): void { Schema::dropIfExists('assessment_results'); }
};
