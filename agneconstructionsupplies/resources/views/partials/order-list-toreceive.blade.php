<table class="table">
    <thead>
        <tr>
            <th>ORDER ID</th>
            <th>AMOUNT</th>
            <th>DATE ORDERED</th>
            <th>STATUS</th>
            <th>ACTION</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->amount}}</td>
            <td>{{\Carbon\Carbon::parse($item->created_at)->format('M d, Y g:ia')}}</td>
            <td>
                @forelse($statuses as $status) 
                @if($status->id == $item->status_id)
                    <div class="badge text-bg-primary">{{ $status->status_name }}</div>
                @endif 
            @empty 

            @endforelse
            </td>
            <td>
                <div class="row">
                    <div class="col">
                        <a
                            href="order_details/{{$item->id}}"
                            class="btn btn-primary"
                        >
                            View Order
                        </a>
                    </div>

                    @if(Auth::user()->user_type == 'user')
                    <div class="col">
                        <button
                            data-id="{{$item->id}}"
                            class="btn btn-outline-danger order_received"
                            @if($item->status_id != 5) disabled @endif 
                        > 
                            Order Received
                        </button>
                    </div>
                    @endif 

                    @if(Auth::user()->user_type == 'admin')
                    <div class="col">
                        <button
                            data-id="{{$item->id}}"
                            class="btn btn-danger delivered"
                            @if($item->status_id == 5) disabled @endif 
                        > 
                            
                            Delivered
                        </button>
                    </div>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">
                <div class="mx-auto text-center p-4">
                    <img src="{{ asset('storage/images/cargo.png') }}" alt="" />
                    <h3>No Orders Yet</h3>
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
