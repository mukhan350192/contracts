<div class="col-md-12 col-sm-12">
    <select name="" id="menu_select" selected="selected" class="mb-2 mt-2 col-md-12 form-select">
        <option value="profile">Профиль</option>
        <option value="partner-page" id="docs">Мои документы</option>
        <option value="upload">Загрузить договор</option>
        <option value="send">Отправить смс</option>
        <option value="dealHistory">История сделок</option>
        <option value="transactionHistory">История транзакцией</option>
        <option value="rates">Тарифы</option>
        <option value="payment">Пополнить баланс</option>
        <option id="logout" href="#" onclick="logout()">Выйти</option>

    </select>
</div>
<div class="wrapper col-lg-4 col-md-12 col-sm-12">
    <!-- Sidebar Holder -->

    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>Меню</h3>
        </div>

        <ul class="list-unstyled components">
            <li>
                    <li><a href="{{url('profile')}}">Профиль</a></li>
                    <li><a href="{{url('partner-page')}}" id="docs">Мои документы</a></li>
                    <li><a href="{{url('upload')}}">Загрузить договор</a></li>
                    <li><a href="{{url('send')}}">Отправить смс</a></li>
                    <li><a href="{{url('dealHistory')}}">История сделок</a></li>
                    <li><a href="{{url('transactionHistory')}}">История транзакцией</a></li>
                    <li><a href="{{url('rates')}}">Тарифы</a></li>
                    <li><a href="{{url('payment')}}">Пополнить баланс</a></li>
                    <li><a id="logout" href="#" onclick="logout()">Выйти</a></li>

            </li>
        </ul>

    </nav>
</div>
<script type="text/javascript">
    let menu_select = document.getElementById('menu_select');
    let storedSelect = localStorage.getItem('menu_select');

    if (storedSelect){
        menu_select.value = storedSelect;
    }
    menu_select.addEventListener('change', (event) => {
        const selectedOption = event.target.value;
        localStorage.setItem('menu_select', selectedOption);
    });
    // Create default option "Go to..."
    $("#menu_select").change(function(e) {
        window.location = $(this).find("option:selected").val();
    });
    function logout(){
        let token = localStorage.getItem('token')
        console.log(token)
        $.ajax({
            type: 'GET',
            url: 'api/partner/logout',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token,
            },
            success: function (res) {
               console.log(res)
            },
            error: function (err) {
                document.getElementById('error').style.display = "block";
            }
        });
        localStorage.removeItem('token')
        window.location.href='/';
    }

    $('#body-row .collapse').collapse('hide');

    // Collapse/Expand icon
    $('#collapse-icon').addClass('fa-angle-double-left');

    // Collapse click
    $('[data-toggle=sidebar-colapse]').click(function() {
        SidebarCollapse();
    });

    function SidebarCollapse () {
        $('.menu-collapsed').toggleClass('d-none');
        $('.sidebar-submenu').toggleClass('d-none');
        $('.submenu-icon').toggleClass('d-none');
        $('#sidebar-container').toggleClass('sidebar-expanded sidebar-collapsed');

        // Treating d-flex/d-none on separators with title
        var SeparatorTitle = $('.sidebar-separator-title');
        if ( SeparatorTitle.hasClass('d-flex') ) {
            SeparatorTitle.removeClass('d-flex');
        } else {
            SeparatorTitle.addClass('d-flex');
        }

        // Collapse/Expand icon
        $('#collapse-icon').toggleClass('fa-angle-double-left fa-angle-double-right');
    }

    document.getElementById('docs').addEventListener('click',function (e){
        token = localStorage.getItem('token');
        console.log(token)
        $.ajax({
            url: "{{ url('/api/partner/getDocs') }}",
            type: "GET",
            headers: {
                'Authorization': 'Bearer ' + token,
            },
        });
    })
</script>
