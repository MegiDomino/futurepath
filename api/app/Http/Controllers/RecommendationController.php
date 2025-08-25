<?php
namespace App\Http\Controllers;

use App\Models\AssessmentResult;
use App\Models\UserResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecommendationController extends Controller
{
    public function recommend(Request $req) {
        $req->validate(['profile_id'=>'required|integer|exists:profiles,profile_id']);
        $responses = UserResponse::with('question','option')->where('profile_id',$req->profile_id)->get();

        // Collapse Likert weights per category → feature vector expected by ML
        $categories = ['math','science','arts','business','it','health','communication','outdoors'];
        $scores = array_fill_keys($categories, 3); // neutral default
        foreach ($responses as $r) {
            $cat = $r->question->category;
            if (isset($scores[$cat])) $scores[$cat] = $r->option->weight;
        }

        $mlUrl = rtrim(config('app.ml_service_url', env('ML_SERVICE_URL')), '/').'/predict';
        $res = Http::timeout(5)->post($mlUrl, ['features'=>$scores])->json();

        $top = $res['top'] ?? [];
        $topProgram = $top[0]['program'] ?? 'N/A';

        $saved = AssessmentResult::create([
            'profile_id' => $req->profile_id,
            'results'    => $top,
            'top_program'=> $topProgram,
        ]);

        return response()->json(['assessment'=>$saved]);
    }
}
