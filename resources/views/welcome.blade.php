@extends('layouts.app')

@section('content')
    {!! Breadcrumbs::render('home') !!}
    @include('layouts.snipets.error')
    @widget("recentBlogs")

@endsection
