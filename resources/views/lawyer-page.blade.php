@include('header')
<div class="col-12 p-4">
    {{--
    <div id="loading" style="display: none;">Loading...</div>
    --}}
    <div id="loading" class="spinner-box">
        <div class="circle-border">
            <div class="circle-core"></div>
        </div>
    </div>
    <div class="panel" id="docs">
        <div class="panel-heading">
            <div class="row">
                <div class="col col-sm-3 col-xs-12">
                    <h4 class="title">Список Документов</h4>
                </div>

            </div>
        </div>
        <div class="panel-body table-responsive">
            <table id="table" class="table">
                <thead>
                <th scope="col">#</th>
                <th scope="col">Название документа</th>
                <th scope="col">Статус</th>
                <th scope="col">Документ</th>
                <th scope="col">Действие</th>

                </thead>
                <tbody id="docs_content">

                </tbody>
            </table>
        </div>
    </div>
</div>
@include('footer')

<script>
    let loading = document.getElementById('loading');
    loading.style.display = 'block';
    token = localStorage.getItem('token');
    console.log(token)
    let docc = document.getElementById('docs_content');
    $.ajax({
        url: "{{ url('/api/lawyer/uncheckingDocs') }}",
        type: "GET",
        headers: {
            'Authorization': 'Bearer ' + token,
        },
        success: function (response) {

            console.log(response)
            if (response.success) {

                for (let i = 0; i < response.doc.length; i++) {
                    let newRow = docc.insertRow();
                    let number = newRow.insertCell();
                    let name = newRow.insertCell();
                    let status = newRow.insertCell();
                    let app = newRow.insertCell();
                    let act = newRow.insertCell();

                    console.log(response[i])
                    number.textContent = i + 1;
                    name.textContent = response.doc[i].name;
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
                    let td = document.createElement('td')
                    let link = document.createElement('a');
                    link.textContent = 'Скачать'
                    link.style.color = 'white';
                    link.setAttribute('href', 'https://api.mircreditov.kz/uploads/' + response.doc[i].document)
                    app.appendChild(link)


                    let action = document.createElement('button')
                    action.textContent = 'Действие'
                    action.style.color = 'white'
                    action.setAttribute('id', response.doc[i].id)
                    act.appendChild(action)
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

                        let label = document.createElement('label')
                        label.textContent = 'Загружайте поправленный договор'
                        label.style.color = 'black'
                        modalBody.appendChild(label)

                        let file = document.createElement('input')
                        file.setAttribute('type', 'file')
                        file.setAttribute('id', 'file' + response.doc[i].id)
                        modalBody.appendChild(file)

                        let labelComment = document.createElement('label')
                        labelComment.textContent = 'Укажите комментарии'
                        labelComment.style.color = 'black'
                        modalBody.appendChild(labelComment)


                        let comment = document.createElement('textarea')
                        comment.setAttribute('type', 'text')
                        comment.setAttribute('name', 'comment')
                        comment.setAttribute('class', 'form-control')
                        comment.setAttribute('rows', 4)
                        comment.setAttribute('col', 50)
                        comment.setAttribute('id', 'comment' + response.doc[i].id)
                        modalBody.appendChild(comment)

                        let success = document.createElement('div')
                        success.setAttribute('class', 'alert-danger')
                        modalBody.appendChild(success)

                        let error = document.createElement('div')
                        error.setAttribute('class', 'alert-success')
                        modalBody.appendChild(error)

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

                        let saveButton = document.createElement('button')
                        saveButton.setAttribute('type', 'button')
                        saveButton.setAttribute('class', 'btn')
                        saveButton.setAttribute('class', 'btn-primary')
                        saveButton.setAttribute('id', 'save' + response.doc[i].id)
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

                        let hr = document.createElement('hr')
                        let hr2 = document.createElement('hr2')
                        modal.appendChild(hr)
                        modal.appendChild(hr2)
                        // add the modal element to the document
                        document.body.appendChild(modal);

                        // show the modal
                        $(modal).modal('show');

                        document.getElementById('save' + response.doc[i].id).addEventListener('click', function (e) {
                            e.preventDefault();
                            let fileName = document.querySelector('input[type="file"]').files[0];
                            let comment = document.getElementById('comment' + response.doc[i].id).value;
                            console.log(fileName)
                            console.log(response.doc[i].id)
                            let formData = new FormData();
                            formData.append('file',fileName)
                            formData.append('document_id', response.doc[i].id)
                            formData.append('comment',comment)
                            console.log(formData)


                            if (!fileName) {
                                $(modal).modal('hide')
                                return
                            }

                            $.ajax({
                                url: '/api/lawyer/approve',
                                type: 'POST',
                                data: formData,
                                contentType: false,
                                processData: false,

                                headers: {
                                    'Authorization': 'Bearer ' + token,
                                },
                                success: function (response) {
                                    console.log(response)
                                    document.getElementById('success').innerHTML = 'Успешно завершен'
                                },
                                error: function (response) {
                                    console.log(response)
                                    document.getElementById('error').innerHTML = 'Попробуйте позже'
                                }
                            })

                        });
                    })

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




    function fileToBase64(file) {
        let reader = new FileReader();
        let base64 = null;
        reader.onload = function(event) {
            base64 = event.target.result.split(',')[1];
        };
        reader.readAsDataURL(file);
        while (base64 === null) {
            // Wait for the reader to load the file
        }
        return base64;
    }

</script>
