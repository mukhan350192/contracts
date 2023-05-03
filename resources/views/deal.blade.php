@include('header')
<div class="container">
    <div class="row mt-5">

        @include('sidebar')
        <div class="col-lg-8 mt-2">

            <div id="loading" class="spinner-box">
                <div class="circle-border">
                    <div class="circle-core"></div>
                </div>
            </div>
            <div class="panel col-md-12" id="deals">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-sm-3 col-xs-12">
                            <h4 class="title">Список отправленных смс</h4>
                        </div>

                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <table id="table" class="table" style="display: none;">
                        <thead>
                        <th scope="col">#</th>
                        <th scope="col">Название документа</th>
                        <th scope="col">ИИН подписанта</th>
                        <th scope="col">Телефон подписанта</th>
                        <th scope="col">Статус</th>
                        <th scope="col">Время отправки смс</th>
                        <th scope="col">Действие</th>
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


@include('footer')

<script>
    var loading = document.getElementById('loading');
    loading.style.display = 'block';
    token = localStorage.getItem('token');
    console.log(token)
    $.ajax({
        url: "{{ url('/api/partner/getSendingSMS') }}",
        type: "GET",
        headers: {
            'Authorization': 'Bearer ' + token,
        },
        success: function (response) {
            console.log(response.success)
            if (response.success) {
                let doc = document.getElementById('docs_content');
                console.log(response.data.length)
                for (let i = 0; i < response.data.length; i++) {
                    let newRow = doc.insertRow();
                    let number = newRow.insertCell();
                    let name = newRow.insertCell();
                    let iin = newRow.insertCell();
                    let phone = newRow.insertCell();
                    let status = newRow.insertCell();
                    let date = newRow.insertCell();
                    let details = newRow.insertCell();

                    number.textContent = i + 1;
                    console.log(response.data[i])
                    let link = document.createElement('a')
                    link.href = 'uploads/' + response.data[i].sending_docs.document;
                    link.textContent = response.data[i].sending_docs.name;
                    link.style.color = 'black'
                    name.appendChild(link);

                    iin.textContent = response.data[i].iin;
                    phone.textContent = response.data[i].phone;

                    status.textContent = response.data[i].status ? 'Подписан': 'Еще не подписан'
                    if (response.data[i].status == 1) {
                        let button = document.createElement('button')
                        button.classList.add('btn', 'btn-primary')
                        button.setAttribute('id', response.data[i].id)
                        button.textContent = 'Детали'
                        details.appendChild(button)

                       document.getElementById(response.data[i].id).addEventListener('click', function (e) {
                           e.preventDefault();
                           console.log('test1')
                            $.ajax({
                               type: "GET",
                                url: '/api/partner/getSigningSMS?userID='+response.data[i].user_id,
                                headers: {
                                    'Authorization': 'Bearer ' + token,
                                },
                                success: function (response) {
                                   console.log(response)
                                    const modal = document.createElement('div');
                                    modal.classList.add('modal', 'fade');
                                    modal.setAttribute('tabindex', '-1');
                                    modal.setAttribute('role', 'dialog');
                                    modal.setAttribute('aria-labelledby', 'exampleModalLabel');
                                    modal.setAttribute('aria-hidden', 'true');

                                    // create the modal dialog element
                                    const modalDialog = document.createElement('div');
                                    modalDialog.classList.add('modal-dialog');
                                    modalDialog.setAttribute('role', 'document');

                                    // create the modal content element
                                    const modalContent = document.createElement('div');
                                    modalContent.classList.add('modal-content');

                                    // create the modal header element
                                    const modalHeader = document.createElement('div');
                                    modalHeader.classList.add('modal-header');

                                    let title = document.createElement('h5')
                                    title.textContent = 'Детали'
                                    modalHeader.appendChild(title)

                                    let closeButton = document.createElement('button')
                                    closeButton.setAttribute('type', 'button')
                                    closeButton.setAttribute('class', 'close')
                                    closeButton.setAttribute('data-bs-dismiss', 'modal')
                                    closeButton.setAttribute('aria-label', 'Close')

                                    let span = document.createElement('span')
                                    span.setAttribute('aria-hidden', 'true')
                                    span.textContent = 'X';
                                    closeButton.appendChild(span)

                                    modalHeader.appendChild(closeButton)
                                    // create the modal body element
                                    const modalBody = document.createElement('div');
                                    modalBody.classList.add('modal-body');

                                    //create table with four columns
                                    let table = document.createElement('table')
                                    table.classList.add('table')
                                    let thead = document.createElement('thead')
                                    let tr = document.createElement('tr')
                                    let th1 = document.createElement('th')
                                    th1.textContent = 'ФИО подписанта'
                                    let th2 = document.createElement('th')
                                    th2.textContent = 'ИИН подписанта'
                                    let th3 = document.createElement('th')
                                    th3.textContent = 'Телефон подписанта'
                                    let th4 = document.createElement('th')
                                    th4.textContent = 'УДВ подписанта'
                                    tr.appendChild(th1)
                                    tr.appendChild(th2)
                                    tr.appendChild(th3)
                                    tr.appendChild(th4)
                                    thead.appendChild(tr)
                                    table.appendChild(thead)

                                    let tbody = document.createElement('tbody')
                                    let tr1 = document.createElement('tr')
                                    let td1 = document.createElement('td')
                                    td1.textContent = response.data[i].sign_history.lastName+" "+response.data[i].sign_history.firstName+" "+response.data[i].sign_history.middleName;
                                    let td2 = document.createElement('td')
                                    td2.textContent = response.data[i].sign_history.iin
                                    let td3 = document.createElement('td')
                                    td3.textContent = response.data[i].sign_history.phone
                                    let td4 = document.createElement('td')
                                    let img = document.createElement('img')
                                    img.src = 'docs/'+response.data[i].sign_history.originalImage
                                    img.style.width = '100px'
                                    td4.appendChild(img)
                                    tr1.appendChild(td1)
                                    tr1.appendChild(td2)
                                    tr1.appendChild(td3)
                                    tr1.appendChild(td4)
                                    tbody.appendChild(tr1)
                                    table.appendChild(tbody)
                                    modalBody.appendChild(table)


                                    // create the modal footer element
                                    const modalFooter = document.createElement('div');
                                    modalFooter.classList.add('modal-footer');


                                    let modalCloseButton = document.createElement('button')
                                    modalCloseButton.setAttribute('type', 'button')
                                    modalCloseButton.setAttribute('class', 'btn')
                                    modalCloseButton.setAttribute('class', 'btn-secondary')
                                    modalCloseButton.setAttribute('data-bs-dismiss', 'modal')
                                    modalCloseButton.textContent = 'Закрыть'
                                    modalFooter.appendChild(modalCloseButton)

                                    // append the elements to the modal content element
                                    modalContent.appendChild(modalHeader);
                                    modalContent.appendChild(modalBody);
                                    modalContent.appendChild(modalFooter);

                                    // append the modal content to the modal dialog element
                                    modalDialog.appendChild(modalContent);

                                    // append the modal dialog to the modal element
                                    modal.appendChild(modalDialog);

                                    // add the modal element to the document
                                    document.body.appendChild(modal);

                                    // show the modal
                                    $(modal).modal('show');
                                },
                                error: function (e){
                                    console.log(e)
                                }
                            });


                        })
                    }

                    let now = new Date(response.data[i].updated_at);
                    const day = now.getDate().toString().padStart(2, '0'); // add leading zero if needed
                    const month = (now.getMonth() + 1).toString().padStart(2, '0'); // months start from 0, so add 1
                    const year = now.getFullYear().toString();
                    const hour = now.getHours().toString().padStart(2, '0');
                    const minute = now.getMinutes().toString().padStart(2, '0');
                    const second = now.getSeconds().toString().padStart(2, '0');
                    const formattedDate = `${day}.${month}.${year} ${hour}:${minute}:${second}`;

                    date.textContent = formattedDate;



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
