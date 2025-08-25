<?php
namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Profile;
use App\Models\UserResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionnaireController extends Controller
{
    public function questions() {
        $questions = Question::with('options')->get();
        return response()->json($questions);
    }

    public function upsertProfile(Request $req) {
        $profile = Profile::updateOrCreate(['email' => $req->email], []);
        return response()->json($profile);
    }

    public function submit(Request $req) {
        $req->validate([
            'profile_id' => 'required|integer|exists:profiles,profile_id',
            'answers'    => 'required|array' // [{question_id, ques_opt_id}]
        ]);
        DB::transaction(function() use ($req) {
            foreach ($req->answers as $ans) {
                UserResponse::updateOrCreate(
                    ['profile_id'=>$req->profile_id,'question_id'=>$ans['question_id']],
                    ['selected_column_id'=>$ans['ques_opt_id']]
                );
            }
        });
        return response()->json(['status'=>'ok']);
    }
}
