@include('header')

<div class="container py-lg-5 py-md-4">
    <div class="row align-items-center">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 mt-4">

            <form action="api/client/sign" method="post" class="register" id="sign">
                @csrf
                <input type="hidden" value="{{$phone}}" id="phone">
                <input type="hidden" value="{{$iin}}" id="iin">

                <h5 class="title-big">Ознакомлайтесь документом и придумайте пароль для личного кабинета. Вы всегда сможете осмотреть свой документ в личном кабинете</h5>
                <div class="form-outline">
                    <a href="{!! $document !!}" class="title-small"><i class="fa fa-check" aria-hidden="true"></i> {{$name}}</a>
                </div>
                <label for="password" class="title-small">Придумайте пароль</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <button type="submit" class="btn btn-primary">Дальше</button>
            </form>
        </div>

    </div>
</div>
@include('footer')
<script>
    document.getElementById('sign').addEventListener('submit',function (e){
       e.preventDefault();
        let number = $("#phone").val();
        let password = $("#password").val();
        let type = $("#type").val();
        let company_name = $("#company_name").val();
        let address = $("#address").val();
        let code = $("#codeNumber").val();
        let iin = $("#iin").val();

        console.log(iin);
        $.ajax({
            type: 'POST',
            url: 'api/client/create',
            headers: {
                'Accept': 'application/json',
            },

            data: {
                iin: iin,
                phone: number,
                name: name,
                password: password,
                company_type: type,
                company_name: company_name,
                address: address,
                code: code,
            },

            success: function (res) {

                if (res.success) {
                    let token = res.token;
                    localStorage.setItem('token',token)
                    window.location.href = "https://api.mircreditov.kz/partner-page";
                }
            },
            error: function (err) {
                console.log(err)
                console.log(data)
            }

        });
    });
</script>
