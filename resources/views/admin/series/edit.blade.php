@extends('layouts.app')

@section('header')
<header class="header header-inverse" style="background-color: #c2b2cd;">
  <div class="container text-center">

    <div class="row">
      <div class="col-12 col-lg-8 offset-lg-2">

        <h1>Edit: {{  $series->title }}</h1>
        <p class="fs-20 opacity-70">Let's make the world a better place for coders</p>

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

          <form action="{{ route('series.update', $series->slug)  }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group">
              <input class="form-control form-control-lg" type="text" value="{{ $series->title }}" name="title" placeholder="Your Series title">
            </div>

            <div class="form-group">
              <input class="form-control form-control-lg" type="file" name="image">
            </div>

            <div class="form-group">
              <textarea class="form-control form-control-lg" name="description" rows="4" placeholder="Your Description">{{ $series->description }}</textarea>
            </div>


            <button class="btn btn-lg btn-primary btn-block" type="submit">Update series</button>
          </form>

        </div>
      </div>
    </div>
  </div>
@stop