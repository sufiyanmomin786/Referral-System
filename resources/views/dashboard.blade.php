@extends('layouts/dashboardLayout')

@section('content-section')
    <h2 class="mb-4" style="float:left;">Dashboard</h2>
    <h2 class="mb-4" style="float:right;">{{ $networkCount * 10 }} Points</h2>
    <table class="table">
        <thead>
            <th>S.No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Verified</th>
        </thead>
        <tbody>
            @if (count($networkData) > 0)
                @php $x=0;@endphp
                @foreach ($networkData as $network)
                    <tr>
                        <td>{{ $x++ }}</td>
                        <td>{{ $network->user->name }}</td>
                        <td>{{ $network->user->email }}</td>
                        <td>
                            @if ($network->user->is_verified == 0)
                                <b style="color:red";>UnVerified</b>
                            @else
                                <b style="color:green";>Verified</b>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <th colspan="4">No Referrals <i class="fa fa-soundcloud!!!" aria-hidden="true"></i></th>
                </tr>
            @endif
        </tbody>
    </table>
@endsection
