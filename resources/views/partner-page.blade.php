@include('header')
<header>
    <div class="container py-lg-5 py-md-4 mt-4">
        <div class="row">
            <div class="col-3 col-md-12">
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

            <div class="col-9 p-4 col-md-12 col-sm-12">
                {{--
                <div id="loading" style="display: none;">Loading...</div>
                --}}
                <div id="loading" class="spinner-box">
                    <div class="circle-border">
                        <div class="circle-core"></div>
                    </div>
                </div>
                <div class="panel col-md-12" id="docs">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-sm-3 col-xs-12">
                                <h4 class="title">Список Документов</h4>
                            </div>

                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table id="table" class="table" style="display: none;">
                            <thead>
                            <th scope="col">#</th>
                            <th scope="col">Название документа</th>
                            <th scope="col">Статус</th>
                            <th scope="col">Дата загрузки</th>
                            <th scope="col">Перейти к подписанию</th>
                            <th scope="col">Действие</th>
                            <th scope="col">Подтверждение</th>
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
            console.log(response)
            if (response.success) {
                let doc = document.getElementById('docs_content');
                console.log(response)
                for (let i = 0; i < response.doc.length; i++) {
                    let newRow = doc.insertRow();
                    let number = newRow.insertCell();
                    let name = newRow.insertCell();
                    let status = newRow.insertCell();
                    let date = newRow.insertCell();
                    let send = newRow.insertCell();
                    let open = newRow.insertCell();
                    let app = newRow.insertCell();

                    let link = document.createElement('a')
                    link.href = 'uploads/' + response.doc[i].document;
                    link.textContent = response.doc[i].name;
                    link.style.color = 'black'

                    if (response.doc[i].status.status_id == 2) {
                        let button = document.createElement('button')
                        button.classList.add('btn', 'btn-primary')
                        button.setAttribute('id', response.doc[i].id)
                        button.textContent = 'Отправить на корректировку'
                        open.appendChild(button)

                        let approve = document.createElement('button')
                        approve.classList.add('btn', 'btn-primary')
                        approve.setAttribute('id', 'approve'+response.doc[i].id)
                        approve.textContent = 'Подтвердить'
                        app.appendChild(approve)

                        document.getElementById(response.doc[i].id).addEventListener('click', function (e) {
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
                            title.textContent = 'Корректировка'
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


                            let comment = document.createElement('textarea')
                            comment.setAttribute('type', 'text')
                            comment.setAttribute('class', 'form-control')
                            comment.setAttribute('rows', 4)
                            comment.setAttribute('col', 50)
                            modalBody.appendChild(comment)

                            // create the modal footer element
                            const modalFooter = document.createElement('div');
                            modalFooter.classList.add('modal-footer');
                            /*modalFooter.innerHTML = `
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      `;*/

                            let modalCloseButton = document.createElement('button')
                            modalCloseButton.setAttribute('type', 'button')
                            modalCloseButton.setAttribute('class', 'btn')
                            modalCloseButton.setAttribute('class', 'btn-secondary')
                            modalCloseButton.setAttribute('data-bs-dismiss', 'modal')
                            modalCloseButton.textContent = 'Закрыть'
                            modalFooter.appendChild(modalCloseButton)

                            let saveButton = document.createElement('button')
                            saveButton.setAttribute('type', 'button')
                            saveButton.setAttribute('class', 'btn')
                            saveButton.setAttribute('class', 'btn-primary')
                            saveButton.setAttribute('id', response.doc[i].id)
                            saveButton.textContent = 'Сохранить'
                            modalFooter.appendChild(saveButton)

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
                        })

                        document.getElementById('approve'+response.doc[i].id).addEventListener('click',function (e){
                            $.ajax({
                                url: 'api/partner/approve?documentID='+response.doc[i].id,
                                type: 'GET',
                                headers: {
                                    'Authorization': 'Bearer '+ token,
                                },
                                success: function (response){
                                    window.location.href='partner-page'
                                },
                                error: function (response){
                                    alert('Попробуйте позже')
                                }
                            })
                        })
                    }


                    if (response.doc[i].status == 4) {
                        let sendLink = document.createElement('a');
                        sendLink.href = '/send'
                        sendLink.textContent = 'Перейти'
                        send.appendChild(sendLink)
                    }


                    number.textContent = i + 1;
                    name.appendChild(link);
                    let statusText = '';
                    if (response.doc[i].status.status_id == 1){
                        statusText = 'В проверке';
                    }
                    if (response.doc[i].status.status_id == 2){
                        statusText = 'Проверен юристами';
                    }
                    if (response.doc[i].status.status_id == 3){
                        statusText = 'На корректировке'
                    }
                    if (response.doc[i].status.status_id == 4){
                        statusText = 'Подтвержден'
                    }
                    status.textContent = statusText;
                    date.textContent = response.doc[0].updated_at



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
