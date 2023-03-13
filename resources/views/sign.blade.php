@include('header')

<div class="container py-lg-5 py-md-4">
    <div class="row align-items-center">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 mt-4">

            <form action="api/client/create" method="post" class="register" id="sign">
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
                <label for="password" class="title-small">Придумайте пароль</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <button type="submit" class="btn btn-primary">Дальше</button>
            </form>
        </div>

    </div>
</div>
@include('footer')
<script>
    document.getElementById('sign').addEventListener('submit', function (e) {
        e.preventDefault();
        let number = $("#phone").val();
        let password = $("#password").val();
        let iin = $("#iin").val();
        let document_id = $("#document_id").val();
        $.ajax({
            type: 'POST',
            url: 'http://localhost:8000/api/client/create',
            headers: {
                'Accept': 'application/json',
            },

            data: {
                iin: iin,
                phone: number,
                password: password,
                id: document_id,
            },

            success: function (res) {
                console.log(res)
                if (res.success) {
                    let token = res.token;
                    let user_type = res.user_type;
                    localStorage.setItem('token', token)
                    localStorage.setItem('user_type', user_type);
                    window.location.href = "https://api.mircreditov.kz/client-page";
                }
            },
            error: function (err) {
                console.log(err)
            }

        });
    });
</script>
