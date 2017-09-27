@extends('layouts.app')

@section('header')
<header class="header header-inverse" style="background-color: #c2b2cd;">
  <div class="container text-center">

    <div class="row">
      <div class="col-12 col-lg-8 offset-lg-2">

        <h1>Create a bahd series</h1>
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

          <form action="{{ route('series.store')  }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
              <input class="form-control form-control-lg" type="text" name="title" placeholder="Your Series title">
            </div>

            <div class="form-group">
              <input class="form-control form-control-lg" type="file" name="image">
            </div>

            <div class="form-group">
              <textarea class="form-control form-control-lg" name="description" rows="4" placeholder="Your Description"></textarea>
            </div>


            <button class="btn btn-lg btn-primary btn-block" type="submit">Create series</button>
          </form>

        </div>
      </div>
    </div>
  </div>
@stop