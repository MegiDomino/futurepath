from flask import Flask, request, jsonify
from sklearn.pipeline import Pipeline
from sklearn.preprocessing import StandardScaler
from sklearn.ensemble import RandomForestClassifier
import numpy as np

# === Domain assumptions for MVP ===
# Features (Likert 1..5): math, science, arts, business, it, health, communication, outdoors
# Labels: program codes matching PH programs (example set)
PROGRAMS = [
  "BS Computer Science", "BS Information Technology", "BS Accountancy",
  "BSBA Marketing", "BS Civil Engineering", "BS Nursing",
  "AB Communication", "BFA Multimedia Arts", "BS Psychology"
]

def build_model():
    # synthetic training data (expand/replace with real)
    X = np.array([
        [5,4,2,2,5,1,2,2],  # CS
        [4,4,2,2,5,1,2,2],  # IT
        [3,3,2,5,2,1,3,1],  # Accountancy
        [2,2,3,5,2,1,4,1],  # Marketing
        [4,5,1,2,2,1,2,5],  # Civil Eng (outdoors+math+sci)
        [3,4,1,2,2,5,2,2],  # Nursing (health)
        [2,2,4,3,2,1,5,1],  # Communication
        [2,2,5,2,3,1,3,2],  # Multimedia Arts
        [3,3,2,3,3,2,4,2],  # Psychology
    ])
    y = np.array([0,1,2,3,4,5,6,7,8])
    pipe = Pipeline([("scaler", StandardScaler()), ("rf", RandomForestClassifier(n_estimators=200, random_state=42))])
    pipe.fit(X, y)
    return pipe

app = Flask(__name__)
model = build_model()

@app.post("/predict")
def predict():
    data = request.get_json(force=True)
    # Expected payload: { "features": { "math":1..5, "science":.., "arts":.., "business":.., "it":.., "health":.., "communication":.., "outdoors":.. } }
    f = data.get("features", {})
    order = ["math","science","arts","business","it","health","communication","outdoors"]
    x = np.array([[int(f.get(k,3)) for k in order]])
    proba = model.predict_proba(x)[0]
    top_idx = np.argsort(proba)[::-1][:3]  # top 3
    results = [{"program": PROGRAMS[i], "score": float(proba[i])} for i in top_idx]
    return jsonify({"top": results})
    
if __name__ == "__main__":
    app.run(host="0.0.0.0", port=8000)
