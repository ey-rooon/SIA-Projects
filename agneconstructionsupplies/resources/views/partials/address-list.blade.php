@forelse($addresses AS $address)
<div class="row">
    <div class="col py-2">
        <p class="mb-0">
            <b>{{$address->firstname}} {{$address->lastname}}</b>
            |
            {{$address->contact}}
        </p>
    </div>
    <div class="col d-flex justify-content-end">
        <a
            href="#"
            data-bs-dismiss="modal"
            data-bs-toggle="modal"
            data-bs-target="#editaddressModal{{$address->id}}"
            >edit</a
        >
    </div>
</div>
<div class="row">
    <div class="col">
        <p class="mb-0">
            {{$address->street}}
        </p>
        <p class="mb-0">
            {{$address->barangay}}, {{$address->town}},
            {{$address->postal_code}}
        </p>
        @if($address->isDefault == 1)
        <button disabled class="btn btn-outline-danger">Default</button>
        @else
        <button
            class="btn btn-outline-secondary set-default"
            data-id="{{$address->id}}"
        >
            Set as default
        </button>

        @endif
    </div>
</div>
<hr />
@include('components.edit-address-modal') @empty
<center>
    <h2>No address yet, you must add atleast 1 address</h2>
</center>
@endforelse
