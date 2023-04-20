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
                <!-- physical -->
                <div id="physical" style="display: none;">

                    <div class="form-outline mb-4 mt-3 text-center fs-3">
                        <label for="name" class="text-center fs-6"><strong>Имя</strong></label>
                        <input type="text" id="client_name"
                               class="form-control input-lg bg-light" name="name"
                               required autofocus>
                    </div>

                    <div class="form-outline mb-4 text-center fs-6">
                        <label for="iin"><strong>ИИН</strong></label>
                        <input type="number" id="client_iin"
                               class="form-control input-lg bg-light"
                               name="iin"
                               value="{{old('iin')}} required autofocus">
                    </div>

                    <div class="form-outline mb-4 text-center fs-6">
                        <label for="phone"><strong>Телефон</strong></label>
                        <input type="text" id="client_phone"
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
                        <input type="password" id="client_password"
                               class="form-control input-lg bg-light"
                               name="password" required autofocus>
                    </div>

                </div>
                <!-- ip -->
                <div id="ip" style="display: none;">

                    <div class="form-outline mb-4 text-center fs-6">
                        <label for="iin"><strong>ИИН</strong></label>
                        <input type="number" id="ip_iin"
                               class="form-control input-lg bg-light"
                               name="iin"
                               value="{{old('iin')}} required autofocus">
                    </div>

                    <div class="form-outline mb-4 text-center fs-6">
                        <label>Название ИП</label>
                        <input id="ip_company_name" type="text" name="company_name"
                               class="form-control input-lg bg-light">
                    </div>

                    <div class="form-outline mb-4 mt-3 text-center fs-3">
                        <label for="name" class="text-center fs-6"><strong>Имя</strong></label>
                        <input type="text" id="ip_name"
                               class="form-control input-lg bg-light @error('name') is-invalid @enderror" name="name"
                               required autofocus>
                    </div>

                    <div class="form-outline mb-4 text-center fs-6">
                        <label for="phone"><strong>Телефон</strong></label>
                        <input type="text" id="ip_phone"
                               class="form-control phone input-lg bg-light @error('phone') is-invalid @enderror"
                               name="phone"
                               required autofocus placeholder="+7(000)000-00-00"
                        >
                    </div>

                    <div class="form-outline mb-4 text-center fs-6">
                        <label for="password"><strong>Пароль</strong></label>
                        <input type="password" id="ip_password"
                               class="form-control input-lg bg-light @error('password') is-invalid @enderror"
                               name="password" required autofocus>
                    </div>
                </div>

                <!-- company -->
                <div id="company">
                    <div class="form-outline mb-4 text-center fs-6">
                        <label for="BIN"><strong>БИН</strong></label>
                        <input type="number" id="bin"
                               class="form-control input-lg bg-light"
                               name="bin" required autofocus>
                    </div>

                    <div class="form-outline mb-4 text-center fs-6">
                        <label>Название компании</label>
                        <input id="c_company_name" type="text" name="company_name"
                               class="form-control input-lg bg-light">
                    </div>

                    <div class="form-outline mb-4 mt-3 text-center fs-3">
                        <label for="name" class="text-center fs-6"><strong>Имя контактного лица</strong></label>
                        <input type="text" id="c_name"
                               class="form-control input-lg bg-light" name="name"
                               required autofocus>
                    </div>

                    <div class="form-outline mb-4 text-center fs-6">
                        <label for="phone"><strong>Телефон контактного лица</strong></label>
                        <input type="text" id="c_phone"
                               class="form-control phone input-lg bg-light"
                               name="phone"
                               required autofocus placeholder="+7(000)000-00-00">
                    </div>

                    <div class="form-outline mb-4 text-center fs-6">
                        <label for="password"><strong>Пароль</strong></label>
                        <input type="password" id="c_password"
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
                    <div class="col">
                        <!-- Simple link -->
                        <p>Уже есть аккаунт? <a href="/login">Войти в личный кабинет</a></p>
                    </div>
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

    let inputMask = IMask(document.getElementById('client_phone'), {
        mask: '+{7}(000)000-00-00',
        lazy: false,
    });

    let ip_inputMask = IMask(document.getElementById('ip_phone'), {
        mask: '+{7}(000)000-00-00',
        lazy: false,
    });

    let c_inputMask = IMask(document.getElementById('c_phone'), {
        mask: '+{7}(000)000-00-00',
        lazy: false,
    });

    // Update the mask when the input value changes


    let company = document.getElementById("company");
    $("#type").change(function () {
        let select = $(this).val();
        company.style.display = "none";
        if (select == 0) {
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
        let name = $("#client_name").val();
        let ip_name = $("#ip_name").val();
        let c_name = $("#c_name").val();
        let phone = $("#client_phone").val();
        let ip_phone = $("ip_phone").val();
        let c_phone = $("#c_phone").val();
        let iin = $("#client_iin").val();
        let ip_iin = $("#ip_iin").val();
        let client_password = $("#client_password").val();
        let ip_password = $("#ip_password").val();
        let c_password = $("#c_password").val();
        let type = $("#type").val();
        let company_name = $("#ip_company_name").val();
        let c_company_name = $("#c_company_name").val();
        let bin = $("#bin").val();
        if (type == 1){
            phone = phone.replace(/[^a-zA-Z0-9]/g, '');
        }
        if (type == 2){
            ip_phone = ip_phone.replace(/[^a-zA-Z0-9]/g, '');
        }
        if (type == 3){
            c_phone = c_phone.replace(/[^a-zA-Z0-9]/g, '');
        }
        console.log(type)
        let url = '';
        if (type == 1) {
            url = '&name=' + name + '&iin=' + iin + '&phone=' + phone + '&password=' + client_password;
            number = phone
            console.log(validate(name, iin, phone, client_password))
            if (!validate(name, iin, phone, client_password)) {
                return
            }
        }
        console.log('test1');
        if (type == 2) {
            url = '&name=' + ip_name + '&iin=' + ip_iin + '&phone=' + ip_phone + '&password=' + ip_password + '&company_name=' + company_name;
            number = ip_phone
            if (!validate_ip(ip_name, ip_iin, ip_phone, ip_password, company_name)) {
                return;
            }
        }
        console.log('test2');
        if (type == 3) {
            url = '&name=' + c_name + '&iin=' + c_iin + '&phone=' + c_phone + '&password=' + c_password + '&company_name=' + c_company_name + '&bin=' + bin;
            number = c_phone
            if (!validate_company(c_name, c_phone, c_password, c_company_name, bin)) {
                return;
            }
        }
        console.log('test3')
        console.log('here')
        $.ajax({
            type: 'GET',
            url: 'api/sendSMS?phone=' + number,
            headers: {
                'Accept': 'application/json',
            },
            success: function (res) {
                console.log(res)
                if (res == 1) {
                    document.getElementById('code').style.display = "block";
                    document.getElementById('button').style.display = "none";
                    document.getElementById('check').style.display = "block";
                } else {
                    document.getElementById('errorMessage').innerHTML = "Попробуйте позже";
                }
                console.log(res)
            },
            error: function (err) {
                document.getElementById('errorMessage').innerHTML = "Попробуйте позже";
            }

        });

    });


    document.getElementById('check').addEventListener('click', function (e) {
        e.preventDefault();
        let name = $("#client_name").val();
        let ip_name = $("#ip_name").val();
        let c_name = $("#c_name").val();
        let phone = $("#client_phone").val();
        let ip_phone = $("ip_phone").val();
        let c_phone = $("#c_phone").val();
        let iin = $("#client_iin").val();
        let ip_iin = $("#ip_iin").val();
        let client_password = $("#client_password").val();
        let ip_password = $("#ip_password").val();
        let c_password = $("#c_password").val();
        let type = $("#type").val();
        let company_name = $("#ip_company_name").val();
        let c_company_name = $("#c_company_name").val();
        let bin = $("#bin").val();
        let code = $("#codeNumber").val();
        if (type == 1){
            phone = phone.replace(/[^a-zA-Z0-9]/g, '');
        }
        if (type == 2){
            ip_phone = ip_phone.replace(/[^a-zA-Z0-9]/g, '');
        }
        if (type == 3){
            c_phone = c_phone.replace(/[^a-zA-Z0-9]/g, '');
        }
        let url = '';
        if (type == 1) {
            url = 'name=' + name + '&iin=' + iin + '&phone=' + phone + '&password=' + client_password+'&code='+code;
            console.log(phone)
            if (!validate(name, iin, phone, client_password)) {
                return
            }
        }
        if (type == 2) {
            url = 'name=' + ip_name + '&iin=' + ip_iin + '&phone=' + ip_phone + '&password=' + ip_password + '&company_name=' + company_name+'&code='+code;
            if (!validate_ip(ip_name, ip_iin, ip_phone, ip_password, company_name)) {
                return;
            }
        }
        if (type == 3) {
            url = 'name=' + c_name + '&iin=' + c_iin + '&phone=' + c_phone + '&password=' + c_password + '&company_name=' + c_company_name + '&bin=' + bin+'&code='+code;
            if (!validate_company(c_name, c_phone, c_password, c_company_name, bin)) {
                return;
            }
        }

        $.ajax({
            type: 'GET',
            url: 'api/partner/create?'+url,
            headers: {
                'Accept': 'application/json',
            },
            success: function (res) {

                if (res.success) {
                    let token = res.token;
                    localStorage.setItem('token', token)
                    window.location.href = "partner-page";
                }
            },
            error: function (err) {
                console.log(err)
                console.log(data)
            }

        });
    });


    function validate(name, iin, phone, password) {
        if (!name) {
            document.getElementById('errorMessage').style.display = 'block'
            document.getElementById('errorMessage').innerHTML = 'Введите имя'
            return false
        }
        if (!validateIIN(iin)) {
            document.getElementById('errorMessage').style.display = 'block'
            document.getElementById('errorMessage').innerHTML = 'Введите корректный иин'
            return false
        }
        if (!phone || phone.length != 11) {
            document.getElementById('errorMessage').style.display = 'block'
            document.getElementById('errorMessage').innerHTML = 'Введите корректный телефон'
            return false
        }
        if (!password) {
            document.getElementById('errorMessage').style.display = 'block'
            document.getElementById('errorMessage').innerHTML = 'Заполните пароль'
            return false
        }
        if (password.length < 8) {
            document.getElementById('errorMessage').style.display = 'block'
            document.getElementById('errorMessage').innerHTML = 'Пароль должен составить не меньше 8 символов'
            return false
        }
        return true
    }

    function validate_ip(name, iin, number, password, company_name) {
        if (!name) {
            document.getElementById('errorMessage').style.display = 'block'
            document.getElementById('errorMessage').innerHTML = 'Введите имя'
            return false
        }
        if (!validateIIN(iin)) {
            document.getElementById('errorMessage').style.display = 'block'
            document.getElementById('errorMessage').innerHTML = 'Введите корректный иин'
            return false
        }
        if (!phone || phone.length != 11) {
            document.getElementById('errorMessage').style.display = 'block'
            document.getElementById('errorMessage').innerHTML = 'Введите корректный телефон'
            return false
        }
        if (!password) {
            document.getElementById('errorMessage').style.display = 'block'
            document.getElementById('errorMessage').innerHTML = 'Заполните пароль'
            return false
        }
        if (password.length < 8) {
            document.getElementById('errorMessage').style.display = 'block'
            document.getElementById('errorMessage').innerHTML = 'Пароль должен составить не меньше 8 символов'
            return false
        }
        if (!company_name) {
            document.getElementById('errorMessage').style.display = 'block'
            document.getElementById('errorMessage').innerHTML = 'Заполните название компании'
            return false
        }
        return true
    }

    function validate_company() {
        if (!name) {
            document.getElementById('errorMessage').style.display = 'block'
            document.getElementById('errorMessage').innerHTML = 'Введите имя'
            return false
        }
        if (!phone || phone.length != 11) {
            document.getElementById('errorMessage').style.display = 'block'
            document.getElementById('errorMessage').innerHTML = 'Введите корректный телефон'
            return false
        }
        if (!password) {
            document.getElementById('errorMessage').style.display = 'block'
            document.getElementById('errorMessage').innerHTML = 'Заполните пароль'
            return false
        }
        if (password.length < 8) {
            document.getElementById('errorMessage').style.display = 'block'
            document.getElementById('errorMessage').innerHTML = 'Пароль должен составить не меньше 8 символов'
            return false
        }
        if (!company_name) {
            document.getElementById('errorMessage').style.display = 'block'
            document.getElementById('errorMessage').innerHTML = 'Заполните название компании'
            return false
        }
        if (!bin) {
            document.getElementById('errorMessage').style.display = 'block'
            document.getElementById('errorMessage').innerHTML = 'Заполните BIN компании'
            return false
        }
        if (!bin && bin.length != 12) {
            document.getElementById('errorMessage').style.display = 'block'
            document.getElementById('errorMessage').innerHTML = 'Введите корректный БИН'
            return false
        }
        return true
    }

    function validateIIN(iin) {
        const regex = /^[0-9]{12}$/;
        if (!regex.test(iin)) {
            return false;
        }

        const year = parseInt(iin.substr(0, 2));
        const month = parseInt(iin.substr(2, 2));
        const day = parseInt(iin.substr(4, 2));

        if (month < 1 || month > 12) {
            return false;
        }

        const maxDays = new Date(year + 2000, month, 0).getDate();

        if (day < 1 || day > maxDays) {
            return false;
        }

        const controlSum = iin
            .slice(0, 11)
            .split('')
            .map(Number)
            .reduce((acc, digit, index) => {
                if (index < 10) {
                    acc += digit * (index + 1);
                }
                return acc;
            }, 0);

        let checkDigit = controlSum % 11;
        if (checkDigit === 10) {
            const secondControlSum = iin
                .slice(0, 11)
                .split('')
                .map(Number)
                .reduce((acc, digit, index) => {
                    if (index < 10) {
                        acc += digit * (index + 3);
                    }
                    return acc;
                }, 0);
            checkDigit = secondControlSum % 11;
            if (checkDigit === 10) {
                checkDigit = 0;
            }
        }

        return checkDigit === parseInt(iin.substr(11, 1));
    }


</script>
