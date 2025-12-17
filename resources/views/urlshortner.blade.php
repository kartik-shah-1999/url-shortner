@section('title','Url Shortner')
<x-header />

<x-dashboard-header />

<div class="container mt-3">
    <form action="" method="post">
        @csrf
        <label for="urlshortner">Enter URL</label>
        <input type="url" id="urlshortner" class="form-control mb-2" name="url" placeholder="Enter URL to shorten" autocomplete="off">
        <button type="submit" class="btn btn-md btn-primary w-100 generate-url">Generate URL</button>
    </form>

    <div class="generated-url mt-3">

    </div>
</div>

<x-footer />