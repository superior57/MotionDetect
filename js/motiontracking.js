	function start()
	{
		contextSource.translate(canvasSource.width, 0);
		contextSource.scale(-1, 1);

		var getUserMediaName;
		var gumFnNames = ['getUserMedia', 'mozGetUserMedia', 'webkitGetUserMedia', 'msGetUserMedia']
		if (!gumFnNames.some(function (fnName) {
			if (typeof navigator[fnName] === 'function') {
				getUserMediaName = fnName;
				return true;
			}
			return false;
		})) {
			alert('Your browser does not support the "getUSerMedia" API, boo! Try Firefox.');
			return;
		}
		navigator[getUserMediaName]({ audio: false, video: true }, webcamSuccess, webcamError);
	}
	
	function webcamError(error) {
		console.error("Webcam error:", error);
	}

	function webcamSuccess(stream) {
		//videoEl.src = window.URL.createObjectURL(stream);
		videoEl.srcObject = stream;

		// Loop away!
		window.requestAnimationFrame(recursiveCanvasUpdate);
	}

	function differenceSimple(blendTarget, data1, data2) {
		var numIterations,
			iteration,
			diffRed,
			diffGreen,
			diffBlue,
			change,
			oldChange,
			detectionThreshold = 0.05 * 0xFF,
			lastBestPixelPosition = 0,
			lastBestCount = 1,
			currentPossbiblePixelPostion = false,
			currentBestCount = 0,
			bestPosition,
			numPointsToTrack = 10,
			pointIterator,
			numPoints,
			pointLimit,
			x,
			y,
			pixelPosition,
			arrayPosition,
			crossSize,
			crossOffset,
			crossPixelX,
			crossPixelY;

		if (data1.length != data2.length) return null;

		// reset last best position arrays
		bestCounts = [];
		bestPixelPositions = [];

		numIterations = width * height;

		pixelPosition = numIterations;
		while (pixelPosition--) {

			arrayPosition = pixelPosition * 4;

			// Temporarily ignore the green channel which is being used to mark the biggest motion density.
			// TODO Re-instate the outputbuffer, use that for the marker, and start measuring the green channel again.
			diffRed = data1[arrayPosition] - data2[arrayPosition];
			diffGreen = data1[arrayPosition + 1] - data2[arrayPosition + 1];
			diffBlue = data1[arrayPosition + 2] - data2[arrayPosition + 2];
			change = (diffRed + diffGreen + diffBlue) / 3;

			// Track positive and negative brightness changes.
			if (change < 0) change = -change;

			oldChange = blendTarget[arrayPosition];

			// Do not propagate changes below a threshold.
			if (change < detectionThreshold) {

				// If there is a new candidate for the densest linear custer of difference then store it.
				if (currentBestCount > lastBestCount) {
					lastBestCount = currentBestCount;
					lastBestPixelPosition = currentPossbiblePixelPostion;

					bestCounts.push(lastBestCount);
					bestPixelPositions.push(lastBestPixelPosition);
				}

				// Reset the count for the next detection.
				currentBestCount = 0;
				currentPossbiblePixelPostion = false;

			} else {

				// If there is no candidate for densest difference position store this starting point.
				if (!currentPossbiblePixelPostion) currentPossbiblePixelPostion = pixelPosition;

				// Up the count weighted by the percentage change.
				currentBestCount += (change / 0xFF);
			}

			// Preserve the difference for the next iteration.
			blendTarget[arrayPosition] = change;
			blendTarget[arrayPosition + 1] = change;
			blendTarget[arrayPosition + 2] = change;
			blendTarget[arrayPosition + 3] = 0xFF;
		}


		/*
		 * Mark the point of densest linear difference signal for this frame.
		 */

		// Loop over the best N (numPointsToTrack) detections.
		numPoints = bestPixelPositions.length;
		if (numPoints > numPointsToTrack) {
			pointLimit = numPoints - numPointsToTrack;
		} else {
			pointLimit = numPoints;
		}

		for (pointIterator = numPoints; pointIterator > pointLimit; pointIterator -= 1) {

			bestPosition = bestPixelPositions[pointIterator];

			// Extract the x and y co-ordinates from the linear pixel position.
			x = bestPosition % width;
			y = Math.floor(bestPosition / width);

			crossSize = 30;
			crossOffset = parseInt(crossSize * 0.5, 10);
			iteration = crossSize;
			while (iteration--) {
				crossPixelX = (x - crossOffset + iteration) + y * width;
				crossPixelY = x + (y - crossOffset + iteration) * width;
				blendTarget[crossPixelX * 4] = 0;
				blendTarget[crossPixelX * 4 + 1] = 0xFF;
				blendTarget[crossPixelX * 4 + 2] = 0;
				blendTarget[crossPixelY * 4] = 0;
				blendTarget[crossPixelY * 4 + 1] = 0xFF;
				blendTarget[crossPixelY * 4 + 2] = 0;
			}
		}
	}

	function checkHotspots() {

		// get the pixels in a note area from the blended image
		var blendedData = contextBlended.getImageData(minX, minY, width, height);

		// calculate the average lightness of the blended data
		var i = 0;
		var sum = 0;
		var countPixels = blendedData.data.length * 0.25;
		while (i < countPixels) {
			sum += (blendedData.data[i * 4] + blendedData.data[i * 4 + 1] + blendedData.data[i * 4 + 2]);
			++i;
		}
		// calculate an average between of the color values of the note area [0-255]
		var average = sum / (3 * countPixels);
		if (average > 0.1) // more than 20% movement detected
		{
			 detectFlag = true;
		} else {
			 detectFlag = false;
		}

	}


	function getBlendedVideoData() {

		// get webcam image data
		sourceImageData = contextSource.getImageData(minX, minY, width, height);

		// blend the 2 images, operations by reference
		differenceSimple(blendedImageData.data, sourceImageData.data, lastImageData.data);

		// store the current webcam image
		lastImageData = sourceImageData;

		return blendedImageData;
	}

	function drawOriginalVideo() {
		contextSource.drawImage(videoEl, 0, 0, videoWidth, videoHeight);
	}

	function drawBlendedVideo() {
		contextBlended.putImageData(getBlendedVideoData(), minX, minY);
	}

	function recursiveCanvasUpdate() {
		drawOriginalVideo();
		drawBlendedVideo();
		checkHotspots();
		window.requestAnimationFrame(recursiveCanvasUpdate);
	}
