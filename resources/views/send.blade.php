@include('header')
<div class="container">
    <div class="row mt-5">

        @include('sidebar')
        <div class="col-lg-6 mt-2">
            <div class="alert-danger" id="error">
            </div>
            <div id="loading" style="display: none;">Loading...</div>
            <form class="form-control" action="api/partner/send" method="post" style="display: none;" id="send">
                @csrf
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
                        <button type="submit" class="btn btn-primary">Отправить смс</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@include('footer')
<script>
    var loading = document.getElementById('loading');
    //  loading.style.display = 'block';
    token = localStorage.getItem('token');
    console.log(token)
    $.ajax({
        url: "{{ url('/api/partner/getActiveDocs') }}",
        type: "GET",
        headers: {
            'Authorization': 'Bearer ' + token,
        },
        success: function (response) {
            console.log(response)
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
        },
        error: function (xhr) {
            // handle the error
        },
        complete: function () {
            loading.style.display = 'none'; // hide the loading animation
        }
    });

    document.getElementById('send').addEventListener('submit', function (e) {
        e.preventDefault();
        docID = $("#select").val();
        let number = $("#phone").val();
        let ii = $("#iin").val();
        console.log(number)
        console.log(docID)
        console.log(ii)
        $.ajax({
            url: "{{ url('api/partner/send') }}",
            type: "POST",
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
                /*if (response.success) {
                  //  document.getElementById('success').style.display = "block";
                } else {
                  //  document.getElementById('fail').style.display = "none";
                }*/
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

