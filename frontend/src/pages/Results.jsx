import React, { useEffect, useState } from 'react'
import { useParams, Link } from 'react-router-dom'
import { getRecommendation } from '../api'

export default function Results(){
  const { profileId } = useParams()
  const [data,setData] = useState(null)

  useEffect(()=>{
    getRecommendation(Number(profileId)).then(r=>setData(r.assessment))
  },[profileId])

  if(!data) return <div className="container py-4">Loading…</div>
  const top = data.results || []
  return (
    <div className="container py-4">
      <h2>Your top matches</h2>
      <ul className="list-group my-3">
        {top.map((t,i)=>(
          <li key={i} className="list-group-item d-flex justify-content-between">
            <span>{i+1}. {t.program}</span>
            <span className="badge bg-secondary">{(t.score*100).toFixed(1)}%</span>
          </li>
        ))}
      </ul>
      <p className="text-muted">Best match: <strong>{data.top_program}</strong></p>
      <Link to="/" className="btn btn-outline-primary">Retake / New profile</Link>
    </div>
  )
}
