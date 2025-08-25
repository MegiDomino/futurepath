use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\RecommendationController;

Route::get('/questions', [QuestionnaireController::class,'questions']);
Route::post('/profile', [QuestionnaireController::class,'upsertProfile']);
Route::post('/submit', [QuestionnaireController::class,'submit']);
Route::post('/recommend', [RecommendationController::class,'recommend']);
