@if (Session::has('success'))
    <div class="container">
        <div class="alert alert-success" role="alert">
            <p>{{ Session::get('success') }}</p>
        </div>
    </div>
@endif