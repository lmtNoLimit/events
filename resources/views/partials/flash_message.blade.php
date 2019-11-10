@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    {{ $message }}
</div>
@endif