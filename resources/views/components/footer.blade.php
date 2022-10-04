@props(['script'])
<!-- Bootstrap Core Js -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" svfa0b4Q"
    crossorigin="anonymous">
</script>
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/g/mark.js(jquery.mark.min.js)"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.js"></script>
<!-- Daterange Picker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- Sweetalert 2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Select 2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Bootstrap Pin Code Input Js -->
<script src="{{asset('/js/bootstrap-pincode-input.js')}}"></script>
<!-- Qr Scanner -->
<script src="{{asset('/js/qr-scanner.umd.min.js')}}"></script>
<!-- Viewer Js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.5/viewer.min.js"></script>
<!-- jsDelivr :: Sortable :: Latest (https://www.jsdelivr.com/package/npm/sortablejs) -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
{{$script}}
<script>
    jQuery(function ($) {
    $(".sidebar-dropdown > a").click(function () {
        $(".sidebar-submenu").slideUp(200);
        if ($(this).parent().hasClass("active")) {
            $(".sidebar-dropdown").removeClass("active");
            $(this).parent().removeClass("active");
        } else {
            $(".sidebar-dropdown").removeClass("active");
            $(this).next(".sidebar-submenu").slideDown(200);
            $(this).parent().addClass("active");
        }
    });

    $("#close-sidebar").click(function (e) {
        e.preventDefault();
        $(".page-wrapper").removeClass("toggled");
    });
    $("#show-sidebar").click(function (e) {
        e.preventDefault();
        $(".page-wrapper").addClass("toggled");
    });

    @if(request()->is('/'))
    document.addEventListener("click", function (event) {
        if (document.getElementById("show-sidebar").contains(event.target)) {
            $(".page-wrapper").addClass("toggled");
        } else if (!document.getElementById('sidebar').contains(event.target) )
        {
            $(".page-wrapper").removeClass("toggled");
        }
    });
    @endif
});
    // Csrf token
    let token = document.head.querySelector('meta[name="csrf-token"]');
    if(token){
        $.ajaxSetup({
            headers: {
                'X-CSRF_TOKEN' : token.content
            }
        })
    }

    // Sweet alert
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    @if(session('create'))
    Toast.fire({
        icon: 'success',
        title: "{{session('create')}}"
    })
    @endif

    @if(session('update'))
    Toast.fire({
        icon: 'success',
        title: "{{session('update')}}"
    })
    @endif

    // Back Btn
    $('#backBtn').on('click',function(e){
        e.preventDefault();
        window.history.go(-1);
        return false;
    });

    // Datatable
    $.extend(true, $.fn.dataTable.defaults, {
        mark: true,
        processing: true,
        serverSide: true,
        responsive: true,
        columnDefs: [
            { 
                targets: 0 ,
                class : 'control'
            },
            {
                target: 'hidden',
                visible: false
            },
            {
                targets : 'no-sort',
                sortable : false
            },
            {
                targets:'no-search',
                searchable : false
            }
        ],
        language:{
            "paginate": {                        
                "previous": '<i class="far fa-arrow-alt-circle-left paginate-icon"></i>',
                "next":   '<i class="far fa-arrow-alt-circle-right paginate-icon"></i>'
            },
        }
    });
</script>
</body>

</html>