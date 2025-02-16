@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
        <button class="btn-close"></button>
    </div>
@endif