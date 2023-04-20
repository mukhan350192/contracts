@include('header')

<div class="container py-lg-5 py-md-4">
    <div class="row align-items-center">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 mt-4">

            <div class="register" id="reg">
                <h5 class="text-center">Регистрация</h5>

                <div class="form-outline mb-4 text-center fs-6">
                    <label for="password"><strong>Выбирайте тип пользовтеля</strong></label>
                    <select name="company_type" class="form-control input-lg bg-light mt-3" id="type">
                        <option value="0">Выбирайте</option>
                        <option value="1">Физ лицо</option>
                        <option value="2">ИП</option>
                        <option value="3">ТОО</option>
                        <option value="4">АО</option>
                    </select>
                </div>

                <div id="physical" style="display: none;">
                    <div class="form-outline mb-4 mt-3 text-center fs-3">
                        <label for="name" class="text-center fs-6"><strong>Имя</strong></label>
                        <input type="text" id="name"
                               class="form-control input-lg bg-light @error('name') is-invalid @enderror" name="name"
                               required autofocus>
                    </div>

                    <div class="form-outline mb-4 text-center fs-6">
                        <label for="iin"><strong>ИИН</strong></label>
                        <input type="number" id="iin"
                               class="form-control input-lg bg-light"
                               name="iin"
                               value="{{old('iin')}} required autofocus">
                    </div>

                    <div class="form-outline mb-4 text-center fs-6">
                        <label for="phone"><strong>Телефон</strong></label>
                        <input type="text" id="phone"
                               class="form-control phone input-lg bg-light @error('phone') is-invalid @enderror"
                               name="phone"
                               required autofocus placeholder="+7(000)000-00-00"
                        >

                        @error('phone')
                        <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                        @enderror
                    </div>

                    <div class="form-outline mb-4 text-center fs-6">
                        <label for="password"><strong>Пароль</strong></label>
                        <input type="password" id="password"
                               class="form-control input-lg bg-light @error('password') is-invalid @enderror"
                               name="password" required autofocus>
                        @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                        @enderror
                    </div>
                </div>

                <div id="ip" style="display: none;">

                    <div class="form-outline mb-4 text-center fs-6">
                        <label for="iin"><strong>ИИН</strong></label>
                        <input type="number" id="iin"
                               class="form-control input-lg bg-light"
                               name="iin"
                               value="{{old('iin')}} required autofocus">
                    </div>

                    <div class="form-outline mb-4 text-center fs-6">
                        <label>Название ИП</label>
                        <input id="company_name" type="text" name="company_name"
                               class="form-control input-lg bg-light">
                    </div>

                    <div class="form-outline mb-4 mt-3 text-center fs-3">
                        <label for="name" class="text-center fs-6"><strong>Имя</strong></label>
                        <input type="text" id="name"
                               class="form-control input-lg bg-light @error('name') is-invalid @enderror" name="name"
                               required autofocus>
                    </div>

                    <div class="form-outline mb-4 text-center fs-6">
                        <label for="phone"><strong>Телефон</strong></label>
                        <input type="text" id="phone"
                               class="form-control phone input-lg bg-light @error('phone') is-invalid @enderror"
                               name="phone"
                               required autofocus placeholder="+7(000)000-00-00"
                        >
                    </div>

                    <div class="form-outline mb-4 text-center fs-6">
                        <label for="password"><strong>Пароль</strong></label>
                        <input type="password" id="password"
                               class="form-control input-lg bg-light @error('password') is-invalid @enderror"
                               name="password" required autofocus>
                    </div>
                </div>

                <div id="company_inline" style="display:none;">
                </div>
                <div id="company">
                    <div class="form-outline mb-4 text-center fs-6">
                        <label for="BIN"><strong>БИН</strong></label>
                        <input type="number" id="bin"
                               class="form-control input-lg bg-light"
                               name="bin" required autofocus>
                    </div>

                    <div class="form-outline mb-4 text-center fs-6">
                        <label>Название компании</label>
                        <input id="company_name" type="text" name="company_name"
                               class="form-control input-lg bg-light">
                    </div>

                    <div class="form-outline mb-4 mt-3 text-center fs-3">
                        <label for="name" class="text-center fs-6"><strong>Имя контактного лица</strong></label>
                        <input type="text" id="name"
                               class="form-control input-lg bg-light" name="name"
                               required autofocus>
                    </div>

                    <div class="form-outline mb-4 text-center fs-6">
                        <label for="phone"><strong>Телефон контактного лица</strong></label>
                        <input type="text" id="phone"
                               class="form-control phone input-lg bg-light"
                               name="phone"
                               required autofocus placeholder="+7(000)000-00-00"
                        >

                        @error('phone')
                        <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                        @enderror
                    </div>

                    <div class="form-outline mb-4 text-center fs-6">
                        <label for="password"><strong>Пароль</strong></label>
                        <input type="password" id="password"
                               class="form-control input-lg bg-light"
                               name="password" required autofocus>
                    </div>

                </div>
                <div class="form-outline mb-4 text-center fs-6" id="code" style="display: none;">
                    <label for="password"><strong>Код подтверждение</strong></label>
                    <input type="number" class="form-control" id="codeNumber">
                </div>
                <span class="invalid-feedback" role="alert" id="errorMessage" style="display: none;"></span>
                <div class="form-outline mb-4 text-center fs-6" id="button">
                    <button type="button" id="register" class="btn btn-danger text-center fs-6 p-3">Регистрация</button>
                </div>


            </div>


            <div id="check" style="display: none;">
                <button type="submit" class="form-control mb-4 text-center fs-6 p-3 register">Подтвердить</button>
            </div>
        </div>
    </div>
</div>

@include('footer')


<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/4.0.9/jquery.inputmask.bundle.min.js"></script>
<script src="https://unpkg.com/imask"></script>

<script type="text/javascript">

    var myInputMask = IMask(document.getElementById('phone'), {
        mask: '+{7}(000)000-00-00',
        lazy: false,
    });

    // Update the mask when the input value changes


    let company = document.getElementById("company");
    $("#type").change(function () {
        let select = $(this).val();
        company.style.display = "none";
        if (select == 0){
            $("#physical").hide();
            $("#company").hide();
            $("#ip").hide();
            return
        }
        if (select == 1) {
            $("#physical").show();
            $("#company").hide();
            $("#ip").hide();
            return
        }
        if (select == 2) {
            $("#ip").show();
            $("#physical").hide();
            $("#company").hide();
            return
        }
        if (select == 3 || select == 4) {
            $("#physical").hide();
            $("#company").show();
            $("#ip").hide();
            return
        }
    });


    document.getElementById('register').addEventListener('click', function (e) {
        e.preventDefault();
        let name = $("#name").val();
        let number = $("#phone").val();
        let iin = $("#iin").val();
        let password = $("#password").val();
        if (!validate(name,iin,number,password)){
            return
        }

        $.ajax({
            type: 'GET',
            url: 'api/sendSMS?phone='+number,
            headers: {
                'Accept': 'application/json',
            },
            success: function (res) {
                if (res.success) {
                    document.getElementById('code').style.display = "block";
                    document.getElementById('button').style.display = "none";
                    document.getElementById('check').style.display = "block";
                } else {
                    document.getElementById('error').style.display = "block";
                }
                console.log(res)
            },
            error: function (err) {
                document.getElementById('error').style.display = "block";
            }

        });

    });


    document.getElementById('check').addEventListener('click', function (e) {
        e.preventDefault();

        let number = $("#phone").val();
        let name = $("#name").val();
        let password = $("#password").val();
        let type = $("#type").val();
        let company_name = $("#company_name").val();
        let address = $("#address").val();
        let code = $("#codeNumber").val();
        let iin = $("#iin").val();

        console.log(iin);
        $.ajax({
            type: 'GET',
            url: 'api/partner/create?iin='+iin+'&phone='+number+'&name='+name+'&password='+password+'&company_type='+type+'&company_name='+company_name+'&address='+address+'&code='+code,
            headers: {
                'Accept': 'application/json',
            },
            success: function (res) {

                if (res.success) {
                    let token = res.token;
                    localStorage.setItem('token',token)
                    window.location.href = "partner-page";
                }
            },
            error: function (err) {
                console.log(err)
                console.log(data)
            }

        });
    });


    function validate(name,iin,phone,password){
        console.log(name)
        if (!name){
            document.getElementById('errorMessage').style.display='block'
            document.getElementById('errorMessage').innerHTML='Введите имя'
            return false
        }
        if (!iinCheck(iin)){
            document.getElementById('errorMessage').style.display='block'
            document.getElementById('errorMessage').innerHTML='Введите корректный иин'
            return false
        }
        if (!phone || phone.length != 11){
            document.getElementById('errorMessage').style.display='block'
            document.getElementById('errorMessage').innerHTML='Введите корректный телефон'
            return false
        }
        if (!password){
            document.getElementById('errorMessage').style.display='block'
            document.getElementById('errorMessage').innerHTML='Заполните пароль'
            return false
        }
        if (password.length < 8){
            document.getElementById('errorMessage').style.display='block'
            document.getElementById('errorMessage').innerHTML='Пароль должен составить не меньше 8 символов'
            return false
        }
    }

    function iinCheck(iin) {
//clientType: 1 - Физ. лицо (ИИН), 2 - Юр. лицо (БИН)
//birthDate: дата рождения (в формате Javascript Date)
//sex: true - м, false - ж
//isResident: true - резидент, false: нерезидент (true: по умолчанию)
        if(!iin) return false;
        if(iin.length!=12) return false;
        if(!(/[0-9]{12}/.test(iin))) return false;
        let y = iin.substring(6,7);
        if (y == 3 || y == 4){
            birthDate = "19"+iin.substring(0,2)+"-"+iin.substring(2,4)+"-"+iin.substring(4,6);
        }else if (y == 5 || y==6){
            birthDate = "20"+iin.substring(0,2)+"-"+iin.substring(2,4)+"-"+iin.substring(4,6);
        }
        console.log(birthDate)
//Физ. лицо
//Проверяем первый фасет на совпадение с датой рождения ГГММД



//Проверяем контрольный разряд
        var b1 = [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ];
        var b2 = [ 3, 4, 5, 6, 7, 8, 9, 10, 11, 1, 2 ];
        var a = [];
        var controll = 0;
        for(var i=0; i<12; i++){
            a[i] = parseInt(iin.substring(i, i+1));
            if(i<11) controll += a[i]*b1[i];
        }
        controll = controll % 11;
        if(controll==10) {
            alert("s");
            controll = 0;
            for(var i=0; i<11; i++)
                controll += a[i]*b2[i];
            controll = controll % 11;
        }
        if(controll!=a[11]) return false;
        return true;
    }
</script>
