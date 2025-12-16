@auth
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
        <button class="btn btn-secondary logout">Logout</button>
    </div>
</div>

<div class="container mt-4">
    <div class="row g-4">
        <div class="col-12 col-md-4">
            <button class="btn btn-secondary w-100 py-4 fw-bold list-users">
                Users
            </button>
        </div>

        <div class="col-12 col-md-4">
            <button class="btn btn-success w-100 py-4 fw-bold company">
                Companies
            </button>
        </div>

        <div class="col-12 col-md-4">
            <button class="btn btn-warning w-100 py-4 fw-bold invite">
                Invite Members
            </button>
        </div>
    </div>
</div>
@endauth