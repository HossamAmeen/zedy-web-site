@extends('back-end.layout.app')
@php $pageTitle = "إضافه مسؤول " @endphp  
@section('title')
    {{ $pageTitle }}
@endsection

@section('content')

    @component('back-end.layout.header')
        @slot('nav_title')
            {{ $pageTitle }}
        @endslot
    @endcomponent

        @component('back-end.shared.create')
            <form id="defaultForm" method="post" class="form-horizontal ls_form" action="{{ route($routeName.'.store') }}"
                    data-bv-message="This value is not valid"
                    data-bv-feedbackicons-valid="fa fa-check"
                    data-bv-feedbackicons-invalid="fa fa-bug"
                    data-bv-feedbackicons-validating="fa fa-refresh"
                    enctype="multipart/form-data"
                    > 
                @csrf
            
@php $input = "image"; @endphp          
<div class="form-group">
        <label class="col-md-2 control-label">الصورة</label>
        <div class="col-md-10 ls-group-input">
            <input name="{{ $input }}" id="file-3" type="file"  >
        </div>
        @error($input)
        <span class="invalid-feedback" role="alert">
            <strong style="margin-right: 25%;color:red">{{ $message }}</strong>
        </span>
        @enderror
</div>  


           
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button class="btn btn-info" type="submit">  إضافه  </button>
                    </div>
                </div>
             </form>
        @endcomponent                    
@endsection
@push('css')
      <!-- Responsive Style For-->
  <link href="{{asset('panel/assets/css/rtl-css/responsive-rtl.css')}}" rel="stylesheet">
  <!-- Responsive Style For-->
  <link rel="stylesheet" href="{{asset('panel/assets/css/rtl-css/plugins/summernote-rtl.css')}}">
  <!-- Custom styles for this template -->


    <!-- Plugin Css Put Here -->
  
    <link rel="stylesheet" href="{{asset('panel/assets/css/rtl-css/plugins/fileinput-rtl.css')}}">
@endpush
@push('js')
     <!--Upload button Script Start-->
   <script src="{{asset('panel/assets/js/fileinput.min.js')}}"></script>
   <!--Upload button Script End-->

<!--Auto resize  text area Script Start-->
<script src="{{asset('panel/assets/js/jquery.autosize.js')}}"></script>
 <!--Auto resize  text area Script Start-->
<script src="{{asset('panel/assets/js/pages/sampleForm.js')}}"></script>


<!-- summernote Editor Script For Layout start-->
<script src="{{asset('panel/assets/js/summernote.min.js')}}"></script>
<!-- summernote Editor Script For Layout End-->

<!-- Demo Ck Editor Script For Layout Start-->
<script src="{{asset('panel/assets/js/pages/editor.js')}}"></script>
<!-- Demo Ck Editor Script For Layout ENd-->
@endpush