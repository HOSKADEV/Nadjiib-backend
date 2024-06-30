<div class="modal fade" id="editAdModal{{ $ad->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form class="form-horizontal" hx-post="{{ route('dashboard.ads.update', $ad->id) }}" hx-encoding='multipart/form-data'>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ trans('ad.update') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="id" name="id" class="form-control" value="{{ $ad->id }}">

                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <div hidden><img src="{{ asset('assets/img/icons/ad-not-found.jpg') }}" alt="image"
                                    class="d-block rounded" height="120" width="500" id="old-image" /> </div>
                            <img src="{{ empty($ad->image) ? asset('assets/img/icons/ad-not-found.jpg') : url($ad->image) }}" alt="image"
                                class="d-block rounded" height="120" width="500" id="uploaded-image" />
                        </div>
                        <div class="button-wrapper" style="text-align: center;">
                            <br>
                            <label for="image" class="btn btn-primary" tabindex="0">
                                <span class="d-none d-sm-block">{{ trans('app.addimage') }}</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input class="image-input" type="file" id="image" name="image" hidden
                                    accept="image/png, image/jpeg" />
                            </label>
                            <button type="button" class="btn btn-outline-secondary image-reset">
                                <i class="bx bx-reset d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">{{ trans('app.reset') }}</span>
                            </button>
                            <br>
                            {{-- <small class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</small> --}}
                        </div>
                    </div>
                    </br>
                    <div class="mb-3">
                        <label class="form-label" for="name">{{ trans('ad.name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $ad->name }}" />
                    </div>


                    <div class="mb-3">
                        <label class="form-label" for="name">{{ trans('ad.type') }}</label>
                        <input type="text" class="form-control" value="{{ trans('ad.'.$ad->type.'type') }}" disabled />
                        <input type="text" class="form-control" id="type" name="type" value="{{ $ad->type }}" hidden />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="name">{{ trans('ad.url') }}</label>
                        <input type="text" class="form-control" id="url" name="url" value="{{ $ad->url }}"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">{{ trans('app.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('ad.update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
