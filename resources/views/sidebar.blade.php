<div class="col-lg-4">
    <ul class="sidebar">
        <li><a class="list-group-item list-group-item-action py-2 ripple"
               href="{{url('partner-page')}}">Мои документы</a></li>
        <li><a class="list-group-item list-group-item-action py-2 ripple"
               href="{{url('upload')}}">Загрузить договор</a></li>
        <li><a class="list-group-item list-group-item-action py-2 ripple"
               href="{{url('send')}}">Отправить смс</a></li>
        <li><a class="list-group-item list-group-item-action py-2 ripple" href="#">История
                сделок</a></li>
        <li><a class="list-group-item list-group-item-action py-2 ripple" href="#"> История
                транзакцией</a></li>
        <li><a class="list-group-item list-group-item-action py-2 ripple"
               href="#">Тарифы</a>
        </li>
        <li><a class="list-group-item list-group-item-action py-2 ripple"
               href="{{url('payment')}}">Пополнить баланс</a>
        </li>
    </ul>
</div>

<script type="text/javascript">
    $(function(){
        // $('.sidebar1 a').filter(function(){return this.href==location.href}).parent().addClass('active').siblings().removeClass('active'); i have not tried this line
        $('.sidebar a').click(function(){
            $(".list-group-item").removeClass('active');
            $(this).addClass('active');
        })
    })
</script>
