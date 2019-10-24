@if(session('success'))
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="alert alert-success" role="alert">
                    {{ session('success')}}
                </div>
            </div>
        <div>
    </div>
@endif

@if(session('warning'))
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="alert alert-warning" role="alert">
                    {{ session('warning')}}
                </div>
            </div>
        <div>
    </div>
@endif