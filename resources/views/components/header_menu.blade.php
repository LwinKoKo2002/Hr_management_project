@props(['title'])
<div class="heading-menu">
    <div class="d-flex justify-content-center">
        <div class="col-md-10">
            <div class="row">
                @if (request()->is('/'))
                <a class="col-3 text-center" href="">
                    <i class="fas fa-bars" id="show-sidebar"></i>
                </a>
                @else
                <a class="col-3 text-center" href="">
                    <i class="fa-solid fa-angle-left" id="backBtn"></i>
                </a>
                @endif

                <div class="col-6 text-center">
                    <h5>{{$title}}</h5>
                </div>
                <a class="col-3 text-center" href="">
                    <i class="fa-solid fa-bell"></i>
                </a>
            </div>
        </div>
    </div>
</div>