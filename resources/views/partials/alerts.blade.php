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

@if(isset($success))
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="alert alert-success" role="alert">
                    {{ $success}}
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

@if(isset($warning))
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="alert alert-warning" role="alert">
                    {{ $warning }}
                </div>
            </div>
        <div>
    </div>
@endif