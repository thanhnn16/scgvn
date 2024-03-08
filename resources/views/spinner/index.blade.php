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
        <a href="/"><img src="../images/logo-scg.png" alt="logo"></a>
    </div>
    <div id="event_text">
        <img src="../images/qsmm.png" alt="logo">
    </div>
    <div class="slotwrapper" id="spinner"></div>
    <div>
        <button type="button" class="btn mt-5 mb-5 btn-lg btn-toggle" id="btn-start">Bắt đầu quay</button>
    </div>

    <div id="prize-container" class="mt-5 px-5">
        <div class="prize-list d-flex justify-content-between">
                        @foreach($event->prizes as $prize)
                            <div class="card prize-box mx-3 p-4">
                                <div class="prize-item">
                                    <div class="prize-name card-title fw-bold">{{ $prize->prize_name }}</div>
                                    <div class="card-body">
                                        <div class="prize-quantity text-center">Còn lại: <span> {{ $prize->prize_qty }} </span> </div>
                                        <div class="prize-quantity">Đại lý trúng giải</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
        </div>
    </div>

    <div class="modal fade" id="congratsModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-center border-bottom-0">
                    <h5 class="modal-title fw-semibold fs-3 align-self-center" id="staticBackdropLabel">Chúc mừng</h5>
                </div>
                <div class="modal-body">
                    <div id="congratsText" class="fs-4 fw-medium text text-center"></div>
                </div>
                <div class="modal-footer justify-content-center border-top-0">
                    <button type="button" onclick="hideCanvas()" class="btn btn-primary align-self-center"
                            data-bs-dismiss="modal">Tiếp tục
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
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="../js/slotmachine.js"></script>
<script src="../js/canvas.js"></script>
<script src="../js/jquery-ui.js"></script>

<script type="text/javascript">

    console.log('Events: ', @json($event));

    let agencies = @json($event->agencies);

    console.log('Agencies: ', agencies)

    let isReady = false;

    let isSpinning = false;
    let slotArrays = [];
    let isFirstSpin = true;
    let charArray = ['\u00a0', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

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
        if (!isReady) {
            $('#notiText').text('Vui lòng chọn giải thưởng trước khi quay');
            $('#notiModal').modal('show');
            return;
        }
        if (agencies.length === 0) {
            $('#notiText').text('Đã hết phần thưởng trong sự kiện lần này. Chúc mừng các đại lý đã trúng thưởng. Vui lòng chờ sự kiện tiếp theo');
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
        let resultString = agency.pivot.agency_id;
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

    $('.card-title').click(function () {
        isReady = true;
        $('.card-title').removeClass('selected_prize');
        $(this).addClass('selected_prize');
    });

</script>
</body>
</html>