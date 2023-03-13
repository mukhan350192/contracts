@include('header')
<header>
    <div class="container py-lg-5 py-md-4 mt-4">
        <div class="row">
            <div class="col-4">
                <nav id="sidebarMenu" class="d-lg-block sidebar bg-white">
                    <div class="list-group list-group-flush mx-3 mt-4">

                        <div class="position-sticky">


                            @include('sidebar')
                            <div class="col-lg-8">

                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="col-8 p-4">
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
                        <table id="table" class="table" style="display: none;">
                            <thead>
                            <th scope="col">#</th>
                            <th scope="col">Название документа</th>
                            <th scope="col">Статус</th>
                            </thead>
                            <tbody id="docs_content">
                                <tr>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</header>
@include('footer')

<script>
    var loading = document.getElementById('loading');
    loading.style.display = 'block';
    token = localStorage.getItem('token');
    console.log(token)
    $.ajax({
        url: "{{ url('/api/partner/getDocs') }}",
        type: "GET",
        headers: {
            'Authorization': 'Bearer ' + token,
        },
        success: function (response) {
            if (response.success) {
                let doc = document.getElementById('docs_content');
                console.log(doc)
                for (let i = 0; i < response.doc.length; i++) {
                    let newRow = doc.insertRow();
                    let number = newRow.insertCell();
                    let name = newRow.insertCell();
                    let status = newRow.insertCell();
                    //let date = newRow.insertCell();

                    number.textContent = i + 1;
                    name.textContent = response.doc[i].name;
                    status.textContent = response.doc[i].status ? 'Проверен' : 'В проверке';
                    //date.textContent = response.doc[0].created_at

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
