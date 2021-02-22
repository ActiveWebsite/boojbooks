@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

        <!--Section: Block Content-->
            <section>
                <library-list-component :user_id='@json($user_id)'></library-list-component>
            </section>
            <!--Section: Block Content-->
        </div>
    </div>
</div>
@endsection
