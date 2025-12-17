@section('title','Companies')
<x-header />

<x-dashboard-header />

<div class="container mt-3">
    @if (session('error'))
        <div class="alert alert-danger text-danger w-100">{{ session('error') }}</div>
    @elseif (session('success'))
        <div class="alert alert-success text-success w-100">{{ session('success') }}</div>
    @endif
    <form action="" method="post">
        @csrf
        <label for="">Company Name</label>
        <input type="text" placeholder="Enter company name" name="name" class="form-control">
        <button type="submit" class="btn btn-sm w-100 btn-info mt-2">Create company</button>
    </form>
</div>

<div class="container mt-4">
@if (count($companies) > 0)
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Si. No</th>
                    <th>Company Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companies as $key => $company)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $company->name }}</td>
                </tr>    
                @endforeach
            </tbody>
        </table>
@else
    <p>No companies found</p>
@endif
</div>
<x-footer />