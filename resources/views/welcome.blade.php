@extends('layouts.app')

@section('header')
<header class="header header-inverse h-fullscreen pb-80" data-parallax="{{ asset('assets/img/bg-man.jpg ') }}" data-overlay="8">
    <div class="container text-center">

    <div class="row h-full">
        <div class="col-12 col-lg-8 offset-lg-2 align-self-center">

        <h1 class="display-4 hidden-sm-down">BAHDCASTS</h1>
        <h1 class="hidden-md-up">THE BEST WEB DEVELOPMENT SCREENCASTS ON THE INTERNET</h1>
        <br>
        <p class="lead text-white fs-20 hidden-sm-down"><span class="fw-400">Bahdcasts</span> is an awesome web development learning<br>subscription based SaaS  application powered with Vuejs and <span class="mark-border">Laravel 5.5   </span>.</p>

        <br><br><br>

        <a class="btn btn-lg btn-round w-200 btn-primary mr-16" href="#" data-scrollto="section-intro">Demos</a>
        <a class="btn btn-lg btn-round w-200 btn-outline btn-white hidden-sm-down" href="#" data-scrollto="section-intro">Features</a>

        </div>

        <div class="col-12 align-self-end text-center">
        <a class="scroll-down-1 scroll-down-inverse" href="#" data-scrollto="section-intro"><span></span></a>
        </div>

    </div>

    </div>
</header>
@stop

@section('content')

      <section class="section bg-gray">
        <div class="container">
          <header class="section-header">
            <small>lessons</small>
            <h2>Featured Screencasts</h2>
            <hr>
            <p class="lead"></p>
          </header>
          <div class="card mb-30">
            <div class="row">
              <div class="col-12 col-md-4 align-self-center">
                <a href="blog-single.html"><img src="assets/img/blog-1.jpg" alt="..."></a>
              </div>

              <div class="col-12 col-md-8">
                <div class="card-block">
                  <h4 class="card-title">New features will add to dashboard soon</h4>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content. Some quick example text to build on the card title.</p>
                  <a class="fw-600 fs-12" href="blog-single.html">Read more <i class="fa fa-chevron-right fs-9 pl-8"></i></a>
                </div>
              </div>
            </div>
          </div>

        </div>
      </section>
@stop