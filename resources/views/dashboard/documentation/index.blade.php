@extends('layouts/contentNavbarLayout')

@section('title', __($documentation->name))

@section('vendor-script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.tiny.cloud/1/m9mp836lcgvlu4ugiq126ona90756fvoj6o0an0l3azy5u62/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
@endsection
@section('content')

<h4 class="fw-bold py-3 mb-3">
  <span class="text-muted fw-light">{{__('Documentation')}} / </span>{{__($documentation->name)}}
</h4>

<div class="card mb-4">
  {{-- <div class="card-header d-flex align-items-center justify-content-between">
    <h5 class="mb-0">Basic Layout</h5> <small class="text-muted float-end">Default label</small>
  </div> --}}
  <div class="card-body">

    <form class="form-horizontal" onsubmit="event.preventDefault()" action="#"
          enctype="multipart/form-data" id="form">

        <div class="row mb-3">
            <textarea id="documentation" name="{{Session::get('locale') == 'en' ? 'content_en' : 'content_ar'}}" class="form-control" rows="15" style="height: 375;" dir="rtl">{{Session::get('locale') == 'en' ? $documentation->content_en : $documentation->content_ar}}</textarea>
            <input type="text" id='name' name="name" value="{{$documentation->name}}" hidden/>
        </div>
    </form>

    <div class="col" style="text-align: center">
      <button id='submit' class="btn btn-primary">{{__('Submit')}}</button>
    </div>


  </div>
</div>

@endsection
@section('page-script')
<script>

  $(document).ready(function(){

    tinymce.init({
        selector: '#documentation',
        directionality: "rtl",
        menubar:''
      });


    $('#submit').on('click', function() {

      /* var formdata = new FormData();
      const parser = new DOMParser();
      var documentation = document.getElementById('documentation');
      var html = parser.parseFromString(documentation.innerHTML,'text/html')
      formdata.append('name',document.getElementById('name').value);
      formdata.append(documentation.getAttribute("name"),html.body.innerHTML); */

      //var formdata = new FormData($("#form")[0]);
      var formdata = new FormData();

      var key = document.getElementById('documentation').getAttribute("name");
      var value = tinymce.get("documentation").getContent();

      var name = document.getElementById('name').value;

      formdata.append('name',name);
      formdata.append(key,value);


      $.ajax({
        url: '{{ url('dashboard/documentation/update') }}',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        data:formdata,
        dataType : 'JSON',
        contentType: false,
        processData: false,
        success:function(response){
            if(response.status==1){
              Swal.fire(
                  "{{ __('Success') }}",
                  "{{ __('success') }}",
                  'success'
              ).then(function(){
                location.reload();
              });
            } else {
              console.log(response.message);
              Swal.fire(
                  "{{ __('Error') }}",
                  response.message,
                  'error'
              );
            }
        },
        error: function(data){
          var errors = data.responseJSON;
          console.log(errors);
          Swal.fire(
              "{{ __('Error') }}",
              errors.message,
              'error'
          );
          // Render the errors with js ...
        }


      });
    });
  });
</script>
@endsection
