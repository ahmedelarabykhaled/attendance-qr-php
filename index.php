<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Students Qr Code</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .result {
      background-color: green;
      color: #fff;
      padding: 20px;
    }

    .row {
      display: flex;
    }
  </style>
</head>

<body>

  <div class="container-fluid">
    <div class="row">
      <!-- <div class="col-md-6">
        <canvas id="canvas" width="400" height="400">
        </canvas>
      </div> -->

      <div class="col-md-6">
        <div id="clock" class="light">
          <div class="display">
            <div class="weekdays"></div>
            <div class="ampm"></div>
            <div class="alarm"></div>
            <div class="digits"></div>
          </div>
        </div>

        <div class="button-holder">
          <a class="button">Switch Theme</a>
        </div>
      </div>
      <div class="col-md-6">

        <div class="row-ex">
          <div class="col-ex">
            <div style="width:100%;border-radius: 10px;" id="reader">
            </div>
          </div>
          <audio id="myAudio1">
            <source src="arabic-success.mp3" type="audio/ogg">
          </audio>
          <audio id="myAudio2">
            <source src="failes.mp3" type="audio/ogg">
          </audio>

          <div class="col-ex" style="padding:30px;">
            <div>
            <h3>SCAN RESULT</h3>
              <h5>
                Employee name
              </h5>
            </div>
            <form action="">
              <input type="text" name="start" class="input form-control" id="result" onkeyup="showHint(this.value)" placeholder="result here" readonly="" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>






  <!-- JavaScript Includes -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.0.0/moment.min.js"></script>
  <script src="assets/js//main.js"></script>
  <script src="ht.js"></script>
  <script>
    const canvas = document.getElementById("canvas");
    const ctx = canvas.getContext("2d");
    let radius = canvas.height / 2;
    ctx.translate(radius, radius);
    radius = radius * 0.90
    setInterval(drawClock, 1000);

    function drawClock() {
      drawFace(ctx, radius);
      drawNumbers(ctx, radius);
      drawTime(ctx, radius);
    }

    function drawFace(ctx, radius) {
      const grad = ctx.createRadialGradient(0, 0, radius * 0.95, 0, 0, radius * 1.05);
      grad.addColorStop(0, '#333');
      grad.addColorStop(0.5, 'white');
      grad.addColorStop(1, '#333');
      ctx.beginPath();
      ctx.arc(0, 0, radius, 0, 2 * Math.PI);
      ctx.fillStyle = 'white';
      ctx.fill();
      ctx.strokeStyle = grad;
      ctx.lineWidth = radius * 0.1;
      ctx.stroke();
      ctx.beginPath();
      ctx.arc(0, 0, radius * 0.1, 0, 2 * Math.PI);
      ctx.fillStyle = '#333';
      ctx.fill();
    }

    function drawNumbers(ctx, radius) {
      ctx.font = radius * 0.15 + "px arial";
      ctx.textBaseline = "middle";
      ctx.textAlign = "center";
      for (let num = 1; num < 13; num++) {
        let ang = num * Math.PI / 6;
        ctx.rotate(ang);
        ctx.translate(0, -radius * 0.85);
        ctx.rotate(-ang);
        ctx.fillText(num.toString(), 0, 0);
        ctx.rotate(ang);
        ctx.translate(0, radius * 0.85);
        ctx.rotate(-ang);
      }
    }

    function drawTime(ctx, radius) {
      const now = new Date();
      let hour = now.getHours();
      let minute = now.getMinutes();
      let second = now.getSeconds();
      //hour
      hour = hour % 12;
      hour = (hour * Math.PI / 6) +
        (minute * Math.PI / (6 * 60)) +
        (second * Math.PI / (360 * 60));
      drawHand(ctx, hour, radius * 0.5, radius * 0.07);
      //minute
      minute = (minute * Math.PI / 30) + (second * Math.PI / (30 * 60));
      drawHand(ctx, minute, radius * 0.8, radius * 0.07);
      // second
      second = (second * Math.PI / 30);
      drawHand(ctx, second, radius * 0.9, radius * 0.02);
    }

    function drawHand(ctx, pos, length, width) {
      ctx.beginPath();
      ctx.lineWidth = width;
      ctx.lineCap = "round";
      ctx.moveTo(0, 0);
      ctx.rotate(pos);
      ctx.lineTo(0, -length);
      ctx.stroke();
      ctx.rotate(-pos);
    }
  </script>

  <script type="text/javascript">
    function onScanSuccess(qrCodeMessage) {
      document.getElementById("result").value = qrCodeMessage;
      showHint(qrCodeMessage);
      playAudio();

    }

    function onScanError(errorMessage) {
      //handle scan error
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
      "reader", {
        fps: 10,
        qrbox: 250
      });
    html5QrcodeScanner.render(onScanSuccess, onScanError);
  </script>

  <script>
    var x = document.getElementById("myAudio1");
    var x2 = document.getElementById("myAudio2");

    function showHint(str) {
      if (str.length == 0) {
        document.getElementById("txtHint").innerHTML = "";
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET", "gethint.php?q=" + str, true);
        xmlhttp.send();
      }
    }

    function playAudio() {
      x.play();
    }
  </script>
</body>

</html>