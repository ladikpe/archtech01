@extends('layouts.master')
@section('stylesheets')
  

@endsection
@section('content')
<div class="page vertical-align text-xs-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle">
      <header>
        <h1 class="animation-slide-top">500</h1>
        <p>Page Not Found !</p>
      </header>
      <p class="error-advise">YOU SEEM TO BE TRYING TO FIND YOUR WAY HOME</p>
      <a class="btn btn-primary btn-round" href="{{url('home')}}">GO TO HOME PAGE</a>
      
    </div>
  </div>
@endsection
@section('scripts')


  </script>
@endsection