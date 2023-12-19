@extends('layouts.app') 
@section('content')
<div class="container py-5 overflow-hidden">
    <div class="row align-items-center mb-4 p-4 border-bottom border-dark border-2">
        <div class="col-12 col-md-3 border-end border-dark">
            <h3>Manage Orders</h3>
        </div>
    </div>
    <ul
        class="nav nav-tabs nav-fill d-flex justify-content-evenly bg-body"
        id="myTab"
        role="tablist"
    >
        <li class="nav-item" role="presentation">
            <button
                class="nav-link active"
                id="home-tab"
                data-bs-toggle="tab"
                data-bs-target="#home-tab-pane"
                type="button"
                role="tab"
                aria-controls="home-tab-pane"
                aria-selected="true"
            >
                To Ship
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button
                class="nav-link"
                id="profile-tab"
                data-bs-toggle="tab"
                data-bs-target="#profile-tab-pane"
                type="button"
                role="tab"
                aria-controls="profile-tab-pane"
                aria-selected="false"
            >
                To Receive
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button
                class="nav-link"
                id="contact-tab"
                data-bs-toggle="tab"
                data-bs-target="#contact-tab-pane"
                type="button"
                role="tab"
                aria-controls="contact-tab-pane"
                aria-selected="false"
            >
                Completed
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button
                class="nav-link"
                id="cancelled-tab"
                data-bs-toggle="tab"
                data-bs-target="#cancelled-tab-pane"
                type="button"
                role="tab"
                aria-controls="cancelled-tab-pane"
                aria-selected="false"
            >
                Cancelled
            </button>
        </li>
    </ul>
    <br />
    <div class="tab-content bg-body" id="myTabContent">
        <div
            class="tab-pane fade show active"
            id="home-tab-pane"
            role="tabpanel"
            aria-labelledby="home-tab"
            tabindex="0"
        >
            <div class="container p-4">
                <h1 class="text-center">To ship</h1>
                <hr />
                <div id="order-list-toship">
                    <center>
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </center>
                </div>
            </div>
        </div>
        <div
            class="tab-pane fade"
            id="profile-tab-pane"
            role="tabpanel"
            aria-labelledby="profile-tab"
            tabindex="0"
        >
            <div class="container p-4">
                <h1 class="text-center">To receive</h1>
                <hr />
                <div id="order-list-toreceive"> 
                    <center>
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </center>
                </div>
            </div>
        </div>
        <div
            class="tab-pane fade"
            id="contact-tab-pane"
            role="tabpanel"
            aria-labelledby="contact-tab"
            tabindex="0"
        >
            <div class="container p-4">
                <h1 class="text-center">Completed</h1>
                <hr />
                <div id="order-list-completed">
                    <center>
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </center>
                </div>
            </div>
        </div>
        <div
            class="tab-pane fade"
            id="cancelled-tab-pane"
            role="tabpanel"
            aria-labelledby="cancelled-tab"
            tabindex="0"
        >
            <div class="container p-4">
                <h1 class="text-center">Cancelled</h1>
                <hr />
                <table class="table">
                    <thead>
                        <tr>
                            <th>ORDER ID</th>
                            <th>AMOUNT</th>
                            <th>DATE ORDERED</th>
                            <th>STATUS</th>
                            <th colspan="2">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $cancelled = $orders->where('status_id', 4); @endphp
                        @forelse($cancelled  as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>Php {{$item->amount}}</td>
                            <td>
                                {{\Carbon\Carbon::parse($item->created_at)->format('M d, Y g:ia')}}
                            </td>
                            <td>
                                @forelse($statuses as $status) 
                                    @if($status->id== $item->status_id)
                                        {{ $status->status_name }}
                                    @endif 
                                @empty 
                                @endforelse
                            </td>
                            <td>
                                <button class="btn btn-primary">
                                    View Order
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="mx-auto text-center p-4">
                                    <img
                                        src="{{
                                            asset('storage/images/cargo.png')
                                        }}"
                                        alt=""
                                    />
                                    <h3>No Orders Yet</h3>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#order-list-toship").on("click", ".cancel_order", function (e) {
            $(this).closest("tr").addClass("removeRow");
            e.preventDefault();
            swal({
                title: "Confirmation",
                text: "Do you want to cancel this order?",
                icon: "info",
                buttons: true,
            }).then((willSubmit) => {
                if (willSubmit) {
                    let order_id = $(this).data("id");
                    $.ajax({
                        url: "cancel_order/" + order_id,
                        type: "GET",
                        success: function (result) {
                            $(".removeRow").fadeOut(1000);
                            // getOrder();
                            console.log(result.message);
                            toastr.warning("Order Cancelled");
                            $(this).closest("tr").removeClass("removeRow");
                            getOrderCompleted();
                            getOrderToreceive();
                            getOrderToship();
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr, status, error);
                            alert("Error to cancel order");
                            $(this).closest("tr").removeClass("removeRow");
                        },
                    });
                } else {
                    $(this).closest("tr").removeClass("removeRow");
                }
            });
        });

        $("#order-list-toship").on("click", ".accept_order", function (e) {
            $(this).closest("tr").addClass("removeRow");
            e.preventDefault();
            swal({
                title: "Confirmation",
                text: "Do you want to accept this order?",
                icon: "info",
                buttons: true,
            }).then((willSubmit) => {
                if (willSubmit) {
                    let order_id = $(this).data("id");
                    $.ajax({
                        url: "accept_order/" + order_id,
                        type: "GET",
                        success: function (result) {
                            $(".removeRow").fadeOut(1000);
                            // getOrder();
                            console.log(result.message);
                            toastr.success("Order Accepted");
                            $(this).closest("tr").removeClass("removeRow");
                            getOrderCompleted();
                            getOrderToreceive();
                            getOrderToship();
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr, status, error);
                            alert("Error to accept order");
                            $(this).closest("tr").removeClass("removeRow");
                        },
                    });
                } else {
                    $(this).closest("tr").removeClass("removeRow");
                }
            });
        });

        $("#order-list-toreceive").on("click", ".delivered", function (e) {
            $(this).closest("tr").addClass("removeRow");
            e.preventDefault();
            swal({
                title: "Confirmation",
                text: "Confirm Delivery?",
                icon: "info",
                buttons: true,
            }).then((willSubmit) => {
                if (willSubmit) {
                    let order_id = $(this).data("id");
                    $.ajax({
                        url: "delivered/" + order_id,
                        type: "GET",
                        success: function (result) {
                            $(".removeRow").fadeOut(1000);
                            // getOrder();
                            console.log(result.message);
                            toastr.success("Order Delivered");
                            $(this).closest("tr").removeClass("removeRow");
                            getOrderCompleted();
                            getOrderToreceive();
                            getOrderToship();
                            
                        },
                        error: function (xhr, status, error) {
                            console.error(xhr, status, error);
                            alert("Error to delivered item");
                            $(this).closest("tr").removeClass("removeRow");
                        },
                    });
                } else {
                    $(this).closest("tr").removeClass("removeRow");
                }
            });
        });

        function getOrderToship() {
            $("#spinner").show();
            $.ajax({
                url: "{{ route('get.order-toship') }}",
                type: "GET",
                success: function (data) {
                    $("#order-list-toship").html(data);
                    $("#spinner").hide();
                },
                error: function () {
                    alert("Error fetching orders");
                    $("#spinner").hide();
                },
            });
        }
        function getOrderToreceive() {
            $("#spinner").show();
            $.ajax({
                url: "{{ route('get.order-toreceive') }}",
                type: "GET",
                success: function (data) {
                    $("#order-list-toreceive").html(data);
                    $("#spinner").hide();
                },
                error: function () {
                    alert("Error fetching orders");
                    $("#spinner").hide();
                },
            });
        }
        function getOrderCompleted() {
            $("#spinner").show();
            $.ajax({
                url: "{{ route('get.order-completed') }}",
                type: "GET",
                success: function (data) {
                    $("#order-list-completed").html(data);
                    $("#spinner").hide();
                },
                error: function () {
                    alert("Error fetching orders");
                    $("#spinner").hide();
                },
            });
        }
        getOrderCompleted();
        getOrderToreceive();
        getOrderToship();
    });
</script>
@endsection
