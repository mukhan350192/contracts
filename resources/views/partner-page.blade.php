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

            <div id="loading" style="display: none;">Loading...</div>
            <div class="col-8 p-4">
                <table class="table">
                    <thead>
                    <th scope="col">#</th>
                    <th scope="col">Название документа</th>
                    <th scope="col">Статус</th>
                    </thead>
                    <tbody id="docs">

                    </tbody>
                </table>
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
                let doc = document.getElementById('docs');
                for (let i = 0; i < response.doc.length; i++) {
                    console.log(response.doc[0].name)
                    let newRow = doc.insertRow();
                    let number = newRow.insertCell();
                    let name = newRow.insertCell();
                    let status = newRow.insertCell();
                    //let date = newRow.insertCell();

                    number.textContent = i + 1;
                    name.textContent = response.doc[0].name;
                    status.textContent = response.doc[0].status ? 'Проверен' : 'В проверке';
                    //date.textContent = response.doc[0].created_at

                }
            }
        },
        error: function (xhr) {
            // handle the error
        },
        complete: function () {
            loading.style.display = 'none'; // hide the loading animation
        }
    });
</script>
