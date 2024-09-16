@extends('layouts.mainlayout')

@section('title', 'Dashboard')

@section('content')

<h1>welcome, {{Auth::user()->username}}</h1>

   <div class="row my-5">
      <div class="col-lg-4">
         <div class="card-data books">
            <div class="row">
               <div class="col-6"><i class="bi bi-journal-bookmark"></i></div>
               <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                  <div class="card-desc">Books</div>
                  <div class="card-count">{{$book_count}}</div>
               </div>
            </div>
         </div>
      </div>

      <div class="col-lg-4">
         <div class="card-data categories">
            <div class="row">
               <div class="col-6"><i class="bi bi-bookmarks"></i></div>
               <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                  <div class="card-desc">Categories</div>
                  <div class="card-count">{{$category_count}}</div>
               </div>
            </div>
         </div>
      </div>

      <div class="col-lg-4">
         <div class="card-data users">
            <div class="row">
               <div class="col-6"><i class="bi bi-person-check-fill"></i></div>
               <div class="col-6 d-flex flex-column justify-content-center align-items-end">
                  <div class="card-desc">Users</div>
                  <div class="card-count">{{$user_count}}</div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="mt-5">
      <h2>Rent Log</h2>
      <x-rent-log-table :rentlog='$rent_logs' />
   </div>

@endsection