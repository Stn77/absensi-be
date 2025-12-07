@hasanyrole($role)
<li class="menu-item">
    <a href="{{route($link)}}" class="menu-link {{Route::is($link) ? 'active' : ''}}">
        <span class="menu-icon"><i class="fas fa-{{$icon}}"></i></span>
        <span class="menu-text">{{$name}}</span>
    </a>
</li>
@endhasanyrole
