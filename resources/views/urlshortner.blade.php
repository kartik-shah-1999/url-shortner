@section('title','Url Shortner')
<x-header />

<x-dashboard-header />

@if (count($companies))
<div class="container mt-3">
    <form action="" method="post">
        @csrf
        <label for="urlshortner">Enter URL</label>
        <input type="url" id="urlshortner" class="form-control mb-2" name="url" placeholder="Enter URL to shorten" autocomplete="off">
        <label for="url-for-compnay">Select company for which you want to create URL</label>
        <select name="company" id="url-for-compnay" class="form-control mb-2">
            <option value="">Select company</option>
            @foreach ($companies as $company)
                <option value="{{ $company->userCompany->id }}">{{ $company->userCompany->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-md btn-primary w-100 generate-url">Generate URL</button>
    </form>

    <div class="generated-url mt-3">

    </div>
</div>
@else
<div class="container">
    <p>You haven't been invited to any company yet.</p>
</div>
@endif

<x-footer />