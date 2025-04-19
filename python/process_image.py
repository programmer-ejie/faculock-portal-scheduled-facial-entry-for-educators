import sys
import json
import pickle
import numpy as np
from sklearn.metrics.pairwise import cosine_similarity
from keras_facenet import FaceNet
import cv2
from PIL import Image
import os
import io
import logging

# Suppress TensorFlow logs
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '3'
os.environ['TF_ENABLE_ONEDNN_OPTS'] = '0'  # Disable oneDNN optimizations
logging.getLogger('tensorflow').setLevel(logging.ERROR)

# Redirect stderr to avoid printing TensorFlow logs
sys.stderr = open(os.devnull, 'w')

# Force UTF-8 encoding for standard input/output
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

try:
    # Initialize FaceNet
    embedder = FaceNet()

    # Cache embeddings in memory
    embeddings_path = '../embeddings/user_embeddings.pkl'
    if 'embedding_db' not in globals():
        if not os.path.exists(embeddings_path):
            raise FileNotFoundError(f"Embeddings file not found: {embeddings_path}")
        with open(embeddings_path, 'rb') as f:
            embedding_db = pickle.load(f)

    # Haar cascade for face detection
    face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')

    # Load the captured frame
    if len(sys.argv) < 2:
        raise ValueError("Image path argument is missing")

    image_path = sys.argv[1]
    frame = cv2.imread(image_path)

    if frame is None:
        raise ValueError(f"Failed to load image from {image_path}")

    # Resize the frame to a smaller resolution for faster processing
    frame = cv2.resize(frame, (320, 240))  # Resize to 320x240 for faster processing

    # Invert the captured frame horizontally
    inverted_frame = cv2.flip(frame, 1)

    # Save the inverted captured frame
    captured_frame_path = '../captured_frames/captured_frame_inverted.png'
    cv2.imwrite(captured_frame_path, inverted_frame)

    # Convert to grayscale for face detection
    gray = cv2.cvtColor(inverted_frame, cv2.COLOR_BGR2GRAY)

    # Optimize face detection parameters
    faces = face_cascade.detectMultiScale(
        gray,
        scaleFactor=1.2,  # Slightly increase scaleFactor for faster detection
        minNeighbors=3,   # Reduce minNeighbors for faster detection
        minSize=(30, 30)  # Set a minimum face size to skip small regions
    )

    if len(faces) == 0:
        print(json.dumps({'error': 'No faces detected in the image'}))
        sys.exit(0)

    results = []
    for (x, y, w, h) in faces:
        # Crop the face region
        face_img = inverted_frame[y:y+h, x:x+w]
        face_pil = Image.fromarray(cv2.resize(face_img, (160, 160))).convert('RGB')

        # Generate embeddings for the cropped face
        embedding = embedder.embeddings([np.array(face_pil)])[0]

        # Compare embeddings with the database
        similarities = {name: cosine_similarity([embedding], [ref])[0][0] for name, ref in embedding_db.items()}
        best_match = max(similarities, key=similarities.get)
        confidence = similarities[best_match]

        # Determine if the face is authorized
        if confidence >= 0.7:
            label = f"{best_match} ({confidence:.2f})"
            color = (0, 255, 0)  # Green for authorized
        else:
            label = f"Unauthorized ({confidence:.2f})"
            color = (0, 0, 255)  # Red for unauthorized

        # Draw bounding box and label on the original frame
        cv2.rectangle(inverted_frame, (x, y), (x+w, y+h), color, 2)
        cv2.putText(inverted_frame, label, (x, y-10), cv2.FONT_HERSHEY_SIMPLEX, 0.8, color, 2)

        # Append the result
        results.append({
            'label': label,
            'confidence': float(confidence)  # Convert float32 to native Python float
        })

    # Save the inverted processed frame
    processed_frame_path = '../captured_frames/processed_frame_inverted.png'
    cv2.imwrite(processed_frame_path, inverted_frame)

    # Return results as JSON
    print(json.dumps({'prediction': results}))

except Exception as e:
    # Log the error and return it
    error_log_path = '../logs/python_error.log'
    with open(error_log_path, 'a') as log_file:
        log_file.write(f"Error: {str(e)}\n")
    print(json.dumps({'error': str(e)}))