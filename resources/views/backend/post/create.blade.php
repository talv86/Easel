@extends('easel::backend.layout')

@section('title')
    <title>{{ config('easel.title') }} | New Post</title>
@stop

@section('content')
    <section id="main">

        @include('easel::backend.partials.sidebar-navigation')

        <section id="content">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <ol class="breadcrumb">
                            <li><a href="{{ url('/admin') }}">Home</a></li>
                            <li><a href="{{ url('/admin/post') }}">Posts</a></li>
                            <li class="active">New Post</li>
                        </ol>

                        @include('easel::shared.errors')

                        @include('easel::shared.success')

                        <h2>Create a New Post</h2>
                    </div>
                    <div class="card-body card-padding">
                        <form class="keyboard-save" role="form" method="POST" id="frmPost" action="/admin/post/">
                            <input type="hidden" name="user_id" value="{!! auth()->user()->id !!}">
                            @include('easel::backend.post.partials.form')

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-icon-text"><i class="zmdi zmdi-floppy"></i> Save</button>
                                &nbsp;
                                <a href="{{ url('/admin/post') }}">
                                    <button type="button" class="btn btn-link">Cancel</button>
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
@stop

@section('unique-js')
    @include('easel::backend.post.partials.editor')

    {!! JsValidator::formRequest('Easel\Http\Requests\PostCreateRequest', '#frmPost') !!}

    @include('easel::backend.shared.notifications.protip')

@stop
