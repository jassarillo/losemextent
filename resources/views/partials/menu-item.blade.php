
@if ($item['submenu'] == [])
<!-- carga_archivo('kt_content','{{url($item['ruta'])}}'); -->
                <li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true" id="menu_id_{{$item['id']}}">
                    <a href="{{ ($item['ajax']!='t')?url($item['ruta']):'javascript:void(0)' }}"class="kt-menu__link "
                     onclick ="{{ ($item['ajax']=='t')?'carga_archivo(\'kt_content\',\''.url($item['ruta']).'\')':''}}">
                        <i class="kt-menu__link-icon flaticon2-cube-1"></i>
                            <span class="kt-menu__link-text">{{ $item['menu'] }}</span>
                        <i class="kt-menu__ver-arrow la la-angle-right"></i>
                    </a>
                </li>
            @else
                <li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true">
                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle" >
                        <i class="kt-menu__link-icon flaticon2-cube-1"></i>
                        <span class="kt-menu__link-text">{{ $item['menu'] }}</span>
                        <i class="kt-menu__hor-arrow la la-angle-right"></i>
                        <i class="kt-menu__ver-arrow la la-angle-right"></i>
                    </a>
                @foreach ($item['submenu'] as $submenu)    
                    <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">                   
                    <ul class="kt-menu__subnav">                       
                        @if ($submenu['submenu'] == [])
                        <li class="kt-menu__item  kt-menu__item--submenu" data-ktmenu-submenu-toggle="hover" aria-haspopup="true">
                        <a href="{{ url($item['ruta']) }}"class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-cube-1"></i>
                        <span class="kt-menu__link-text">{{ $submenu['menu'] }}</span><i class="kt-menu__hor-arrow la la-angle-right"></i></a>
                </li>
                        @else
                        @include('partials.menu-item', [ 'item' => $submenu ])
                        @endif
                        </ul>
                        
                    
                </div>
                @endforeach
            </li>
            @endif