public function question(){ return $this->belongsTo(Question::class,'question_id','question_id'); }
public function option(){ return $this->belongsTo(QuestionOption::class,'selected_column_id','ques_opt_id'); }
