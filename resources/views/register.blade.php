@include('header')
<div class="container py-lg-5 py-md-4">
    <div class="row align-items-center">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 mt-4">

            <form action="api/partner/create" class="register" method="post">
                <h1 class="text-center">Регистрация</h1>
                @csrf
                <div class="form-outline mb-4 mt-5 text-center fs-3">
                    <label for="name" class="text-center fs-3"><strong>Имя</strong></label>
                    <input type="text" id="name"
                           class="form-control input-lg bg-light @error('name') is-invalid @enderror" name="name"
                           value="{{old('name')}}" required autofocus>
                    @error('name')
                    <span class="invalid-feedback" role="alert"><strong>{{$message}}</strong></span>
                    @enderror
                </div>

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

                <div class="form-outline mb-4 text-center fs-3">
                    <label for="password"><strong>Выбирайте тип</strong></label>
                    <select name="company_type" class="form-control input-lg bg-light" id="type">
                        <option disabled>Выбирайте</option>
                        <option value="1">Физ лицо</option>
                        <option value="2">ИП</option>
                        <option value="3">ТОО</option>
                        <option value="4">АО</option>
                    </select>
                </div>
                <div id="company_inline" style="display:none;">
                </div>
                <div id="company">


                    <div class="form-outline mb-4 text-center fs-3">
                        <label>Название компании или ИП</label>
                        <input id="company_name" type="text" name="company_name"
                               class="form-control input-lg bg-light">
                    </div>
                    <div class="form-outline mb-4 text-center fs-3">
                        <label>Адрес компании</label>
                        <input id="address" type="text" name="address" class="form-control input-lg bg-light">
                    </div>


                </div>

                <button type="submit" class="form-control mb-4 text-center fs-3 p-3 register">Регистрация</button>
                <label for="sign"><h1><a id="login" href="login" class="form-control mb-4 text-center ml-4">Войти</a></h1></label>
            </form>
        </div>
    </div>
</div>
@include('footer')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<script type="text/javascript">
    let company = document.getElementById("company");
    $("#type").change(function () {
        let select = $(this).val();
        company.style.display = "none";
        if (select == 1) {
            $("#company").hide();
        }
        if (select != 1) {
            $("#company").show();
        }
    });
</script>
