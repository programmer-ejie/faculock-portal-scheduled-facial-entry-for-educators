<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>Live Camera | FacuLock</title>
  <!-- [Meta] -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="FacuLock Live Camera for Face Recognition">
  <meta name="keywords" content="FacuLock, Live Camera, Face Recognition, Real-Time Processing">
  <meta name="author" content="FacuLock Team">

  <!-- [Favicon] icon -->
  <link rel="shortcut icon" type="image/png" href="../template/auth/assets/images/logos/seodashlogo.png" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
  <link rel="stylesheet" href="../template/admin/dist/assets/fonts/tabler-icons.min.css">
  <link rel="stylesheet" href="../template/admin/dist/assets/fonts/feather.css">
  <link rel="stylesheet" href="../template/admin/dist/assets/fonts/fontawesome.css">
  <link rel="stylesheet" href="../template/admin/dist/assets/fonts/material.css">
  <link rel="stylesheet" href="../template/admin/dist/assets/css/style.css" id="main-style-link">
  <link rel="stylesheet" href="../template/admin/dist/assets/css/style-preset.css">
</head>
<!-- [Head] end -->

<!-- [Body] Start -->
<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ Pre-loader ] End -->

  <!-- [ Sidebar Menu ] start -->
  <nav class="pc-sidebar">
    <div class="navbar-wrapper">
      <div class="m-header">
        <a href="index.html" class="logo d-flex align-items-center me-auto" style="text-decoration: none;">
          <i class="fas fa-lock me-2" style="font-size: 15px;"></i>
          <span class="sitename" style="font-weight: bolder; font-size: 16px; color: grey; padding-right: 10px;">FacuLock</span>
        </a>
      </div>
      <div class="navbar-content">
        <ul class="pc-navbar">
          <li class="pc-item">
            <a href="livecamera.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-camera"></i></span>
              <span class="pc-mtext">Live Camera</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="dashboard.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
              <span class="pc-mtext">Dashboard</span>
            </a>
          </li>
          <li class="pc-item pc-caption">
            <label>System Functions</label>
            <i class="ti ti-settings"></i>
          </li>
          <li class="pc-item">
            <a href="accounts.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-users"></i></span>
              <span class="pc-mtext">Accounts</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="schedules.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-calendar"></i></span>
              <span class="pc-mtext">Schedules</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="notification.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-bell"></i></span>
              <span class="pc-mtext">User Notification</span>
            </a>
          </li>
          <li class="pc-item">
            <a href="logs.php" class="pc-link">
              <span class="pc-micon"><i class="ti ti-file"></i></span>
              <span class="pc-mtext">Logs</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- [ Sidebar Menu ] end -->

  <!-- [ Header Topbar ] start -->
  <header class="pc-header">
    <div class="header-wrapper">
      <div class="me-auto pc-mob-drp">
        <ul class="list-unstyled">
          <li class="pc-h-item pc-sidebar-collapse">
            <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
        </ul>
      </div>
      <div class="ms-auto">
        <ul class="list-unstyled">
          <li class="dropdown pc-h-item header-user-profile">
            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button">
              <img src="../images/admin.webp" alt="user-image" class="user-avtar">
              <span>Administrator</span>
            </a>
            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
              <a href="../index.php" class="dropdown-item">
                <i class="ti ti-power"></i>
                <span>Logout</span>
              </a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </header>
  <!-- [ Header Topbar ] end -->

  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard/index.html">Admin</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0)">Home</a></li>
                <li class="breadcrumb-item" aria-current="page">Live Camera</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->

      <!-- [ Main Content ] start -->
      <div class="row">
        <!-- Start Live Camera Section -->
        <div class="col-xxl-4">
          <div class="card">
            <div class="card-header">
              <h5>Live Camera Face Recognition</h5>
            </div>
            <div class="card-body pc-component">
              <!-- Video element for live camera feed -->
              <video id="liveCamera" autoplay playsinline class="img-fluid d-block w-100" style="border: 1px solid #ddd; transform: scaleX(-1);"></video>
              <p class="text-muted mt-2">Ensure your browser has access to the camera.</p>
              <canvas id="capturedFrame" class="d-none"></canvas>
              <button id="captureButton" class="btn btn-primary mt-3">Capture Frame</button>
              <p id="predictionResult" class="mt-3"></p>
            </div>
          </div>
        </div>
        <!-- End Live Camera Section -->
      </div>

      <script>
        const videoElement = document.getElementById('liveCamera');
        const canvas = document.getElementById('capturedFrame');
        const context = canvas.getContext('2d');
        const predictionResult = document.getElementById('predictionResult');
        const captureButton = document.getElementById('captureButton');

        // Access the user's webcam and display the live feed in the video element
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
          navigator.mediaDevices
            .getUserMedia({ video: true })
            .then((stream) => {
              videoElement.srcObject = stream;
            })
            .catch((error) => {
              console.error('Error accessing the camera:', error);
              alert('Unable to access the camera. Please check your browser settings.');
            });
        } else {
          alert('Your browser does not support accessing the camera.');
        }

        // Capture frame when the button is clicked
        captureButton.addEventListener('click', () => {
          // Set canvas dimensions to match the video feed
          canvas.width = videoElement.videoWidth;
          canvas.height = videoElement.videoHeight;

          // Draw the current frame from the video feed onto the canvas
          context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);

          // Convert the canvas image to a base64 string
          const imageData = canvas.toDataURL('image/png');

          // Send the captured frame to the server for processing
          console.log('Sending fetch request to server...');
          fetch('../backend/process_faceframe.php', {
  method: 'POST',
  body: JSON.stringify({ image: imageData }),
  headers: {
    'Content-Type': 'application/json',
  },
})
  .then((response) => {
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json();
  })
  .then((data) => {
    console.log('Response from server:', data);
    if (data.error) {
      console.error('Backend error:', data.error);
      predictionResult.textContent = `Error: ${data.error}`;
      if (data.details) {
        console.error('Error details:', data.details);
      }
    } else if (data.prediction && data.prediction.length > 0) {
      const result = data.prediction[0];
      predictionResult.textContent = `Authorized: ${result.label}, Confidence: ${result.confidence.toFixed(2)}`;
    } else {
      predictionResult.textContent = 'No prediction results available.';
    }
  })
  .catch((error) => {
    console.error('Error sending frame to server:', error);
    predictionResult.textContent = 'Error processing the frame. Please check the console for details.';
  });
        });
      </script>
    </div>
  </div>
  <!-- [ Main Content ] end -->

  <footer class="pc-footer">
    <div class="footer-wrapper container-fluid">
      <div class="row">
        <div class="col-sm my-1">
          <p class="m-0">Capstone Project &#9829; By IT301 6 Students</p>
        </div>
      </div>
    </div>
  </footer> 
</body>
<!-- [Body] end -->

</html>