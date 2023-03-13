@include('header')

<div class="container py-lg-5 py-md-4">
    <div class="row align-items-center">
        <div class="col-lg-3"></div>
        <div class="col-lg-6 mt-4">

            <form action="" class="register">
                <div class="form-outline">


                    <a href="{!! $document !!}" class="title-small"><i class="fa fa-check" aria-hidden="true"></i> {{$name}}</a>
                </div>

                <button type="submit" class="btn btn-primary">Дальше</button>
            </form>
        </div>

    </div>
</div>
@include('footer')
