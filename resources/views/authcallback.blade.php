@extends('layouts.extra')

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'callback'))
@stop

@section('body-class', 'body-error')

@section('content')
<script>
    $( document ).ready(function() {
      	calltop();
    }); 
	// solution 1
    function calltop(){
        window.opener.callback_top();
    }
    // solution 2
    window.onbeforeunload = function(){
        window.opener.callback_top();
    }
    document.cookie = "lagacy=auth,{{Auth::user()->name}},{{Auth::user()->email}}; expires=Thu, 18 Dec 2099 12:00:00 UTC; path=/";
    window.close();
</script>
@endsection 
