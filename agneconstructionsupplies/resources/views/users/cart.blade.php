@extends('layouts.app') @section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <input
                type="checkbox"
                class="form-check-input"
                onclick="toggle(this)"
                id="toggle"
            />
            <label for="toggle">Toggle All</label>
        </div>
    </div>
    <form action="/checkout" method="post">
        @csrf
        <div class="row">
            <div class="col-12 col-md-9">
                <div id="cart-list">
                    <center>
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </center>
                </div>
            </div>
            <div class="col-12 col-md-3 checkout-column">
                <div class="card p-3 shadow-lg rounded d-flex flex-column">
                    <center>
                        <div class="fs-1">Checkout</div>
                        <hr />
                    </center>

                    <div class="mt-auto">
                        <h3 id="checkoutTotal">Total: Php 0.00</h3>
                    </div>

                    <input
                        type="submit"
                        value="CHECKOUT"
                        id="checkoutButton"
                        class="btn btn-danger bg-opacity-25"
                    />
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function updateCheckoutTotal() {
        var total = 0;
        var checked = false;
        $("[id^='cart_']").each(function () {
            if ($(this).is(":checked")) {
                var amount = parseFloat($(this).data("amount"));
                if (!isNaN(amount)) {
                    total += amount;
                    checked = true;
                }
            }
        });

        // Update the total in the checkout column
        $("#checkoutTotal").text("Total: Php " + total.toFixed(2));

        var checkoutButton = $("#checkoutButton");
        checkoutButton.prop("disabled", !checked);
    }

    function toggle(source) {
        checkboxes = document.getElementsByName("carts[]");
        var card = $("[id^='card_']");
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = source.checked;
        }
        updateCheckoutTotal();
        console.log("toggle");
    }

    function getCart() {
        $("#spinner").show();
        $.ajax({
            url: "{{ route('get.cart') }}",
            type: "GET",
            success: function (data) {
                $("#cart-list").html(data);
                $("#spinner").hide();
            },
            error: function () {
                alert("Error fetching cart");
                $("#spinner").hide();
            },
        });
    }

    function increaseQuan(id) {
        $.ajax({
            url: "increase_quan/" + id,
            type: "GET",
            success: function () {
                getCart();
            },
        });
    }
    function decreaseQuan(id) {
        $.ajax({
            url: "decrease_quan/" + id,
            type: "GET",
            success: function () {
                getCart();
            },
        });
    }

    $(document).ready(function () {
        $("[id^='cart_']").change(function () {
            updateCheckoutTotal();
        });
        getCart();
        updateCheckoutTotal(); // Initial call to calculate the total
    });
</script>

@endsection
