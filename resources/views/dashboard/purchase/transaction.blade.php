<div class="modal fade" id="transactionModal{{ $purchase->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{{ trans('purchase.transaction') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row align-items-stretch">
                    <div class="col-xl">
                        <div class="card mb-4 h-100">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <div class="mb-3">
                                    <label class="form-label"
                                        for="android_version_number">{{ trans('purchase.price') }}</label>
                                    <input type="text" class="form-control" value="{{ $purchase->price }}"
                                        disabled />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"
                                        for="android_build_number">{{ trans('purchase.discount') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ $purchase->used_coupons()->sum('amount') }}" disabled />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"
                                        for="android_priority">{{ trans('purchase.total') }}</label>
                                    <input type="text" class="form-control" value="{{ $purchase->total }}"
                                        disabled />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"
                                        for="android_priority">{{ trans('purchase.payment_method') }}</label>
                                    <input type="text" class="form-control" value="{{ trans('purchase.'.$purchase->payment_method) }}"
                                        disabled />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"
                                        for="android_priority">{{ trans('purchase.account') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ $purchase->transaction?->account }}" disabled />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl">
                        <div class="card mb-4 h-100 d-flex justify-content-center align-items-center">
                            @php
                                $filePath = $purchase->receipt();
                                $fileExtension = $purchase->receipt_is();
                            @endphp

                            @if ($fileExtension === 'image')
                                <!-- Restrict the size of the image container and prevent scaling up -->
                                <div
                                    style="max-width: 400px; max-height: 500px; width: auto; height: auto; display: flex; justify-content: center; align-items: center;">
                                    <img src="{{ url($filePath) }}" alt="Receipt Image"
                                        style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                </div>
                            @elseif ($fileExtension === 'pdf')
                                <!-- Display PDF -->
                                <embed class="pdf" src="{{ url($filePath) }}" width="100%" height="100%">
                            @elseif($fileExtension)
                                <!-- Unsupported file type -->
                                <i class='bx bxs-file bx-lg' style="color: orange;"></i>
                                <p>
                                    {{trans('purchase.unsupported_file')}}
                                    <a href="{{ url($filePath) }}" target="_blank" style="text-decoration: underline;">
                                      {{trans('purchase.view_file')}}
                                    </a>
                                </p>
                            @else
                                <!-- No file exists -->
                                <i class='bx bxs-error bx-lg' style="color: red;"></i>
                                <p>{{trans('purchase.no_file')}}</p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>


            {{--  <div class="modal-footer">
              </div> --}}
        </div>
    </div>
</div>
