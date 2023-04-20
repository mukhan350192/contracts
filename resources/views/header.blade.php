<!DOCTYPE html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('assets/css/app.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <meta name="csrf-token" content="{{csrf_token()}}">
</head>
<div class="container-fluid">
    <div class="row">
{{--        <nav class="navbar navbar-expand-lg navbar-light bg-light m-10">--}}
        <nav class="navbar navbar-expand-lg navbar-dark pt-10" style="background-color: #516BEB;">
            <div class="container-fluid">
                <a class="navbar-brand" id="main_menu" href="#">Navbar</a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" onclick="check()">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse topnav" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/#rates">+77771112233</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/#rates">Тарифы</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#features">Преимущества</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#howItWorks">Как это работает?</a>
                        </li>
                        <li class="nav-item" id="personal">
                            <a class="nav-link" id="personal">Личный кабинет</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.lordicon.com/ritcuqlt.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js" integrity="sha512-1/RvZTcCDEUjY/CypiMz+iqqtaoQfAITmNSJY17Myp4Ms5mdxPS5UV7iOfdZoxcGhzFbOm6sntTKJppjvuhg4g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    function check(){
        console.log('here')
    }

    const personal = document.getElementById('personal');
    personal.addEventListener("click",function (event){
       event.preventDefault();
       let token = localStorage.getItem('token')
        if (token){
            window.location.href = 'partner-page'
        }else{
            window.location.href = 'login'
        }
    });
</script>
