@section('title','Short Urls')
<x-header />

<x-dashboard-header />

<div class="container mt-4">
    @if (count($urls))
    <table class="table table-bordered text-center">
        <thead>
                <tr>
                    <th>Si. No</th>
                    <th>Original URL</th>
                    <th>Short Url</th>
                    <th>Created By</th>
                    <th>Company</th>
                    <th>Hits</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($urls as $key => $url)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $url->original_url }}</td>
                        <td><a href="{{ $url->original_url }}" target="_blank">{{ $url->shortened_url }}</a></td>
                        <td>{{ $url->user->name }}</td>
                        <td>{{ $url->company->name }}</td>
                        <td>{{ $url->hits }}</td>
                    </tr>    
                @endforeach
            </tbody>
    </table>
    {{-- @if ($urls->lastPage() > 1)
        <div class="d-flex justify-content-center mt-3">
            {{ $urls->links('pagination::bootstrap-5') }}
        </div>
    @endif --}}
    @else
        <p>No Urls Found</p>  
    @endif
</div>

<x-footer />