@include('header')
@if(isset($code) && $code==404)
    <script>
        window.location.href = '/';
    </script>
@else
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-xs-12">
                <div id="error" class="text-danger">

                </div>
                <div class="form-group">
                    <input type="hidden" id="userID" value="{{$userID}}">
                    <input type="hidden" id="restoreID" value="{{$restoreID}}">
                    <label>Вводите новый пароль:</label>
                    <input type="text" class="form-control" id="password">
                    <label>Повторите новый пароль:</label>
                    <input type="text" class="form-control" id="repeat_password">
                    <button type="button" id="restore" class="btn btn-primary">Восстановить пароль</button>
                </div>

            </div>
        </div>
    </div>
@endif
@include('footer')

<script>
    document.getElementById('restore').addEventListener('click', function (e) {
        let password = document.getElementById('password').value;
        let repeat = document.getElementById('repeat_password').value;
        let userID = document.getElementById('userID').value;
        let restoreID = document.getElementById('restoreID').value;
        if (password.length < 8) {
            document.getElementById('error').innerHTML = 'Пароль должен состоит минимум 8 символов';
            return
        }
        if (password != repeat) {
            document.getElementById('error').innerHTML = 'Пароли не совпадают';
            return
        }
        $.ajax({
            url: '/api/restore_password?password=' + password + '&userID=' + userID + '&restoreID=' + restoreID,
            type: 'GET',
            success: function (res) {
                document.getElementById('error').innerHTML = 'Ваш пароль успешно изменен. Вы будете перенапрален на страницу авторизации через 5 секунд';
                setTimeout(function (){
                    window.location.href='/login'
                },5000);

            },
            error: function (data) {
                console.log(data)
                document.getElementById('error').innerHTML = 'Попробуйте позже';
            }
        });

    });
</script>
