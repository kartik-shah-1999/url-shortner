@section('title','Dashboard')
<x-header />

<header class="bg-primary text-white py-4 shadow-sm">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h2 class="mb-1">Welcome, {{ auth()->user()->name }}</h1>
            </div>
        </div>
    </div>
</header>

 <div class="container mt-2">
    <div class="row">
        <button class="btn btn-secondary logout">Logout</button>
    </div>
</div>

No URLs Created

<x-footer />