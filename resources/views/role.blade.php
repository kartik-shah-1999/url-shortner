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
@endphp

<div class="container mt-4">
@if (count($users) > 0)
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Si. No</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Manage Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $user)
                    <tr data-id="{{ $user->id }}">
                        <td>{{ $key+1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @if (count($user->roles ))
                            {{ ucfirst($user->roles[0]->role)}}
                            @else
                                Not Defined
                            @endif
                        </td>
                        <td>
                            <select name="role" class="form-control role-manager">
                                <option value="">Select option</option>
                                <option value="2" {{ optional($user->roles->first()?->pivot)->user_role == 2 ? 'disabled' : '' }} >Admin</option>
                                <option value="3" {{ optional($user->roles->first()?->pivot)->user_role == 3 ? 'disabled' : '' }} >Member</option>
                            </select>
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