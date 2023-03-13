@include('header')
<div class="col-12 p-4">
    {{--
    <div id="loading" style="display: none;">Loading...</div>
    --}}
    <div id="loading" class="spinner-box">
        <div class="circle-border">
            <div class="circle-core"></div>
        </div>
    </div>
    <div class="panel" id="docs">
        <div class="panel-heading">
            <div class="row">
                <div class="col col-sm-3 col-xs-12">
                    <h4 class="title">Список Документов</h4>
                </div>

            </div>
        </div>
        <div class="panel-body table-responsive">
            <table id="table" class="table">
                <thead>
                <th scope="col">#</th>
                <th scope="col">Название документа</th>
                <th scope="col">Статус</th>
                <th scope="col">Документ</th>

                </thead>
                <tbody id="docs_content">

                </tbody>
            </table>
        </div>
    </div>
</div>
@include('footer')

<script>
    let loading = document.getElementById('loading');
    loading.style.display = 'block';
    token = localStorage.getItem('token');
    let docc = document.getElementById('docs_content');
    $.ajax({
        url: "{{ url('/api/manager/getAllDocs') }}",
        type: "GET",
        headers: {
            'Authorization': 'Bearer ' + token,
        },
        success: function (response) {

            if (response.success) {


                for (let i = 0; i < response.docs.length; i++) {
                    let newRow = docc.insertRow();
                    let number = newRow.insertCell();
                    let name = newRow.insertCell();
                    let status = newRow.insertCell();


                    console.log(response[i])
                    number.textContent = i + 1;
                    name.textContent = response.docs[i].name;
                    status.textContent = response.docs[i].status ? 'Проверен' : 'В проверке';
                    let td = document.createElement('td')
                    let link = document.createElement('a');
                    link.textContent = 'Скачать'
                    link.style.color = 'white';
                    link.setAttribute('href', 'https://api.mircreditov.kz/uploads/' + response.docs[i].document)
                    newRow.appendChild(link)

                    let approve = document.createElement('button')
                    approve.textContent = 'Approve';
                    approve.setAttribute('type', 'submit')
                    approve.style.color = 'white';
                    approve.addEventListener('click', function (e) {
                        e.preventDefault();
                        $.ajax({
                            url: "{{ url('/api/manager/approve') }}",
                            type: "POST",
                            headers: {
                                'Authorization': 'Bearer ' + token,
                            },
                            data: {
                                documentID: response.docs[i].id,
                            },
                            success: function (response) {
                                window.location.reload()
                            },
                        });
                    });
                    newRow.appendChild(approve)

                }
            }
        },
        error: function (xhr) {
            // handle the error
        },
        complete: function () {
            loading.style.display = 'none'; // hide the loading animation
            document.getElementById('table').style.display = "block"
        }
    });

</script>
