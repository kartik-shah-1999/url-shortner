@section('title','Invite Users')
<x-header />

<x-dashboard-header />

@php
    $user = auth()->user()->roles->toArray();
    $loggedInUserRole = $user[0]['pivot']['user_role'];
    $filter = null;
    switch($loggedInUserRole){
        case 1: $filter = 2;
        break;
        case 2: $filter = 3;
        break;
    }
    $step = 0;
@endphp

<div class="container mt-4">
@if (count($users) > 0)
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Si. No</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Invite to company</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $user)
                    <tr data-id="{{ $user->id }}">
                        <td>{{ ($key+1) }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @if (count($user->roles ))
                            {{ ucfirst($user->roles[0]->role)}}
                            @else
                                Not Defined
                            @endif
                        </td>
                        <td>
                            @if (count($companies))
                                <select name="company" class="form-control company-manager">
                                    <option value="">Select option</option>
                                    @foreach ($companies as $key => $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <p class="text-danger">No companies available to invite. <a href="{{ route('createCompany') }}">Create</a> a company now.</p>
                            @endif
                        </td>
                    </tr> 
                @endforeach
            </tbody>
        </table>
@else
    <p>No users found</p>
@endif
</div>

<x-footer />