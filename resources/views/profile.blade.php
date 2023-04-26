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
               <div class="panel" id="profile">
                   <div class="col-lg-8">
                       <div class="card mb-4">
                           <div class="card-body">
                               <div class="row">
                                   <div class="col-sm-3">
                                       <p class="mb-0">ФИО</p>
                                   </div>
                                   <div class="col-sm-9">
                                       <p class="text-muted mb-0" id="name"></p>
                                   </div>
                               </div>
                               <hr>
                               <div class="row">
                                   <div class="col-sm-3">
                                       <p class="mb-0">Телефон</p>
                                   </div>
                                   <div class="col-sm-9">
                                       <p class="text-muted mb-0" id="phone"></p>
                                   </div>
                               </div>
                               <hr>
                               <div class="row">
                                   <div class="col-sm-3">
                                       <p class="mb-0">ИИН</p>
                                   </div>
                                   <div class="col-sm-9">
                                       <p class="text-muted mb-0" id="iin"></p>
                                   </div>
                               </div>
                               <hr>
                           </div>
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
        url: "{{ url('/api/partner/profile') }}",
        type: "GET",
        headers: {
            'Authorization': 'Bearer ' + token,
        },
        success: function (response) {
            document.getElementById('name').innerHTML = response[0].name;
            document.getElementById('phone').innerHTML = response[0].phone;
            document.getElementById('iin').innerHTML = response[0].iin;
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
