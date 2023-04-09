@include('header')
<div class="container">
    <div class="row mt-5">

        @include('sidebar')
        <div class="col-lg-6 mt-2">
            <div class="alert-danger" id="error">
            </div>
            <div class="alert-success" id="success">
            </div>

            <div id="loading" style="display: none;">Loading...</div>
            <div class="form-control"  style="display: none;" id="send">
                <div class="form-outline">
                    <label class="title-small">Выбирайте договор</label>
                    <select id="select" class="form-control">

                    </select>

                </div>
                <div class="form-outline">
                    <label class="title-small">Номер телефона</label>
                    <input type="text" class="form-control" name="phone" id="phone">
                    <label for="" class="title-small">ИИН клиента</label>
                    <input type="text" class="form-control" name="iin" id="iin">
                    <div class="d-flex justify-content-center text-center mt-3">
                        <button type="button" id="sendSMS" class="btn btn-primary">Отправить смс</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@include('footer')
<script>
    var loading = document.getElementById('loading');
    //  loading.style.display = 'block';
    token = localStorage.getItem('token');
    console.log(token)
    console.log('test2')
    $.ajax({
        url: "{{ url('/api/partner/getActiveDocs') }}",
        type: "GET",
        headers: {
            'Authorization': 'Bearer ' + token,
        },
        success: function (response,textStatus,jqXHR) {
            console.log(response)
            console.log('test')
            console.log(jqXHR.status)
            if (response.success) {
                let doc = document.getElementById('docs');
                let select = $('#select');
                for (let i = 0; i < response.doc.length; i++) {
                    select.append($('<option>', {
                        value: response.doc[i].id,
                        text: response.doc[i].name,
                    }));
                }
                document.getElementById('send').style.display = "block";
            } else {
                document.getElementById('error').innerHTML = response.error;
            }
            if (response.status == 401){
                document.getElementById('error').innerHTML = 'Кажется сессия токена истек. Вы будете перенаправлены на авторизацию личного кабинета';
                setTimeout(()=>{console.log('here')},2000);
                window.location.href='login';
            }
        },
        error: function (xhr) {
            console.log(xhr)
            console.log(xhr.status)
            document.getElementById('error').innerHTML = 'Кажется сессия токена истек. Вы будете перенаправлены на авторизацию личного кабинета';
            setTimeout(()=>{console.log('here')},2000);
            window.location.href='login';
        },
        complete: function () {
            loading.style.display = 'none'; // hide the loading animation
        }
    });

    document.getElementById('sendSMS').addEventListener('click', function (e) {
        e.preventDefault();
        docID = $("#select").val();
        let number = $("#phone").val();
        let ii = $("#iin").val();
        console.log(number)
        console.log(docID)
        console.log(ii)
        $.ajax({
            url: "{{ url('api/partner/send') }}",
            type: "GET",
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token,
            },
            data: {
                phone: number,
                iin: ii,
                document_id: docID,
            },
            success: function (response) {
                console.log(response)
                if (response.success) {
                    document.getElementById('success').innerHTML='СМС успешно отправлен';
                } else {
                    document.getElementById('error').innerHTML = "Попробуйте позже";
                }
            },
            error: function (xhr) {
                console.log(xhr)
                console.log(data)
            },
            complete: function () {

            }
        });
        console.log(token)

    });
</script>

