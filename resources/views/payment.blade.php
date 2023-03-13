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
    payment.addEventListener('submit', function (e){
        e.preventDefault();
        let token = localStorage.getItem('token');
        let amount = $("#amount").val()
        console.log(amount)
        $.ajax({
            type: 'POST',
            url: 'api/partner/pay',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + token,
            },
            data: {
                amount: amount,
            },
            success: function (res) {
                if (res.success){
                    window.location.replace(res.url)
                }
            },
            error: function (err) {
                console.log(err)
            }

        });
    });

</script>


{{--
--}}


{{--
payment.addEventListener('submit', function (e) {
let amount = document.getElementById('amount').value;
let token = localStorage.getItem('token');
console.log(token, amount)
e.preventDefault();
let xhr = new XMLHttpRequest();
xhr.open('POST','api/partner/pay');
xhr.setRequestHeader('Authorization','Bearer '+token);
const data = {
pay:amount,
name: 'JOHN',
};

let json = JSON.stringify(data);
xhr.onload = function (){
console.log(xhr.response)
}
xhr.send(json)
console.log(json)
});--}}
