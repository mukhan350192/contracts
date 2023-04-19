<div class="wrapper col-lg-4">
    <!-- Sidebar Holder -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>Меню</h3>
        </div>

        <ul class="list-unstyled components">
            <li>
                    <li><a href="{{url('partner-page')}}">Мои документы</a></li>
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
    function logout(){
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
</script>
