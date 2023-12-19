@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row py-5 mx-5">
        <div class="col-4">
            <div class="card border shadow">
                <h5 class="card-header bg-warning text-white m-3">Products</h5>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon bg-warning bg-opacity-50 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-boxes-packing "></i>
                        </div>
                        <div class="fs-3 ms-3">
                            {{$productCount}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-4">
            <div class="card border shadow">
                <h5 class="card-header bg-success text-white m-3">Revenue</h5>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon bg-success bg-opacity-50 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-peso-sign"></i>
                        </div>
                        <div class="fs-3 ms-3">
                            Php {{$revenue}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card border shadow">
                <h5 class="card-header bg-secondary text-white m-3">Orders Made</h5>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon bg-secondary bg-opacity-50 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-clipboard"></i>
                        </div>
                        <div class="fs-3 ms-3">
                            {{$orderCount}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row py-4 mx-5">
        <div class="col-4">
            <div class="card border shadow">
                <h5 class="card-header bg-danger text-white m-3">Out of stocks</h5>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon bg-danger bg-opacity-50 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div class="fs-3 ms-3">
                            {{$outOfStock}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card border shadow">
                <h5 class="card-header bg-info text-white m-3">Users</h5>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon bg-info bg-opacity-50 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-user-group"></i>
                        </div>
                        <div class="fs-3 ms-3">
                            {{$users}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card border shadow">
                <h5 class="card-header bg-primary text-white m-3">Categories</h5>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="card-icon bg-primary bg-opacity-50 rounded-circle d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-sliders"></i>
                        </div>
                        <div class="fs-3 ms-3">
                            {{$categories->count()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mx-auto bg-body">
        <div class="col-md-10 p-2">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>
@endsection
@section('chart')
<!-- Include Moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<!-- Include Chart.js after Moment.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script >
    var ctx = document.getElementById("myChart");

    var labels = @json($labels);
    var data = @json($data);
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Amount',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    function getData() {
        $.ajax({
        url: "{{ route('chart.get') }}",
        type: 'GET',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            myChart.data.labels = data.labels;
            myChart.data.datasets[0].data = data.data;
            myChart.update();
        },
        error: function(data){
            console.log(data);
        }
    });
    
  }
  $(document).ready(function(){
        getData();
    })
</script>
@endsection
