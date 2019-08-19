
  <li class="dropdown messages-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
          <i class="fa fa-envelope-o"></i>
          <span class="label label-success">{{$threads->count()}}</span>
        </a>
        <ul class="dropdown-menu">
          <li class="header">Tienes {{$threads->count()}} Mensaje(s)</li>
          <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
                    @if($threads->count()>0)
                    @foreach($threads as $thread)
              <li><!-- start message -->
                <a href="{{ route('messages.show', $thread->id) }}">
                  <div class="pull-left">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image">
                  </div>
                  <h4>
                        {{ $thread->creator()->name }}
                    <small><i class="fa fa-clock-o"></i> {{ $thread->created_at->diffForHumans() }}</small>
                  </h4>
                  <p>{{ $thread->subject }}</p>
                </a>
              </li>
              @endforeach
              @else
              <li class="header">No tienes Mensajes</li>
              @endif
              <!-- end message -->
            </ul>
          </li>
          <li class="footer"><a href="{{ route('messages.index') }}">Ver Todos</a></li>
        </ul>
      </li>
  <li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
      <img src="{{ Gravatar::get($user->email) }}" class="user-image" alt="User Image">
      <span class="hidden-xs">{{ utf8_encode($user->name)}}</span>
    </a>
    <ul class="dropdown-menu">
      <!-- User image -->
      <li class="user-header">
        <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image">
        <p>
            {{$user->name}} <br>
          <small>SAT: {{ utf8_encode($user->sat_ruc?$user->getSat->NucNomSat:"") }}</small>
        </p>
      </li>
      <!-- Menu Body -->

      <!-- Menu Footer-->
      <li class="user-footer">
        <!--<div class="pull-left">
          <a href="#" class="btn btn-default btn-flat">Perfil</a>
        </div>-->
        <div class="pull-right">

          <a href="#" class="btn btn-default btn-flat"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
        >
            <i class="fa fa-fw fa-power-off"></i> Salir
        </a>
        <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
            @if(config('adminlte.logout_method'))
                {{ method_field(config('adminlte.logout_method')) }}
            @endif
            {{ csrf_field() }}
        </form>
        </div>
      </li>
    </ul>
  </li>
