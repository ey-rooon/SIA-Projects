<div
            class="modal fade"
            id="editaddressModal{{$address->id}}"
            tabindex="-1"
            aria-labelledby="editaddressModalLabel{{$address->id}}"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1
                            class="modal-title fs-5"
                            id="editaddressModalLabel{{$address->id}}"
                        >
                            Edit Address
                        </h1>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <form action="/edit_address/{{$address->id}}" method="post">
                        @csrf
                        <!-- CSRF token -->
                        <div class="modal-body">
                            <!-- First Name -->
                            <div class="mb-3">
                                <label for="firstname" class="form-label"
                                    >First Name</label
                                >
                                <input
                                    type="text"
                                    class="form-control @error('firstname') is-invalid @enderror"
                                    id="firstname"
                                    name="firstname"
                                    placeholder="ex. Juan"
                                    value="{{$address->firstname}}"
                                />
                                @error('firstname')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div class="mb-3">
                                <label for="lastname" class="form-label"
                                    >Last Name</label
                                >
                                <input
                                    type="text"
                                    class="form-control @error('lastname') is-invalid @enderror"
                                    id="lastname"
                                    name="lastname"
                                    placeholder="ex. Dela Cruz"
                                    value="{{ $address->lastname }}"
                                />
                                @error('lastname')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Town -->
                            <div class="mb-3">
                                <label for="town" class="form-label"
                                    >Town</label
                                >
                                <input
                                    type="text"
                                    class="form-control @error('town') is-invalid @enderror"
                                    id="town"
                                    name="town"
                                    placeholder="San Manuel"
                                    value="{{ $address->town }}"
                                />
                                @error('town')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Barangay -->
                            <div class="mb-3">
                                <label for="barangay" class="form-label"
                                    >Barangay</label
                                >
                                <input
                                    type="text"
                                    class="form-control @error('barangay') is-invalid @enderror"
                                    id="barangay"
                                    name="barangay"
                                    placeholder="San Roque"
                                    value="{{ $address->barangay }}"
                                />
                                @error('barangay')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Postal Code -->
                            <div class="mb-3">
                                <label for="postal_code" class="form-label"
                                    >Postal Code</label
                                >
                                <input
                                    type="number"
                                    class="form-control @error('postal_code') is-invalid @enderror"
                                    id="postal_code"
                                    name="postal_code"
                                    placeholder="2438"
                                    value="{{ $address->postal_code }}"
                                />
                                @error('postal_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Street -->
                            <div class="mb-3">
                                <label for="street" class="form-label"
                                    >Street</label
                                >
                                <input
                                    type="text"
                                    class="form-control @error('street') is-invalid @enderror"
                                    id="street"
                                    name="street"
                                    placeholder="#64 Erasto C. Marquez Street"
                                    value="{{ $address->street }}"
                                />
                                @error('street')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Contact -->
                            <div class="mb-3">
                                <label for="contact" class="form-label"
                                    >Contact</label
                                >
                                <input
                                    type="tel"
                                    class="form-control @error('contact') is-invalid @enderror"
                                    id="contact"
                                    name="contact"
                                    placeholder="09957937970"
                                    value="{{ $address->contact }}"
                                />
                                @error('contact')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                            >
                                Close
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fa-regular fa-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>