@extends('layouts.logout')   

@section('meta-tags')
    @include('partials.meta-tags', array('page' => 'logout'))
@stop

@section('body-class', 'body-error')

@section('content')
<form id="logout-form"  name="member_logout" action="{{ route('logout') }}" method="POST" >
{{ csrf_field() }}
</form>
<script type="text/javascript">
window.onload = function(){
  document.forms['member_logout'].submit();
}
document.cookie = "lagacy=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
</script>
<script>
//  window.intercomSettings = {
//    app_id: "q66oai88"
//  };
</script>
{{--<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/APP_ID';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>--}}
@endsection 
