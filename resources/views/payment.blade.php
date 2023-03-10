@include('header')
<div class="container">
    <div class="row">
        <div class="col-4">
            @include('sidebar')
        </div>
        <div class="col-8 mt-5">
            <form id="payment" action="api/partner/payment" method="POST" class="form-outline">
                <div class="alert-success">
                    Оплата
                </div>
                @csrf
                <label>Введите сумму</label><br>
                <input type="number" id="amount">
                <button type="submit" id="pay" class="btn btn-primary mt-2">Оплатить</button>
            </form>
        </div>
    </div>
</div>

@include('footer')
<script type="text/javascript">
    let payment = document.getElementById('payment');
    payment.addEventListener('submit', function (e) {
        let amount = document.getElementById('amount').value;
        let token = localStorage.getItem('token');
        console.log(token, amount)
        e.preventDefault();
        let xhr = new XMLHttpRequest();
        let data = new FormData();
        data.append('amount',amount);
        xhr.open('POST','api/partner/pay');
        xhr.setRequestHeader('Authorization','Bearer '+token);
        xhr.send(JSON.stringify(data))
        xhr.onreadystatechange = function (response){
            if (xhr.readyState == 4 && xhr.status == 200){
                console.log(xhr.response)
            }
            console.log(xhr.response)
        }
    });
</script>


{{--
$.ajax({
type: 'POST',
url: 'api/partner/payment',
headers: {
'Accept': 'application/json',
'Authorization': 'Bearer ' + token,
'X-CSRF-TOKEN': {{csrf_token()}},
},
data: {
'amount': amount,
},
success: function (res) {
console.log(res)
},
error: function (err) {
console.log(err)
}

});--}}
