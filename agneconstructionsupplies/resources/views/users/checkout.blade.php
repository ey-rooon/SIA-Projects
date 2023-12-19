@extends('layouts.app') @section('content')
<div class="container p-4">
    <a href="/cart" class="back-button">
        <div class="back-button-box">
          <span class="back-button-elem">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 46 40">
              <path d="M46 20.038c0-.7-.3-1.5-.8-2.1l-16-17c-1.1-1-3.2-1.4-4.4-.3-1.2 1.1-1.2 3.3 0 4.4l11.3 11.9H3c-1.7 0-3 1.3-3 3s1.3 3 3 3h33.1l-11.3 11.9c-1 1-1.2 3.3 0 4.4 1.2 1.1 3.3.8 4.4-.3l16-17c.5-.5.8-1.1.8-1.9z"></path>
            </svg>
          </span>
          <span class="back-button-elem">
            <svg viewBox="0 0 46 40">
              <path d="M46 20.038c0-.7-.3-1.5-.8-2.1l-16-17c-1.1-1-3.2-1.4-4.4-.3-1.2 1.1-1.2 3.3 0 4.4l11.3 11.9H3c-1.7 0-3 1.3-3 3s1.3 3 3 3h33.1l-11.3 11.9c-1 1-1.2 3.3 0 4.4 1.2 1.1 3.3.8 4.4-.3l16-17c.5-.5.8-1.1.8-1.9z"></path>
            </svg>
          </span>
        </div>
    </a>
    <form action="/place_order" method="post">
        @csrf
        <table class="table">
            <tbody class="p-4">
                <tr>
                    <td colspan="2">
                        <div id="default_address">
                            <center>
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">
                                        Loading...
                                    </span>
                                </div>
                            </center>
                        </div>
                    </td>

                    <!-- Modal -->
                    <div
                        class="modal fade"
                        id="addressModal"
                        tabindex="-1"
                        aria-labelledby="addressModalLabel"
                        aria-hidden="true"
                    >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1
                                        class="modal-title fs-5"
                                        id="addressModalLabel"
                                    >
                                        My Addresses
                                    </h1>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    ></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col">
                                            <a
                                                href="/addresses"
                                                class="btn btn-danger"
                                                >Add Address</a
                                            >
                                        </div>
                                    </div>
                                    <div id="address-list"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </tr>
                <tr>
                    <th>Orders</th>
                    <th>Price</th>
                </tr>
                @foreach($items as $item)
                <tr>
                    <td>{{$item->product_name}} x {{$item->quantity}}</td>
                    <td>Php {{$item->amount}}</td>
                </tr>
                <input type="hidden" name="items[]" value="{{$item->cid}}" />
                @endforeach
                <tr>
                    <td></td>
                    <td>
                        <b>Total: {{ $amount }}</b>
                    </td>
                </tr>
                <input type="hidden" name="amount" value="{{ $amount }}" />
                <tr>
                    <td colspan="2">
                        <input
                            type="submit"
                            value="Place Order"
                            class="btn btn-primary"
                        />
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
<script>
    $(document).ready(function () {
        $("#spinner").show();
        $("#address-list").on("click", ".set-default", function (e) {
            let addr_id = $(this).data("id");
            e.preventDefault();
            $.ajax({
                url: "set_default/" + addr_id,
                type: "GET",
                success: function (result) {
                    $("#addressModal").modal("hide");
                    updateAddressList();
                    get_default_address();

                    console.log(result.message);
                    toastr.info("Address set to default");
                    $("#spinner").hide();
                },
                error: function (xhr, status, error) {
                    console.error(xhr, status, error);
                    alert("Error setting address as default");
                    $("#spinner").hide();
                },
            });
        });
        function get_default_address() {
            $("#spinner").show();
            $.ajax({
                url: "{{ route('get.default_address') }}",
                type: "GET",
                success: function (data) {
                    $("#default_address").html(data);
                    $("#spinner").hide();
                },
                error: function () {
                    alert("Error: You Haven't Added an Delivery Address. please Add one to process");
                    $("#spinner").hide();
                },
            });
        }

        function updateAddressList() {
            $("#spinner").show();
            $.ajax({
                url: "{{ route('get.address_list') }}",
                type: "GET",
                success: function (data) {
                    $("#address-list").html(data);
                    $("#spinner").hide();
                },
                error: function () {
                    alert("Error fetching updated address list");
                    $("#spinner").hide();
                },
            });
        }
        updateAddressList();
        get_default_address();
    });
</script>

@endsection
