@if(Session::has('message'))
<div class="alert">
    <p>{{Session::get('message')}}</p>
</div>
@endif