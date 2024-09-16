@extends('layouts.mainlayout')

@section('title', 'Add Category')

@section('content')
    <h2>Are You Sure Delete Category {{$category->name}} ?</h2>
    <div class="mt-5">
        <a href="/category-destroy/{{$category->slug}}" class="btn btn-danger me-5">Sure</a>
        <a href="/categories" class="btn btn-primary">Cancel</a>
    </div>
@endsection
