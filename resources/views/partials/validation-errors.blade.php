@if ($errors->any())
    <div class="alert alert-danger" >
        <ul dusk="validations-errors">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
