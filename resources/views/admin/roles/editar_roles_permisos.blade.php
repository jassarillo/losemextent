@extends('home')
@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="col-xl-5 order-lg-3 order-xl-1">
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile ">
                <div
                    class="kt-portlet__head kt-portlet__head--lg kt-portlet__head--noborder kt-portlet__head--break-sm">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            Permisos asignados al Rol -->{{$role->name}}
                        </h3>

                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <a href="javacript:;" onclick="history.go(-1); return false;" class="btn btn-clean btn-icon-sm">
                                    <i class="la la-long-arrow-left"></i>
                                    Atras
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="kt-portlet__body">
                    <!--begin: Datatable -->
                    {{ Form::model($role, array('route' => array('roles.update', $role->id), 'method' => 'PUT')) }}
                    {{ Form::label('name', 'Nombre del Rol Asignado') }}
                    {{ Form::text('name', null, array('class' => 'form-control','readonly' => true)) }}
                    <br>
                    <h5><b>Permisos Asignados</b></h5>
                    @foreach ($permissions as $permission)

        {{Form::checkbox('permissions[]',  $permission->id, $role->permissions ) }}
        {{Form::label($permission->name, ucfirst($permission->name)) }}<br>

    @endforeach
                    <br>
                    {{ Form::submit('Edit', array('class' => 'btn btn-primary')) }}

                    {{ Form::close() }}






                    <!--end: Datatable -->
                </div>
                <div class="kt-portlet__body kt-portlet__body--fit">
                    <div class="kt-datatable" id="kt_datatable_latest_orders"></div>
                </div>
            </div>

        </div>

    </div>
</div>
@section('scripts')
<script src="{{ URL::asset('js/users.js')}}" type="text/javascript"></script>
@endsection
@endsection
