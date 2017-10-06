@extends('layouts.app')

@section('header')
<header class="header header-inverse" style="background-color: #9ac29d">
  <div class="container text-center">

    <div class="row">
      <div class="col-12 col-lg-8 offset-lg-2">

        <h1>{{ $lesson->title }}</h1>
        <p class="fs-20 opacity-70">{{  $series->title }}</p>

      </div>
    </div>

  </div>
</header>
@stop

@section('content')
  <div class="section bg-grey">
    <div class="container">

      <div class="row gap-y">
        <div class="col-12">          
            
        </div>
      </div>
    </div>
  </div>
@stop