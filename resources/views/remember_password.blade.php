@include('header')
<div class="container">
    <div class="row">
        <div class="col-lg-4 mt-4 mb-4 col-xs-4 col-md-4">
            <div class="form-group">
                <input type="text"  class="form-control" name="phone" id="phone">
                <button type="button" class="btn btn-primary form-control mt-2">Восстановить пароль</button>
            </div>
        </div>
    </div>
</div>
@include('footer')
<script src="https://unpkg.com/imask"></script>
<script>
    var myInputMask = IMask(document.getElementById('phone'), {
        mask: '+{7}(000)000-00-00',
        lazy: false,
    });
</script>
