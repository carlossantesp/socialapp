@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="cardborder-0 bg-light shadow-sm">
                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="card-img-top">
                <div class="card-body">
                    @if (auth()->id() === $user->id)
                        <h5 class="card-title">
                            {{ $user->name }} <small class="text-secondary">Eres tu</small>
                        </h5>
                    @else
                        <h5 class="card-title">
                            {{ $user->name }}
                        </h5>
                        <friendship-btn
                            dusk="request-friendship"
                            class="btn btn-primary btn-block"
                            :recipient="{{ $user }}"
                            friendship-status="{{ $friendshipStatus }}"
                        ></friendship-btn>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card border-0 bg-light shadow-sm">
                <div class="card-body">
                    <status-list
                        url = "{{ route('users.statuses.index', $user) }}"
                    ></status-list>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection