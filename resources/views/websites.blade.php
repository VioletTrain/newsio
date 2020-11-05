@extends('header')

@section('content')
    <div class="row websites">
        <div class="col-md-3">
            Apply website
            <form method="POST" action="{{ url('website') }}">
                @csrf
                <input aria-label="domain" id="domain" name="domain">
                <input type="submit" value="Submit" id="submit_domain_button">
            </form>
        </div>
        <div class="col-md-9">
            <div class="header-links">
                <a href="{{ url('/websites/pending') }}" @if(strpos(url()->current(), 'pending'))class="active"@endif>
                    Pending ({{ $total['pending'] }})
                </a>
                <a href="{{ url('/websites/approved') }}" @if(strpos(url()->current(), 'approved'))class="active"@endif>
                    Approved ({{ $total['approved'] }})
                </a>
                <a href="{{ url('/websites/rejected') }}" @if(strpos(url()->current(), 'rejected'))class="active"@endif>
                    Rejected ({{ $total['rejected'] }})
                </a>
            </div>
            <div class="col-md-10">
                @foreach ($websites as $website)
                    <span class="website">
                        <a href="{{ $website->domain }}">
                            {{ $website->domain }}
                        </a>
                        @if ($website->approved === false)
                            - {{ $website->reason }}
                        @endif
                    </span>
                @endforeach
                {{ $websites->links() }}
            </div>
        </div>
    </div>
    <script src="{{ asset('js/website.js') }}" type="module"></script>
@endsection