<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>SCG - Quay thưởng</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="d58Et_hG0KrLc6xKv03J8U5NA6jqak0kCFxBaz7Y1MM"/>
    <link rel="icon" href="../images/logo.svg">
    <link rel="apple-touch-icon" sizes="180x180" href="../images/logo.svg">
    <link rel="icon" type="image/png" sizes="32x32" href="../images/logo.svg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css">
    <link
            href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&amp;display=swap"
            rel="stylesheet">
    <link rel="stylesheet" href="../css/jquery-ui.min.css">
    <link rel="stylesheet" href="../css/app.css">
</head>

<body>
<div class="container-machine js-container">
    <canvas id="canvas" hidden></canvas>
    <div id="logo">
        <img src="../images/logo.svg" alt="logo">
    </div>
    <div class="slotwrapper" id="spinner"></div>
    <div>
        <button type="button" class="btn mt-3 btn-lg btn-toggle" id="btn-start">Bắt đầu quay</button>
    </div>

    <div id="prize-container"></div>


</div>

<div class="modal fade" id="congratsModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center border-bottom-0">
                <h5 class="modal-title fw-semibold fs-3 align-self-center" id="staticBackdropLabel">Chúc mừng</h5>
            </div>
            <div class="modal-body">
                <div id="congratsText" class="fs-4 fw-medium text"></div>
            </div>
            <div class="modal-footer justify-content-center border-top-0">
                <button type="button" onclick="hideCanvas()" class="btn btn-primary align-self-center" data-bs-dismiss="modal">Tiếp tục
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="notiModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-center border-bottom-0">
                <h5 class="modal-title align-self-center" id="staticBackdropLabel">Thông báo</h5>
            </div>
            <div class="modal-body">
                <div id="notiText"></div>
            </div>
            <div class="modal-footer justify-content-center border-top-0">
                <button type="button" class="btn btn-primary align-self-center" data-bs-dismiss="modal">Đóng
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="../js/slotmachine.js"></script>
<script src="../js/jquery-ui.js"></script>

<script type="text/javascript">
    let isSpinning = false;
    let slotArrays = [];
    let isFirstSpin = true;
    let charArray = ['\u00a0', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

    let agencies = @json($event->agencies);
    let prizes = @json($event->prizes);

    let sound = new Audio('../ringtones/rolling.mp3');
    // let sound = new Audio('../ringtones/spinning.mp3');
    let ding = new Audio('../ringtones/ding.wav');
    let congratsSound = new Audio('../ringtones/congrats.mp3');

    sound.addEventListener('ended', function () {
        this.currentTime = 0;
        this.play();
    }, false);

    $(document).ready(function () {
        let initialChars = 'scg prize spinner'.toUpperCase().replace(/ /g, '\u00a0').split('');
        for (let i = 0; i < initialChars.length; i++) {
            let $slotbox = $('<div>').addClass('slotbox').appendTo('#spinner');
            let $ul = $('<ul>').appendTo($slotbox);

            let slotArray = [initialChars[i]].concat(charArray);

            slotArrays.push(slotArray);
            // $('<li>').html('&nbsp;').appendTo($ul);

            for (let j = 0; j < slotArray.length; j++) {
                $('<li>').text(slotArray[j]).appendTo($ul);
            }
        }

    });

    $('.btn-toggle').click(function () {
        if (isSpinning) {
            stopSpin();
        } else {
            startSpin();
        }
    });

    function startSpin() {
        if (agencies.length === 0) {
            $('#notiText').text('Đã quay hết tất cả các đại lý');
            $('#notiModal').modal('show');
            return;
        }

        $('.btn-toggle').text('Dừng quay').attr('id', 'btn-stop');

        if (isFirstSpin) {
            $('#spinner ul li:first-child').remove();
            isFirstSpin = false;
        }

        let randomIndex = Math.floor(Math.random() * agencies.length);
        let agency = agencies[randomIndex]
        let resultString = agency.agency_id;
        let agencyName = agency.agency_name;

        agencies.splice(randomIndex, 1);

        let result = [];
        for (let i = 0; i < resultString.length; i++) {
            let index = charArray.indexOf(resultString[i]);
            if (index !== -1) {
                result.push(index + 1);
            }
        }

        while (result.length < 17) {
            result.unshift(1);
        }

        sound.play();
        isSpinning = true;
        $('#btn-stop').prop('disabled', false);
        $('#btn-start').prop('disabled', true);
        $('#spinner ul').playSpin({
            stopSeq: 'leftToRight',
            manualStop: true,
            easing: 'easeOutBack',
            useStopTime: true,
            stopTime: 1500,
            endNum: result,
            time: 900,
            onEnd: function () {
                ding.play();
            },
            onFinish: function () {
                sound.pause();
                congratsSound.play();
                isSpinning = false;
                showCanvas();
                $('#congratsText').text(`Chúc mừng đại lý ${agencyName} đã trúng thưởng`);
                $('#congratsModel').modal('show');
                $('#btn-start').prop('disabled', false);
            }
        });
    }

    function stopSpin() {
        $('#spinner ul').stopSpin();
        $('.btn-toggle').text('Bắt đầu quay').attr('id', 'btn-start');
        $('#btn-start').prop('disabled', true);
    }

    let W = window.innerWidth;
    let H = window.innerHeight;
    const canvas = document.getElementById("canvas");
    const context = canvas.getContext("2d");
    const maxConfettis = 150;
    const particles = [];

    const possibleColors = [
        "DodgerBlue",
        "OliveDrab",
        "Gold",
        "Pink",
        "SlateBlue",
        "LightBlue",
        "Gold",
        "Violet",
        "PaleGreen",
        "SteelBlue",
        "SandyBrown",
        "Chocolate",
        "Crimson"
    ];

    function randomFromTo(from, to) {
        return Math.floor(Math.random() * (to - from + 1) + from);
    }

    function confettiParticle() {
        this.x = Math.random() * W; // x
        this.y = Math.random() * H - H; // y
        this.r = randomFromTo(11, 33); // radius
        this.d = Math.random() * maxConfettis + 11;
        this.color =
            possibleColors[Math.floor(Math.random() * possibleColors.length)];
        this.tilt = Math.floor(Math.random() * 33) - 11;
        this.tiltAngleIncremental = Math.random() * 0.07 + 0.05;
        this.tiltAngle = 0;

        this.draw = function() {
            context.beginPath();
            context.lineWidth = this.r / 2;
            context.strokeStyle = this.color;
            context.moveTo(this.x + this.tilt + this.r / 3, this.y);
            context.lineTo(this.x + this.tilt, this.y + this.tilt + this.r / 5);
            return context.stroke();
        };
    }

    function showCanvas() {
        $('#canvas').removeAttr('hidden');
    }

    function hideCanvas() {
        $('#canvas').attr('hidden', true);
    }

    function Draw() {
        const results = [];

        // Magical recursive functional love
        requestAnimationFrame(Draw);

        context.clearRect(0, 0, W, window.innerHeight);

        for (var i = 0; i < maxConfettis; i++) {
            results.push(particles[i].draw());
        }

        let particle = {};
        let remainingFlakes = 0;
        for (var i = 0; i < maxConfettis; i++) {
            particle = particles[i];

            particle.tiltAngle += particle.tiltAngleIncremental;
            particle.y += (Math.cos(particle.d) + 3 + particle.r / 2) / 2;
            particle.tilt = Math.sin(particle.tiltAngle - i / 3) * 15;

            if (particle.y <= H) remainingFlakes++;

            // If a confetti has fluttered out of view,
            // bring it back to above the viewport and let if re-fall.
            if (particle.x > W + 30 || particle.x < -30 || particle.y > H) {
                particle.x = Math.random() * W;
                particle.y = -30;
                particle.tilt = Math.floor(Math.random() * 10) - 20;
            }
        }

        return results;
    }

    window.addEventListener(
        "resize",
        function() {
            W = window.innerWidth;
            H = window.innerHeight;
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        },
        false
    );

    // Push new confetti objects to `particles[]`
    for (var i = 0; i < maxConfettis; i++) {
        particles.push(new confettiParticle());
    }

    // Initialize
    canvas.width = W;
    canvas.height = H;
    Draw();


</script>
</body>
</html>
