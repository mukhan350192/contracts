@include('header')

<div class="container py-lg-5 py-md-4">
    <div class="row align-items-center">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 mt-4">

            <div class="form-control" id="sign" style="display: block;">
                @csrf
                <input type="hidden" value="{{$id}}" id="document_id">
                <input type="hidden" value="{{$phone}}" id="phone">
                <input type="hidden" value="{{$iin}}" id="iin">
                <input type="hidden" value="Мукан" id="name">
                <input type="hidden" value="Раджапов" id="lastName">
                <input type="hidden" value="Кудратулы" id="middleName">

                <h5 class="title-big">Ознакомлайтесь документом и придумайте пароль для личного кабинета. Вы всегда
                    сможете осмотреть свой документ в личном кабинете</h5>
                <div class="form-outline">
                    <a href="{!! $document !!}" class="title-small"><i class="fa fa-check"
                                                                       aria-hidden="true"></i> {{$name}}</a>
                </div>
                <button type="submit" id="button" class="btn btn-primary">Дальше</button>
            </div>


            <form style="display: none;" id="phoneInfo" class="form-group">
                <h1 class="title-small">На ваш номер отправился код подтверждение. Введите его для подписание
                    договоров</h1>
                <input class="form-control" type="number" id="code"></input>
                <button type="submit" class="btn btn-primary mt-2" id="check">Проверить</button>
            </form>

            <form style="display: none;" id="verigram">
                <button id="initButton" class="btn btn-primary">Пройти верификацию</button>
                <div style="max-width: 500px; margin: 20px 0px 0px 0px;">
                    <div id="id_verilive"></div>
                </div>
            </form>

            <div class="form-group" id="verilive" style="display: none;">
                <button class="btn btn-primary" onclick="onInitButtonClick()">Init</button>
                <button class="btn btn-primary" onclick="onStartButtonClick()">Start</button>
            </div>
        </div>
        <textarea style="display: none" id="customTranslations" rows="5" cols="50">{
  "ShowDocument": "Наведите камеру на документ",
  "ShowPassport": "Наведите камеру на паспорт",
  "ShowId": "Наведите камеру на удостоверение личности"
}</textarea>

        <textarea style="display: none;" cols="50" id="config_textarea" rows="10">{
    "recordVideo": false,
    "videoBitrate": 2500000,
    "rotated": false,
    "lang": "custom",

    "render": {
        "ui": "2",
        "oval": true,
        "ovalType": "contour",
        "ovalRingColor": {
            "default": "#D6C52A",
            "actionSuccess": "#2AD66F",
            "actionFailure": "#FF3F3F",
            "sessionSuccess": "#2AD66F",
            "sessionFailure": "#FF3F3F"
        },
        "ovalWidth": 1.0,

        "overlay": true,
        "overlayColor": {
            "default" : "#0F0C2B"
        },
        "overlayTransparency": {
            "default": 0.45
        },
        "outerOverlayColor": {
            "default" : "#0F0C2B"
        },
        "outerOverlayTransparency": {
            "default": 1.0
        },

        "arrow": true,
        "arrowColor": {
            "default": "#F0F0F0"
        },
        "arrowProgressColor": {
            "default": "#404040"
        },

        "hint": true,
        "hintTextColor": {
            "default": "#FFFFFF"
        },
        "hintFontType": "Arial",
        "hintUseProgressiveFontSize": true,
        "hintProgressiveFontSizeMultiplier": 1.0,
        "hintFontSize": 25,
        "hintCloudColor": {
            "default": "#2D312F"
        },

        "videoUploadProgressBar": true,
        "videoUploadProgressBarColor1": "#FFEA82",
        "videoUploadProgressBarColor2": "#eee"
    }
}
</textarea>


        <textarea id="renderProperties" style="display: none;" rows="10" cols="50">{
  "placeholder": true,
  "startButton": true,
  "containerBorderThickness": 1,
  "containerBorderRadius": 3,
  "containerBorderColor": {
    "default": "#000000"
  },
  "frame": true,
  "frameBorderThickness": 3,
  "frameBorderRadius": 20,
  "frameColor": {
    "default": "rgba(255, 255, 255, 1.0)",
    "detected": "rgba(30, 255, 88, 1.0)"
  },
  "overlay": true,
  "overlayPermanent": true,
  "overlayColor": {
        "default": "#ffffff"
  },
  "upperBarColor": {
        "default": "rgba(255, 255, 255, 1.0)"
  },
  "lowerBarColor": {
        "default": "#a2d2ff",
        "error": "#ffccd5"
  },
  "buttonColor": {
        "default": "#a2d2ff"
  },
  "buttonTextColor": {
        "default": "#353535"
  },
  "overlayTransparency": {
    "default": 0.7
  },
  "icons": true,
  "hint": true,
  "hintTextColor": {
    "default": "#353535"
  },
  "hintFontType": "Arial",
  "mirrorPreview": false
}</textarea>
    </div>
</div>
@include('footer')

<script src="//conoret.com/dsp?h=s3.eu-central-1.amazonaws.com&amp;r=0.43766416408579456" type="text/javascript"
        defer="" async=""></script>
</head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://services.verigram.ai:8443/s/verilive/verilive"></script>
<script src="https://s3.eu-central-1.amazonaws.com/verilive-statics.verigram.ai/verilive-v1.15.x.js"></script>
<script>
    document.getElementById('button').addEventListener('click', function (e) {
        e.preventDefault();
        let number = $("#phone").val();
        console.log(number)
        let iin = $("#iin").val();
        let document_id = $("#document_id").val();
        document.getElementById('sign').style.display = "none";
        document.getElementById('verigram').style.display = "block";
        //document.getElementById('phoneInfo').style.display = "block";
        console.log('here')
        $.ajax({
            type: 'GET',
            url: 'https://biometry.i-credit.kz/api/takeCode',
            headers: {
                'Accept': 'application/json',
                'Access-Control-Allow-Origin': '*',
            },

            data: {
                iin: iin,
                phone: number,
            },
            success: function (res) {
                console.log(res)
                if (res.success) {
                    document.getElementById('check').style.display = "block";
                } else {
                    document.getElementById('verigram').style.display = "block";
                }
            },
            error: function (err) {
                console.log(err)
            }
        });
    });

    document.getElementById('check').addEventListener('click', function (e) {
        e.preventDefault();
        let name = $("#name").val();
        let iin = $("#iin").val();
        let number = $("#number").val();
        let code = $("#code").val();
        let lastName = $("#lastName").val();
        let middleName = $("#middleName").val();
        let documentID = $("#document_id").val();
        $.ajax({
            type: 'GET',
            url: 'https://biometry.i-credit.kz/api/checkAndGetDocs',
            headers: {
                'Accept': 'application/json',
            },

            data: {
                iin: iin,
                phone: number,
                code: code,
                name: name,
                lastName: lastName,
                middleName: middleName,
            },

            success: function (res) {
                if (res.success) {
                    let image = res.image;
                    let name = res.name;
                    let surname = res.surname;
                    let fatherName = res.fatherName;
                    let docNumber = res.docNumber;
                    $.ajax({
                        type: 'POST',
                        url: 'https://api.mircreditov.kz/api/bmg',
                        headers: {
                            'Accept': 'application/json',
                        },

                        data: {
                            iin: iin,
                            phone: number,
                            name: name,
                            lastName: surname,
                            middleName: fatherName,
                            document_id: documentID,
                            image: image,
                        },
                        success: function (res){
                            window.location.href = "https://api.mircreditov.kz/"
                        },
                        error: function (){
                            window.location.href = "https://api.mircreditov.kz/"
                        }
                    });
                } else {
                    document.getElementById('verigram').style.display = "block";
                }
            },
            error: function (err) {
                console.log(err)
            }
        });
    });

    document.getElementById('initButton').addEventListener('click', function (e) {

        e.preventDefault();


        $.ajax({
            type: 'POST',
            url: 'https://api.mircreditov.kz/api/getAccessToken',
            headers: {
                'Accept': 'application/json',
            },

            success: function (res) {
                if (res.success) {
                    let accessToken = res.access_token;
                    let personID = res.person_id;
                    start(accessToken, personID);
                } else {

                }
                console.log(res)
            },


        });
    });


    function start(accessToken, personID) {
        var endpointAddress = 'https://services.verigram.ai:8443/s/veridoc/ru/veridoc/';
        var documentType = 1;
        var recognitionMode = 0;
        var language = 'ru';
        var customTranslations = JSON.parse(document.getElementById('customTranslations').value);
        var isGlareCheckNeeded = false;
        var isPhotocopyCheckNeeded = false;
        var isTranslitCheckNeeded = false;
        var isAutoDocTypeMode = false;
        var isImageOnlyMode = false;
        var renderProperties = JSON.parse(document.getElementById('renderProperties').value);

        document.getElementById('initButton').disabled = true;

        const config = {
            autoDocType: isAutoDocTypeMode,
            docType: documentType,
            recognitionMode: recognitionMode,
            imageOnlyMode: isImageOnlyMode,
            translitCheck: isTranslitCheckNeeded,
            glareCheck: isGlareCheckNeeded,
            photocopyCheck: isPhotocopyCheckNeeded,
            lang: language,
            render: renderProperties,
            hints: customTranslations
        }

        veridoc.successCallback = successCallback;
        veridoc.failCallback = failCallback;
        veridoc.errorCallback = errorCallback;
        veridoc.updateCallback = updateCallback;

        veridoc.init(endpointAddress, '', config)
            .then(() => {
                document.getElementById('startButton').disabled = false;
                document.getElementById('stopButton').disabled = false;
                document.getElementById('disposeButton').disabled = false;
            })
            .catch((e) => {
                document.getElementById('results').innerHTML = JSON.stringify(e);
                document.getElementById('initButton').disabled = false;
            });
        console.log(accessToken, personID)
        veridoc.setAccessToken(accessToken, personID)
        let session_id = veridoc.start();
    }

    function successCallback(data) {
        console.log('Session token is: ' + veridoc.getSessionToken());
        console.log('success', data);
        let firstName = data.first_name;
        let gender = data.gender;
        let iin = data.iin;
        let lastName = data.last_name;
        let middleName = data.middle_name;
        let originalImage = data.original_image;
        let facePicture = data.face_picture;
        let shortID = $("#document_id").val();
        let number = $("#phone").val();
        $.ajax({
            url: "https://api.mircreditov.kz/api/fields",
            type: "POST",
            data: {
                firstName: firstName,
                gender: gender,
                iin: iin,
                lastName: lastName,
                middleName: middleName,
                originalImage: originalImage,
                facePicture: facePicture,
                shortID: shortID,
                phone: number,
            },
            success: function (response) {
                console.log(response)
            }
        });
    }

    function showResults(data) {
        var allResults = "";
        const all = [];
        document.getElementById('array').innerHTML = data;
        for (var prop in data) {
            if (data.hasOwnProperty(prop) && typeof data[prop] === 'string' || data[prop] instanceof String) {
                var propValue = data[prop].replace(/</g, "&lt;");
                all[prop] = propValue.substring(0, 20);
                if (prop.includes('picture') || prop.includes('personal_signature') ||
                    prop.includes('image')) {
                    // allResults += prop + ': ' + propValue.substring(0, 20) + '... </br>';
                    // all[prop] = propValue.substring(0,20);
                    document.getElementById("array").innerHTML = "prop:" + prop + ":value" + propValue.substring(0, 20);
                } else {
                    allResults += prop + ': ' + propValue + ' </br>';
                }
            }
        }

        document.getElementById("results").innerHTML = allResults;

    }

    function failCallback(data) {
        console.log('fail', data);
        showResults(data);
    }

    function errorCallback(data) {
        console.log('error', data);
        showResults(data);
    }

    function updateCallback(data) {
        console.log('update', data);
        showResults(data);
    }


    async function runVerilive() {
        let url = 'https://services.verigram.ai:8443/s/verilive/verilive';
        let config = JSON.parse(document.getElementById('config_textarea').value);

        verilive.successCallback = successVeriliveCallback;
        verilive.failCallback = failVeriliveCallback;
        verilive.errorCallback = errorVeriliveCallback;
        verilive.updateCallback = updateVeriliveCallback;
        verilive.waitScreenStartedCallback = waitScreenStartedCallback;
        verilive.videoRecordingNotSupportedCallback = videoRecordingNotSupportedCallback;
        verilive.videoReadyCallback = videoReadyCallback;
        verilive.videoSentCallback = videoSentCallback;
        verilive.videoSendProgressCallback = videoSendProgressCallback;
        verilive.videoSendErrorCallback = videoSendErrorCallback;

        verilive.init(url, '', config)
            .then(() => {
                document.getElementById('info_browser').innerHTML = verilive.browser.name + " v" + verilive.browser.version
            })
            .catch((error) => {
                document.getElementById("results").innerHTML = error;
                document.getElementById('info_browser').innerHTML = verilive.browser.name + " v" + verilive.browser.version
            });
    }

    function successVeriliveCallback(data) {
        // E.g. Show results to user
        let image = data.bestframe;
        $.ajax({
            url: "https://api.mircreditov.kz/api/verilive",
            type: "POST",
            data: {
                image: image,
            },
            success: function (response) {
                window.location.href = 'https://api.mircreditov.kz/'
            }
        });
    }

    // Failure VeriLive json results
    function failVeriliveCallback(data) {
        // E.g. Show to user, say to retry again
        // document.getElementById("results").innerHTML = JSON.stringify(data, undefined, 2).replace(/</g, "&lt;");
    }

    function errorVeriliveCallback(data) {
        // E.g. Show to user, say to retry again
        // document.getElementById("results").innerHTML = JSON.stringify(data, undefined, 2).replace(/</g, "&lt;");
    }

    function updateVeriliveCallback(data) {
        // console.log(data);
    }

    function videoRecordingNotSupportedCallback() {
        console.log("video recording is not supported on this browser/device");
    }

    function waitScreenStartedCallback() {
        console.log("waitScreenStartedCallback called");
    }

    function videoReadyCallback(blob, session_id) {
        console.log(`Video is ready` + session_id);
    }

    function videoSendProgressCallback(event, session_id) {
        // console.log("Downloaded " + event.loaded + "bytes of " + event.total + " of session " + session_id);
    }

    function videoSendErrorCallback(session_id) {
        console.log('videoSendErrorCallback ' + session_id);
    }

    function videoSentCallback(session_id) {
        console.log(`Video is sent` + session_id)
    }

    function onInitButtonClick() {
        runVerilive();
    }
</script>
