from flask import Flask, request, jsonify
import face_recognition
import numpy as np
import base64
import json
import os
import io
from PIL import Image

app = Flask(__name__)

DB_FILE = "database.json"

# ================= LOAD DATABASE =================
if os.path.exists(DB_FILE):
    with open(DB_FILE, "r") as f:
        database = json.load(f)
else:
    database = {}

def save_db():
    with open(DB_FILE, "w") as f:
        json.dump(database, f)


# ================= FIX IMAGE (SUPER STABLE) =================
def base64_to_image(base64_str):
    try:
        if ',' in base64_str:
            base64_str = base64_str.split(',')[1]

        img_data = base64.b64decode(base64_str)
        img = Image.open(io.BytesIO(img_data))

        # 🔥 Paksa RGB murni (buang alpha channel jika ada)
        if img.mode != 'RGB':
            img = img.convert('RGB')

        img_np = np.array(img, dtype=np.uint8)

        # 🔥 Verifikasi channel harus tepat 3
        if img_np.ndim != 3 or img_np.shape[2] != 3:
            print(f"CHANNEL SALAH: shape={img_np.shape}")
            return None

        # 🔥 Pastikan contiguous di memory
        img_np = np.ascontiguousarray(img_np)

        print(f"IMAGE OK — shape: {img_np.shape}, dtype: {img_np.dtype}")
        return img_np

    except Exception as e:
        print("ERROR CONVERT:", e)
        return None


# ================= REGISTER =================
@app.route('/register', methods=['POST'])
def register():
    user_id = str(request.json.get('user_id'))
    image_np = base64_to_image(request.json.get('image'))

    if image_np is None:
        return jsonify({'status': 'error', 'message': 'Gambar tidak valid'})

    print("TYPE:", type(image_np))
    print("SHAPE:", image_np.shape)
    print("DTYPE:", image_np.dtype)

    try:
        # 🔥 paksa format lagi sebelum dlib

        face_locations = face_recognition.face_locations(image_np)

        if len(face_locations) == 0:
            return jsonify({'status': 'error', 'message': 'Wajah tidak terdeteksi'})

        encodings = face_recognition.face_encodings(image_np, face_locations)

        database[user_id] = encodings[0].tolist()
        save_db()

        return jsonify({'status': 'success', 'message': 'Wajah berhasil disimpan'})

    except Exception as e:
        print("ERROR FACE:", e)
        return jsonify({'status': 'error', 'message': str(e)})


# ================= VERIFY =================
@app.route('/verify', methods=['POST'])
def verify():
    user_id = str(request.json.get('user_id'))
    image_np = base64_to_image(request.json.get('image'))

    if user_id not in database:
        return jsonify({'status': 'not_registered'})

    if image_np is None:
        return jsonify({'status': 'error', 'message': 'Gambar tidak valid'})

    try:
        # 🔥 paksa format lagi sebelum dlib
        face_locations = face_recognition.face_locations(image_np)

        if len(face_locations) == 0:
            return jsonify({'status': 'error', 'message': 'Wajah tidak terdeteksi'})

        encodings = face_recognition.face_encodings(image_np, face_locations)

        saved = np.array(database[user_id])
        current = encodings[0]

        distance = np.linalg.norm(saved - current)

        print("DISTANCE:", distance)

        if distance < 0.6:
            return jsonify({'status': 'match'})
        else:
            return jsonify({'status': 'not_match'})

    except Exception as e:
        print("ERROR VERIFY:", e)
        return jsonify({'status': 'error', 'message': str(e)})


# ================= RUN =================
if __name__ == '__main__':
    app.run(debug=True)