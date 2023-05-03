@include('header')
<div class="container">
    <div class="row mt-5">

        @include('sidebar')
        <div class="col-lg-8 mt-2">


            <div class="panel col-md-12" id="deals">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-sm-3 col-xs-12">
                            <h4 class="title">Список отправленных смс</h4>
                        </div>

                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <div id="error">

                    </div>
                    <table id="table" class="table" style="display: none;">
                        <thead>
                        <th scope="col">#</th>
                        <th scope="col">Сумма</th>
                        <th scope="col">Тип</th>
                        <th scope="col">Прежный баланс</th>
                        <th scope="col">Текущий баланс</th>
                        <th scope="col">Описание</th>
                        <th scope="col">Время</th>
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

<script>
    let token = localStorage.getItem('token');
    $.ajax({
        type: 'GET',
        url: 'api/partner/transaction',
        headers: {
            'Authorization': 'Bearer ' + token,
        },
        success: function (response) {
            if (!response.success) {
                document.getElementById('error').innerHTML='<h3 class="text-center">У вас пока нету истории транзакции</h3>';
            }else{
                document.getElementById('table').style.display = "block";
                let docs = response.data;
                console.log(docs)
                let content = '';
                let index = 0;
                for (let i = 0; i < docs.transactions.length; i++) {
                    console.log(docs.transactions[i].amount)
                    index++;
                    let status = '';
                    if (docs.transactions[i].status == 'income'){
                        status = 'Приход';
                    }else{
                        status = 'Расход';
                    }
                    let now = new Date(docs.transactions[i].created_at);
                    const day = now.getDate().toString().padStart(2, '0'); // add leading zero if needed
                    const month = (now.getMonth() + 1).toString().padStart(2, '0'); // months start from 0, so add 1
                    const year = now.getFullYear().toString();
                    const hour = now.getHours().toString().padStart(2, '0');
                    const minute = now.getMinutes().toString().padStart(2, '0');
                    const second = now.getSeconds().toString().padStart(2, '0');
                    const formattedDate = `${day}.${month}.${year} ${hour}:${minute}:${second}`;

                    content += '<tr>';
                    content += '<td>' + index + '</td>';
                    content += '<td>' + docs.transactions[i].amount + '</td>';
                    content += '<td>' + status + '</td>';
                    content += '<td>' + docs.transactions[i].balance_before + '</td>';
                    content += '<td>' + docs.transactions[i].balance_after + '</td>';
                    content += '<td>' + docs.transactions[i].description + '</td>';
                    content += '<td>' + formattedDate + '</td>';
                    content += '</tr>';
                }
                document.getElementById('docs_content').innerHTML = content;
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
</script>
@include('footer')
