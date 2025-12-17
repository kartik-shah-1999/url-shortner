@auth
@php
    $loggedInUserRole = auth()->user()->roles[0]->pivot->user_role;
@endphp
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
    <div class="d-flex justify-content-end">
        <button class="btn btn-primary mr-2 dashboard">Dashboard</button>
        <button class="btn btn-secondary logout">Logout</button>
    </div>
</div>

<div class="container mt-4">
    <div class="row g-4">
        <div class="col-12 col-md-3">
            <button class="btn btn-secondary w-100 py-4 fw-bold urls">
                Urls
            </button>
        </div>

        @if ($loggedInUserRole === \App\RoleEnum::SUPERADMIN)
            <div class="col-12 col-md-3">
                <button class="btn btn-success w-100 py-4 fw-bold company">
                    Companies
                </button>
             </div>

            <div class="col-12 col-md-3">
                <button class="btn btn-warning w-100 py-4 fw-bold role">
                    Role Manager
                </button>
            </div>
        @endif

        @if ($loggedInUserRole !== App\RoleEnum::MEMBER)
            <div class="col-12 col-md-3">
                <button class="btn btn-success w-100 py-4 fw-bold invite">
                    Invite Members
                </button>
            </div>
        @endif
    </div>
</div>
@endauth