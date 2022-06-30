@if ($errors->all())
<div class="row mt-8">
    <div class="col-12">
        <div class="alert alert-danger" role="alert">
            <div class="alert-text">
                <h4 class="alert-heading">There are several fields that failed the validation</h4>
                <hr>
                @foreach ($errors->all() as $error)
                    <p class="mb-0">{{ $error }}</p>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif