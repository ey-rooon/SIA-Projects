<div class="container">
    <div class="row">
        <div class="col py-2">
            <p class="mb-0">
                <b>{{$address->firstname}} {{$address->lastname}}</b>
                |
                {{$address->contact}}
            </p>
        </div>
        <div class="col d-flex justify-content-end">
            <a href="#" data-bs-toggle="modal" data-bs-target="#addressModal"
                >change</a
            >
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p class="mb-0">{{$address->street}}</p>
            <p class="mb-0">
                {{$address->barangay}}, {{$address->town}},
                {{$address->postal_code}}
            </p>
            @if($address->isDefault == 1)
            <button disabled class="btn btn-outline-danger p-1">Default</button>
            @endif
        </div>
    </div>
</div>
