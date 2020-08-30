<div class="panel panel-default">
          @if (count($errors) > 0)
      <div class="alert alert-danger">
      <span class="caption-subject bold uppercase">Error de Sistema detectado!</span><br>
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      @if(Session::has('success'))
      <div class="alert alert-info">
        {{Session::get('success')}}
      </div>
      @endif
</div>
