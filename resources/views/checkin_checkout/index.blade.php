<x-layout>
    <x-slot name="title">
        checkin_checkout
    </x-slot>
    <div class="container checkin_checkout">
        <div class="row justify-content-center align-items-center" style="height:75vh;">
            <div class="col-lg-8">
                <div class="card my-4">
                    <div class="card-body text-center">
                        <div class="qrcode-container">
                            <h6>QR Code</h6>
                            <img
                                src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(250)->generate($hash_value)) !!} ">
                            <p>Please scan QR to check in or checkout</p>
                        </div>
                        <hr>
                        <div class="pincode-container">
                            <h6>Pin Code</h6>
                            <input type="text" name="mycode" id="pincode" class="form-control" autofocus>
                            <p>Please enter your pin code to check in or checkout</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script>
            $('#pincode').pincodeInput({inputs:6,complete:function(value, e, errorElement){
                $.ajax({
                    url : `/pincode`,
                    type : 'POST',
                    data : {'value' : value},
                    success : function(res){
                        if(res.status == 'success'){
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                                Toast.fire({
                                    icon: 'success',
                                    title: res.message
                                })
                        }else if(res.status == 'fail'){
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                                Toast.fire({
                                    icon: 'error',
                                    title: res.message
                                })
                        }   
                        $('.pincode-container .pincode-input-text').val("");
                        $('.pincode-input-text').first().select().focus();
                    }
                })
        }});
        </script>
    </x-slot>
</x-layout>