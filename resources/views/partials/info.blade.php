@if(Session::has('info'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    {{ Session::get('info') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif