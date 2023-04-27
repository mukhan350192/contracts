@include('header')
<div class="col-8 p-4">
    {{--
    <div id="loading" style="display: none;">Loading...</div>
    --}}
    <div id="loading" class="spinner-box">
        <div class="circle-border">
            <div class="circle-core"></div>
        </div>
    </div>
    <div class="panel col-md-12" id="docs">
        <div class="panel-heading">
            <div class="row">
                <div class="col col-sm-3 col-xs-12">
                    <h4 class="title">Список Документов</h4>
                </div>

            </div>
        </div>
        <div class="panel-body table-responsive">
            <table id="table" class="table" style="display: none;">
                <thead>
                <th scope="col">#</th>
                <th scope="col">Название документа</th>
                <th scope="col">Статус</th>
                <th scope="col">Документ</th>
                </thead>
                <tbody id="docs_content">
                <tr>

                </tr>
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

    $.ajax({
        url: "{{ url('/api/client/getDocs') }}",
        type: "GET",
        headers: {
            'Authorization': 'Bearer ' + token,
        },
        success: function (response) {
            console.log('heare')
            console.log(response)
            if (response.success) {
                let doc = document.getElementById('docs_content');

                for (let i = 0; i < response.doc.length; i++) {
                    let newRow = doc.insertRow();
                    let number = newRow.insertCell();
                    let name = newRow.insertCell();
                    let status = newRow.insertCell();
                    let doc = newRow.insertCell();

                    number.textContent = i + 1;
                    name.textContent = response.doc[i].name;
                    status.textContent = response.doc[i].status ? 'Проверен' : 'В проверке';
                    doc.textContent = response.doc[i].document

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
