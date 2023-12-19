@extends('layouts.app') @section('content')
<div class="container bg-white">
    <div class="row p-3">
        <div class="col">
            <h3>My Addresses</h3>
        </div>
        <div class="col d-flex justify-content-end">
            <button
                type="button"
                class="btn btn-danger"
                data-bs-toggle="modal"
                data-bs-target="#addressModal"
            >
                <i class="fa-regular fa-plus"></i> Add Address
            </button>
        </div>
        @include('components.add-address-modal')
    </div>
    <hr />
    <div class="container">
        <div id="address-list"></div>
    </div>
</div>
<script>
    $(document).ready(function(){
        @if ($errors -> any())
            $('#addressModal').modal('show');
        @endif

        $("#address-list").on("click", ".set-default", function (e){
            let addr_id = $(this).data("id");
            e.preventDefault();
            $.ajax({
                url: "set_default/" + addr_id,
                type: "GET",
                success: function (result) {
                    $("#addressModal").modal("hide");
                    updateAddressList();


                    console.log(result.message);
                    toastr.info("Address set to default");
                },
                error: function (xhr, status, error) {
                    console.error(xhr, status, error);
                    alert("Error setting address as default");

                },
            });
        });

        function updateAddressList() {
            $.ajax({
                url: "{{ route('get.address_list') }}",
                type: "GET",
                success: function (data) {
                    $("#address-list").html(data);
                },
                error: function () {
                    alert("Error fetching updated address list");
                },
            });
        }
        updateAddressList();
    });
</script>
@endsection
