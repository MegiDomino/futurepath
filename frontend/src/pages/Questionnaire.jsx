import React, { useEffect, useState } from 'react'
import { fetchQuestions, upsertProfile, submitAnswers, getRecommendation } from '../api'
import { useNavigate } from 'react-router-dom'

export default function Questionnaire(){
  const [email,setEmail] = useState("")
  const [profile,setProfile] = useState(null)
  const [questions,setQuestions] = useState([])
  const [answers,setAnswers] = useState({})
  const [loading,setLoading] = useState(false)
  const nav = useNavigate()

  useEffect(()=>{
    fetchQuestions().then(setQuestions)
  },[])

  const onSelect = (qid, opt) => setAnswers(a=>({...a, [qid]: opt}))

  async function start(e){
    e.preventDefault()
    const p = await upsertProfile(email)
    setProfile(p)
  }

  async function submit(){
    setLoading(true)
    const payload = {
      profile_id: profile.profile_id,
      answers: Object.entries(answers).map(([question_id, ques_opt_id])=>({question_id, ques_opt_id}))
    }
    await submitAnswers(payload)
    await getRecommendation(profile.profile_id)
    setLoading(false)
    nav(`/results/${profile.profile_id}`)
  }

  return (
    <div className="container py-4">
      <h1 className="mb-3">FuturePath – College Program Matcher</h1>
      {!profile ? (
        <form onSubmit={start} className="mb-4">
          <label className="form-label">Enter your email to begin</label>
          <input className="form-control mb-2" value={email} onChange={e=>setEmail(e.target.value)} required/>
          <button className="btn btn-primary">Start</button>
        </form>
      ) : (
        <>
        <p className="text-muted">Profile ID: {profile.profile_id}</p>
        <div className="list-group mb-3">
          {questions.map(q=>(
            <div key={q.question_id} className="list-group-item">
              <div className="fw-semibold mb-2">{q.text}</div>
              <div className="d-flex gap-2">
                {q.options.sort((a,b)=>a.weight-b.weight).map(opt=>(
                  <button
                    key={opt.ques_opt_id}
                    className={`btn ${answers[q.question_id]==opt.ques_opt_id?'btn-primary':'btn-outline-primary'}`}
                    onClick={()=>onSelect(q.question_id, opt.ques_opt_id)}
                  >
                    {opt.text}
                  </button>
                ))}
              </div>
            </div>
          ))}
        </div>
        <button className="btn btn-success" disabled={loading || questions.some(q=>!answers[q.question_id])} onClick={submit}>
          {loading ? 'Scoring…' : 'See my top programs'}
        </button>
        </>
      )}
    </div>
  )
}
