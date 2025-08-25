<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder {
  public function run(): void {
    $q = [
      ['text'=>'I enjoy solving math problems.','category'=>'math'],
      ['text'=>'I like doing science experiments.','category'=>'science'],
      ['text'=>'I love drawing or creating designs.','category'=>'arts'],
      ['text'=>'I’m interested in running a business.','category'=>'business'],
      ['text'=>'I enjoy coding or tinkering with tech.','category'=>'it'],
      ['text'=>'I like helping people with their health.','category'=>'health'],
      ['text'=>'I like writing or public speaking.','category'=>'communication'],
      ['text'=>'I enjoy outdoor/field work.','category'=>'outdoors'],
    ];
    foreach ($q as $row) {
      $qid = DB::table('questions')->insertGetId(['text'=>$row['text'],'category'=>$row['category'],'created_at'=>now(),'updated_at'=>now()]);
      // Likert 1..5
      for ($i=1;$i<=5;$i++){
        DB::table('question_options')->insert([
          'question_id'=>$qid,'text'=>"{$i}",'weight'=>$i,'created_at'=>now(),'updated_at'=>now()
        ]);
      }
    }
  }
}
