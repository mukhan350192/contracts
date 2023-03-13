@include('header')

<div class="container py-lg-5 py-md-4">
    <div class="row align-items-center">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 mt-4">

            <form id="login" action="api/partner/sign" class="register" method="post">
                <h1 class="text-center">Авторизация</h1>
                @csrf

                <div class="form-outline mb-4 text-center fs-3">
                    <label for="phone"><strong>Телефон</strong></label>
                    <input type="number" id="phone"
                           class="form-control input-lg bg-light @error('phone') is-invalid @enderror"
                           name="phone"
                           value="{{old('phone')}} required autofocus">
                    @error('phone')
                    <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                    @enderror
                </div>

                <div class="form-outline mb-4 text-center fs-3">
                    <label for="password"><strong>Пароль</strong></label>
                    <input type="password" id="password"
                           class="form-control input-lg bg-light @error('password') is-invalid @enderror"
                           name="password" value="{{old('password')}} required autofocus">
                    @error('password')
                    <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                    @enderror
                </div>


                <button type="submit" class="form-control mb-4 text-center fs-3 p-3 register">Войти</button>
                @if (Session::has('error'))
                    <div class="alert-danger">{{Session::get('error')}}</div>
                @endif
                <div id="error" class="alert-danger" style="display: none;">Неправильный логин или пароль</div>
            </form>
        </div>
    </div>
</div>
@include('footer')
<script type="text/javascript">
    let login = document.getElementById('login');
    login.addEventListener('submit', function (e) {
        e.preventDefault();
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