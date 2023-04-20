@include('header')

<div class="container">
    <div class="row">
        <div class="col-lg-4 d-xs-none"></div>

        <div class="col-lg-4">
            <form id="login" action="api/partner/sign" class="register col-md-12 mb-5 col-xs-9" method="post">
                <h5 class="text-center">Авторизация</h5>
                @csrf

                <div class="form-outline col-md-12 mb-4 text-center fs-6">
                    <label for="phone"><strong>Телефон</strong></label>
                    <input type="text" id="phone"
                           class="form-control input-lg bg-light @error('phone') is-invalid @enderror"
                           name="phone"
                           required autofocus>
                    @error('phone')
                    <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                    @enderror
                </div>

                <div class="form-outline col-md-12 mb-4 text-center fs-6">
                    <label for="password"><strong>Пароль</strong></label>
                    <input type="password" id="password"
                           class="form-control input-lg bg-light @error('password') is-invalid @enderror"
                           name="password" required autofocus>
                    @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                    @enderror
                </div>


                <button type="submit" class="form-control col-md-12 mb-4 text-center fs-6 p-3 register">Войти</button>
                @if (Session::has('error'))
                    <div class="alert-danger">{{Session::get('error')}}</div>
                @endif
                <div id="error" class="alert-danger" style="display: none;">Неправильный логин или пароль</div>
            </form>

        </div>

        <div class="col-lg-4 d-xs-none"></div>


        </div>
    </div>
</div>
@include('footer')
<script src="https://unpkg.com/imask"></script>
<script type="text/javascript">
    var myInputMask = IMask(document.getElementById('phone'), {
        mask: '+{7}(000)000-00-00',
        lazy: false,
    });

    let login = document.getElementById('login');
    login.addEventListener('submit', function (e) {
        e.preventDefault();
        let phone = document.getElementById('phone').value
        phone = phone.replace(/[^a-zA-Z0-9]/g, '');
        document.getElementById('phone').value=phone
        let xhr = new XMLHttpRequest();
        xhr.open('POST', this.action);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                let response = JSON.parse(xhr.response)
                let success = response.success;
                if (success) {
                    let token = response.token;
                    let type = response.type;
                    localStorage.setItem('token', token);
                    if (type == 1){
                        window.location.href = 'partner-page';
                    }
                    if (type == 2){
                        window.location.href = 'client-page';
                    }
                    if (type == 3){
                        window.location.href = 'manager-page';
                    }
                } else {
                    document.getElementById('error').style.display = "block";
                }
            }
        }
        xhr.send(new FormData(this));
    });
</script>
