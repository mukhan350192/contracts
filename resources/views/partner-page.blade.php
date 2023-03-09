@include('header')
<header>
    <div class="container py-lg-5 py-md-4 mt-4">
        <div class="row m-4">
            <nav id="sidebarMenu" class="d-lg-block sidebar bg-white">
                <div class="list-group list-group-flush mx-3 mt-4">

                    <div class="position-sticky">


                        <div class="col-lg-4">
                            <ul>
                                <li><a class="list-group-item list-group-item-action py-2 ripple"
                                       aria-current="true" href="#">Мои документы</a></li>
                                <li><a class="list-group-item list-group-item-action py-2 ripple"
                                       href="#">Отправить смс</a></li>
                                <li><a class="list-group-item list-group-item-action py-2 ripple" href="#">История
                                        сделок</a></li>
                                <li><a class="list-group-item list-group-item-action py-2 ripple" href="#"> История
                                        транзакцией</a></li>
                                <li><a class="list-group-item list-group-item-action py-2 ripple" href="#">Тарифы</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-8">

                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <div class="row m-8">
            <ul>
                @php
                        $docs = Session::get('docs');
                        var_dump(Session::get('user'));
                        if ($docs){
                            foreach ($docs as $doc){
                            @endphp
                        <li>{{$doc->name}}</li>
                @php
                        }
                    }else{
                        @endphp
                <li>Пока нету документов</li>
                @php
                    }
                @endphp

            </ul>
        </div>
    </div>
</header>
@include('footer')
