@extends('layouts.app')

@section('header')
<header class="header header-inverse" style="background-color: #1ac28d">
  <div class="container text-center">

    <div class="row">
      <div class="col-12 col-lg-8 offset-lg-2">

        <h1>What do you wanna learn next ? !</h1>
      </div>
    </div>

  </div>
</header>
@stop

@section('content')
<section class="section" id="section-vtab">
    <div class="container">
        <header class="section-header">
        <h2>Here's all the fun stuff !</h2>
        </header>


        <div class="row gap-5">
            @forelse($series as $s)
                <div class="card mb-30">
                <div class="row">
                    <div class="col-12 col-md-4 align-self-center">
                    <a href=""><img src="{{ $s->image_path }}" alt="..."></a>
                    </div>

                    <div class="col-12 col-md-8">
                    <div class="card-block">
                        <h4 class="card-title">{{ $s->title }}</h4>
                    
                        <p class="card-text">{{ $s->description }}</p>
                        <a class="fw-600 fs-12" href="{{ route('series', $s->slug) }}">Read more <i class="fa fa-chevron-right fs-9 pl-8"></i></a>
                    </div>
                    </div>
                </div>
                </div>
            @empty
            @endforelse
        </div>


    </div>
</section>    
<section class="section bg-gray" id="section-vtab">
    <div class="container">
    </div>
</section>    

@endsection
