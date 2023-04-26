@include('header')
<div class="container">
    <div class="row">
        <div class="col-lg-4 col-d-none"></div>
        <div class="col-lg-4 mt-4 mb-4 col-xs-4 col-md-4">
            <div class="form-group">
                <input type="text" class="form-control" name="phone" id="phone" required>
                <button type="button" id="send_sms" class="btn btn-primary form-control mt-2">Восстановить пароль
                </button>
                <div class="text-danger" id="error"></div>
            </div>
        </div>
    </div>
</div>
@include('footer')
<script src="https://unpkg.com/imask"></script>
<script>
    var myInputMask = IMask(document.getElementById('phone'), {
        mask: '+{7}(000)000-00-00',
        lazy: false,
    });


    //

    document.getElementById('send_sms').addEventListener('click', function (e) {
        e.preventDefault();
        let phone = $("#phone").val();
        phone = phone.replace(/[^a-zA-Z0-9]/g, '');
        console.log('here')
        console.log(phone)
        $.ajax({
            url: '/api/remember_password?phone=' + phone,
            type: 'GET',
            success: function (res){
                document.getElementById('error').innerHTML = 'На ваш телефон отправлен ссылка для восстановление пароля';
            },
            error: function (data){
                if (data.status == 422){
                    document.getElementById('error').innerHTML = 'Данный телефон не имеет личного кабинета';
                }else{
                    document.getElementById('error').innerHTML = 'Попробуйте позже';
                }
            }
        })
    });
</script>
