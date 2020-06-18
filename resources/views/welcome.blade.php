@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8 mx-auto">
            <div class="card border-0 bg-light">
                <form action="{{ route('statuses.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <textarea name="body" class="form-control border-0 bg-light" placeholder="¿Qué estás pensando Carlos?"></textarea>
                    </div>
                    <div class="card-footer">
                        <button id="create-status" class="btn btn-primary">Publicar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
@endsection
