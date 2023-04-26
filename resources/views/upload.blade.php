@include('header')
<div class="container">
    <div class="row mt-5">

        @include('sidebar')
        <div class="col-lg-6 mt-2">
            <div class="alert-success" style="display: none;" id="success">
                <strong>Успешно загружен ваш документ</strong>
            </div>
            <div class="alert-danger" style="display: none;" id="danger">
                <strong>Произошло ошибка, попробуйте позже</strong>
            </div>
            <div class="alert-danger" style="display: none;" id="error">

            </div>
            <form id="upload" method="post" class="register" action="api/partner/addDocs">
                @csrf
                <strong class="form-outline mb-4 text-center">Загружайте свои документы отсюда</strong>

                <div class="form-outline mb-4 mt-5 text-center">
                    <label>Введите название документа</label>
                    <input name="name" class="form-control input-lg bg-light">
                </div>
                <div class="form-outline mb-4 text-center">
                    <label>Загружайте документ</label>
                    <input type="file" name="doc" class="form-control input-lg bg-light">
                </div>
                <div class="d-flex justify-content-center text-center">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('footer')

<script type="text/javascript">
    document.getElementById('upload').addEventListener('submit', function (e) {
        e.preventDefault();
        let token = localStorage.getItem('token');
        let xhr = new XMLHttpRequest();
        xhr.open('POST', this.action);
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                let response = JSON.parse(xhr.response)
                let success = response.success;
                if (success) {
                    document.getElementById('success').style.display = "block";
                } else {
                    document.getElementById('danger').style.display = "block";
                }
            }
            if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 422){
                document.getElementById('error').innerHTML = 'Загружайте файлы только в формате pdf,doc,docx';
                document.getElementById('error').style.display = "block";
            }
        }
        xhr.send(new FormData(this));
    });
</script>
