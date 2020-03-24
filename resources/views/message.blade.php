@if($message = Session::get('error'))
<div class="position-fixed alert alert-danger" style="top: 20px; right: 20px; z-index: 99999">
  {{$message}}
</div>
@endif

@if($message = Session::get('success'))
<div class="position-fixed alert alert-success" style="top: 20px; right: 20px; z-index: 99999;">
  {{$message}}
</div>
@endif