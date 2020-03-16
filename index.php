<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Motion Detection
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
    name='viewport' />
  <link rel="stylesheet" type="text/css"
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <link href="assets/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
  <link href="assets/demo/demo.css" rel="stylesheet" />
  <link href="js/toastr.min.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="assets/img/sidebar-1.jpg">
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          MOTION DETECTION
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav" style="text-align: center;">
          <li class="nav-item active ">
            <a class="nav-link">
              <i class="material-icons">person</i>
              <p>Main Control Panel</p>
            </a>
          </li>
          <li class="nav-item active ">
            <div>
              <br><br>
              <!-- <div class="input-group mb-8" style="padding-right: 15px;">
                <div class="input-group-prepend">
                  <span class="input-group-text">Count of Point</span>
                </div>
                <input type="number" id="ct_v" min=2 max=8 class="form-control text-right" placeholder="(H)"/>
                <input type="number" id="ct_h" min=2 max=8 class="form-control text-right" placeholder="(V)"/><br>
              </div><br> -->
              <!-- <button class="btn btn-primary" type="button" style="width:50%;" id="btn_create"
                onclick="createArea(event);">Create Area</button> -->
              <div>
                <div class="input-group mb-8" style="padding-right: 15px;">
                <div class="input-group-prepend">
                  <span class="input-group-text">Pre Time</span>
                </div>
                <input type="number" id="freetime" min=3 max=20 class="form-control text-right" value=5 />
                <span class="input-group-text">sec</span>
              </div><br>
                <div class="input-group mb-8" style="padding-right: 15px;">
                <div class="input-group-prepend">
                  <span class="input-group-text">Post Time</span>
                </div>
                <input type="number" id="posttime" min=3 max=20 class="form-control text-right" value=4 />
                <span class="input-group-text">sec</span>
              </div><br>
              

                <span id="ex6Val"></span><br>
                <input type="range" class="custom-range" style="width:90%" min="0" max="100" step="1" id="ex6"
                  value="100" onchange="setSense();" onmousewheel="setSense();" oninput="setSense();">
              </div>
              <br><br>
              <div>
                <label>
                  <input type="checkbox" checked="checked" name="remember" id="allowrec"> Allow Uploading Files to Server
                </label>
                <div>
                <button class="btn btn-success" type="button" style="width:50%;" id="btn_start"
                onclick="startCapture(event)">Save</button></div> 
                <br><br>
                <!-- <p><button type="button" class="btn btn-primary" style="width:40%;">Send</button></p> -->
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="#pablo">Motion Detection & Recording to Server</a>
          </div>
          <div class="collapse navbar-collapse justify-content-end">
            <form class="navbar-form" style="display: none;">
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div>
            </form>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <div class="container" style="text-align: center;">
            <div>
              <div class="row" style="padding-right: 100px;">
                <div style="text-align: center;">
                  <h6>Detect</h6>
                  <video id="webcam-input" autoplay width="800" height="500"
                    style="display: none;position: absolute;z-index: 100;"></video>
                  <canvas id="canvas-source" width="800" height="500"
                    style="display: block;position: absolute;z-index: 101; border-style:solid; border-radius: 5px;"></canvas>
                  <canvas id="canvas-blended" width="800" height="500"
                    style="display: block;position: absolute;z-index: 102; border-style: inset; border-radius: 5px;opacity:0.5;"></canvas>
                  <!-- <canvas id="mycanvas" width="800" height="500"
                    style="display: block;position: absolute;z-index: 103;opacity: 0.7; border-style: inset; border-radius: 5px;"
                    onMouseUp="mouseUp(event);" onMouseDown="getPoint(event);" onMouseMove="drawDrag(event);"
                    draggable="true"></canvas> -->
                  <canvas id="mycanvas" width="800" height="500"
                    style="display: block;position: absolute;z-index: 103;opacity: 0.7; border-style: inset; border-radius: 5px;"
                    onclick="clickArea(event);"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="assets/js/plugins/moment.min.js"></script>
  <script src="assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <script src="assets/js/plugins/bootstrap-tagsinput.js"></script>
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <script src="assets/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
  <script src="assets/demo/demo.js"></script>
   <script src="js/toastr.min.js"></script>
  <!-- record -->
  <script src="js/RecordRTC.js"></script>
  <script src="js/gif-recorder.js"></script>
  <script src="js/getScreenId.js"></script>
  <script src="js/DetectRTC.js"> </script>
  <script src="js/concatenateblobs.js"> </script>
  
  <!-- for Edige/FF/Chrome/Opera/etc. getUserMedia support -->
  <script src="js/adapter-latest.js"></script>



  <script>
    var poly = [];
    var maxX = 800;
    var minX = 0;
    var maxY = 500;
    var minY = 0;
    var prevtime = 3;
    var width = 800;
    var height = 500;
    var falseIndex = 0;
    var trueIndex = 0;
    var firstDecIndex = 0;
    var detectTimeIndex = 0;
    var detectFlag = false;
    var flag = false;
    var postsec = 3;
    var decSureFlag = false;
    var detectTimeIndex;
    var intervalObj;
    var firstintervalObj;
    var canvas = document.getElementById("mycanvas");
    var ctx = canvas.getContext('2d');
    var index = -1;
    var videoEl = getElById("webcam-input");
    var videoHeight = videoEl.height;
    var videoWidth = videoEl.width;
    var canvasSource = getElById("canvas-source");
    var canvasBlended = getElById("canvas-blended");
    var contextSource = canvasSource.getContext('2d');
    var contextBlended = canvasBlended.getContext('2d');
    var bestCounts = [];
    var bestPixelPositions = [];
    var listOfFilesUploaded = [];
    var button;
    var firstblob;
    blendedImageData = contextBlended.createImageData(width, height);
    lastImageData = contextSource.getImageData(minX, minY, width, height);
    var recorder;
    
    var commonConfig = {};
    $( document ).ready(function()
    {
      //$('#ct_v').val(2);        
      //$('#ct_h').val(2);
      $('#ex6').val(75);
      button = getElById('#btn_start');
      setSense();
      start();
      recordstart();
    });

    function startCapture(event)
    {
      flag = true;
      //$('#btn_create').attr('disabled', false);
      //$('#btn_start').attr('disabled', true);
      if(poly.length === 0)
      {
        toastr.warning('The capture area has not yet been determined.','Warning');
        return;
      }
      postsec = $('#posttime').val();
      var innerTxt = $('#btn_start').text();
      if(innerTxt === "Reset")
      {
        // clearInterval(intervalObj);
        // //recordstop();
        // $('#btn_start').html("Start");
        window.location.reload();
      }
      if(innerTxt === "Save")
      {
        var polyX = [], polyY = [];
        for(index=0;index < poly.length; index++ )
        { 
          if(index%2 == 0)
          {
             polyX.push(poly[index]);   
          } else 
          {
             polyY.push(poly[index]);                      
          }
        }
        maxX = Math.max.apply(null, polyX);
        minX = Math.min.apply(null, polyX);
        maxY = Math.max.apply(null, polyY);
        minY = Math.min.apply(null, polyY);
        width = maxX - minX;
        height = maxY - minY;
        blendedImageData = contextBlended.createImageData(width, height);
        lastImageData = contextSource.getImageData(minX, minY, width, height);
        start();
        prevtime = $('#freetime').val();
        if($('#allowrec').prop('checked') === true)
        {
          recordstart();
          firstintervalObj = setInterval(recordfirststop, prevtime*1000);
          intervalObj = setInterval(motionDetect, 200);
        }
        $('#btn_start').html("Reset");
      }
    } 

    function motionDetect()
    {
      if(detectFlag) 
      {
        falseIndex = 0;
        trueIndex ++;
      }
      if(!detectFlag) 
      {
          falseIndex++;
          trueIndex = 0;
      }
      if(trueIndex == 1)
      {
        if(decSureFlag === false)
        {
          clearInterval(firstintervalObj);
          recordstart();
          decSureFlag = true;
          trueIndex = 0;
          return;
        }
      }
      if(detectTimeIndex > 265 && detectFlag === false) //Recording....
      {
          recordstop();
          falseIndex = 0;
          decSureFlag = false;
          detectTimeIndex = 0;
          return;
      }
      if(falseIndex > Math.round(30*postsec/3))
      {
        if(decSureFlag === true)
        {
         recordstop();
          falseIndex = 0;
          decSureFlag = false;
          detectTimeIndex = 0;
          return;
        }
      }
      if(decSureFlag === true)
        detectTimeIndex++;
    }
    function recordstart()
    {
        var config = {
          mimeType: 'video/webm', // vp8, vp9, h264, mkv, opus/vorbis
          audioBitsPerSecond : 256 * 8 * 1024,
          videoBitsPerSecond : 256 * 8 * 1024,
          bitsPerSecond: 256 * 8 * 1024,  // if this is provided, skip above two
          checkForInactiveTracks: true,
          timeSlice: 300, // concatenate intervals based blobs
          ondataavailable: function(e) {
          } // get intervals based blobs
      }
      if(videoEl.srcObject === null) return;
      recorder = new MediaStreamRecorder(videoEl.srcObject, config);
      recorder.record();
    }

    function recordfirststop()
    {
        if(videoEl.srcObject === null) return;
        firstblob = [];
        recorder.stop(function(blob) {
        firstblob = recorder.blob;
        console.log('FirstBolb');
        console.log(firstblob);
        recordstart();
        });
    } 


    function recordstop()
    {
        firstDecIndex++;
        recorder.stop(function(blob) {
        var blob = recorder.blob;
        uploadToServer(recorder, function(progress, fileURL) {
                        if(progress === 'ended') {
                            return;
                        }
              });
        });
        //clearInterval(intervalObj);
    }
    function uploadToServer(recordRTC, callback) {
        var blob = recordRTC instanceof Blob ? recordRTC : recordRTC.blob;
        console.log("REAL");
        console.log(blob);
        if(firstDecIndex == 1)
        {
          console.log("FIRST");
          console.log(firstblob);
          ConcatenateBlobs([firstblob, blob], 'video/webm', function(resultingBlob) {
            blob = resultingBlob;
            console.log("LAST");
            console.log(blob);
          });
        }
        var fileType = blob.type.split('/')[0] || 'audio';
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();

        if(dd<10) {
            dd = '0'+dd
        } 

        if(mm<10) {
            mm = '0'+mm
        } 
        var curdate = mm + '-' + dd + '-' + yyyy;
        var curtime = today.getHours() + "-" + today.getMinutes() + "-" + today.getSeconds();
        var fileName =curdate + '_' + curtime;

        if (fileType === 'audio') {
            fileName += '.' + (!!navigator.mozGetUserMedia ? 'ogg' : 'wav');
        } else {
            fileName += '.webm';
        }
        toastr.success(fileName + ' is uploaded!', 'Success')
        // create FormData
        var formData = new FormData();
        formData.append(fileType + '-filename', fileName);
        formData.append(fileType + '-blob', blob);

        callback('Uploading ' + fileType + ' recording to server.');

        // var upload_url = 'https://your-domain.com/files-uploader/';
        var upload_url = 'save.php';

        // var upload_directory = upload_url;
        var upload_directory = 'uploads/';
        makeXMLHttpRequest(upload_url, formData, function(progress) {
            if (progress !== 'upload-ended') {
                callback(progress);
                return;
            }

            callback('ended', upload_directory + fileName);

            // to make sure we can delete as soon as visitor leaves
            listOfFilesUploaded.push(upload_directory + fileName);
        });
    }

    function makeXMLHttpRequest(url, data, callback) {
        var request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                callback('upload-ended');
            }
        };

        request.upload.onloadstart = function() {
            callback('Upload started...');
        };

        request.upload.onprogress = function(event) {
            callback('Upload Progress ' + Math.round(event.loaded / event.total * 100) + "%");
        };

        request.upload.onload = function() {
            callback('progress-about-to-end');
        };

        request.upload.onload = function() {
            callback('progress-ended');
        };

        request.upload.onerror = function(error) {
            callback('Failed to upload to server');
            console.error('XMLHttpRequest failed', error);
        };

        request.upload.onabort = function(error) {
            callback('Upload aborted.');
            console.error('XMLHttpRequest aborted', error);
        };

        request.open('POST', url);
        request.send(data);
    }

    // window.onbeforeunload = function() {
        
    //     if(!listOfFilesUploaded.length) return;

    //     var delete_url = 'delete.php';
    //     // var delete_url = 'RecordRTC-to-PHP/delete.php';

    //     listOfFilesUploaded.forEach(function(fileURL) {
    //         var request = new XMLHttpRequest();
    //         request.onreadystatechange = function() {
    //             if (request.readyState == 4 && request.status == 200) {
    //                 if(this.responseText === ' problem deleting files.') {
    //                     alert('Failed to delete ' + fileURL + ' from the server.');
    //                     return;
    //                 }

    //                 listOfFilesUploaded = [];
    //                 alert('You can leave now. Your files are removed from the server.');
    //             }
    //         };
    //         request.open('POST', delete_url);

    //         var formData = new FormData();
    //         formData.append('delete-file', fileURL.split('/').pop());
    //         request.send(formData);
    //     });

    //     return 'Please wait few seconds before your recordings are deleted from the server.';
    // };

    function getElById(id) {
      return document.getElementById(id);
    }

    function clickArea(event) {
      var rect = canvas.getBoundingClientRect();
        var x = event.x - rect.left;
        var y = event.y - rect.top;
        poly.push(x);
        poly.push(y);
        drawPoly();
    }
    // function createArea(event) {
    //   canvas.style.display = "block";
    //   $('#btn_create').attr('disabled', true);
    //   $('#btn_start').attr('disabled', false);
    //   poly = [];

    //   var ct_v = document.getElementById("ct_v").value;
    //   vStep = canvas.width / (ct_v - 1);
    //   var ct_h = document.getElementById("ct_h").value;
    //   hStep = canvas.height / (ct_h - 1);
    //   for (i = 0; i < ct_v; i++) {
    //     poly.push(vStep * i);
    //     poly.push(0);
    //   }
    //   for (i = 1; i < ct_h; i++) {
    //     poly.push(canvas.width);
    //     poly.push(hStep * i);
    //   }
    //   for (i = ct_v - 2; i >= 0; i--) {
    //     poly.push(vStep * i);
    //     poly.push(canvas.height);
    //   }
    //   for (i = ct_h - 2; i > 0; i--) {
    //     poly.push(0);
    //     poly.push(hStep * i);
    //   }
    //   drawPoly();
    // }

    // function drawDrag(event) {
    //   var x = event.x;
    //   var y = event.y;
    //   var rect = canvas.getBoundingClientRect();
    //   poly[index * 2] = x - rect.left;
    //   poly[index * 2 + 1] = y - rect.top;
    //   drawPoly();
    // }

    function getPoint(event) {
      var rect = canvas.getBoundingClientRect();
      var x = event.x - rect.left;
      var y = event.y - rect.top;
      for (i = 0; i < poly.length / 2; i++) {
        if (Math.abs(poly[i * 2] - x) <= 7 & Math.abs(poly[i * 2 + 1] - y) <= 7) {
          poly[i * 2] = x;
          poly[i * 2 + 1] = y;
          index = i;
          drawPoly();
        }
      }
    }

    // function mouseUp(event) {
    //   index = -1;
    //   drawPoly();
    // }

    function drawPoly() {
      if(flag) return false;
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      ctx.fillStyle = '#green';
      ctx.beginPath();
      ctx.lineWidth = 3;
      ctx.strokeStyle = '#2D8BB5';
      var item = 0;
      for (item = 0; item < poly.length - 1; item += 2) {
        ctx.lineTo(poly[item], poly[item + 1]);
        ctx.fillStyle = '#5BA1CA';
        ctx.stroke();
        item = item;
      }
      ctx.lineTo(poly[item + 1], poly[0]);
      ctx.fillStyle = '#5BA1CA';
      ctx.fill();
      ctx.stroke();
      ctx.strokeStyle = 'white';
      for (item = 0; item < poly.length - 1; item += 2) {
        ctx.beginPath();
        ctx.arc(poly[item], poly[item + 1], 7, 0, 2 * Math.PI, false);
        ctx.fillStyle = '#2D8BB5';
        ctx.fill();
        ctx.stroke();
        ctx.closePath();
      }

    }
    // canvas.addEventListener("mousedown", onMouseDown, false);
    // canvas.addEventListener("mouseup", onMouseUp, false);
    // canvas.addEventListener("mousemove", onMouseMove, false);

    // // var mouseDown = false;
    // function onMouseDown(e) {
    //   // mouseDown = true;
    //   // e.stopPropagation();
    // }
    // function onMouseUp(e) {
    //   // mouseDown = false;
    //   // e.stopPropagation();
    // }
    // function onMouseMove(e) {
    //   // e.stopPropagation();
    //   // if (!mouseDown) return;
    // }

    function setSense() {
      var sid = document.getElementById("ex6").value;
      var sVal = document.getElementById("ex6Val");
      sVal.innerHTML = "";
      sVal.innerHTML = "Sensitivity Level:" + sid + "%";
      $( "#canvas-blended" ).fadeTo( "fast" , sid / 100, function() {});
    }

  </script>
<script src="js/motiontracking.js"></script>
</body>

</html>