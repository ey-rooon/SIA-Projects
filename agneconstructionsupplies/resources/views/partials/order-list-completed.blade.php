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
                        <div class="badge text-bg-success">{{ $status->status_name }}</div>
                    @endif 
                @empty 
                @endforelse
            </td>
            <td>
                <a href="order_details/{{$item->id}}" class="btn btn-primary">
                    View Order
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">
                <div class="mx-auto text-center p-4">
                    <img src="{{ asset('storage/images/cargo.png') }}" alt="" />
                    <h3>No Orders Yet</h3>
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
