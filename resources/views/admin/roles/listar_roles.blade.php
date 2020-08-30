@extends('home')
@section('content')
<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="kt-font-brand flaticon-user-add"></i>
            </span>
            <h3 class="kt-portlet__head-title">
               Control de Roles y Permisos asignados
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
                <div class="kt-portlet__head-actions">
                    &nbsp;
                    <a href="javascript:void(0);" onclick="add_new_rol();" class="btn btn-cdmx swal2-center">
                        <i class="la la-plus"></i>
                       Nuevo Rol
                    </a>

                </div>
            </div>
        </div>
    </div>

    <div class="kt-portlet__body">
        <!--begin: Datatable -->
        <table class="table table-bordered table-striped" id="table-roles-permisos">
            <thead>
                <tr>
                    <th>Nombre del Rol</th>
                    <th>Permiso</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ str_replace(array('[',']','"'),'', $role->permissions()->pluck('name')) }}</td>
                    <td>
                    <a href="{{ URL::to('admin/roles/'.$role->id.'/editar_roles_permisos') }}" class="btn btn-cdmx swal2-center"" style="margin-right: 3px;">Editar</a>
                    {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!--end: Datatable -->
    </div>
</div>

    @section('scripts')
        <script src="{{ URL::asset('js/roles.js')}}" type="text/javascript"></script>
    @endsection
@endsection
