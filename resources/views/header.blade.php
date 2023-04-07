<!DOCTYPE html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://api.mircreditov.kz/assets/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <meta name="csrf-token" content="{{csrf_token()}}">
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light m-10">
    <div class="container-fluid m-4 fixed-top">
        <a class="navbar-brand" id="main_menu" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#rates">+77771112233</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#rates">Тарифы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#features">Преимущества</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#howItWorks">Как это работает?</a>
                </li>
                <li class="nav-item" id="personal">
                    <a class="nav-link" id="personal">Личный кабинет</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
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
