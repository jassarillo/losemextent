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
                    <a href="javascript:void(0);" onclick="add_new_permiso();" class="btn btn-cdmx swal2-center">
                        <i class="la la-plus"></i>
                       Nuevo Permiso
                    </a>

                </div>
            </div>
        </div>
    </div>

    <div class="kt-portlet__body">
        <!--begin: Datatable -->
        <table class="table table-bordered table-striped" id="table-permisos">
            <thead>
                <tr>
                    <th>Nombre del permiso</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
            @foreach ($permisos as $permiso)
                <tr>
                    <td>{{ $permiso->name }}</td>
                    <td class="text-center" >
                        <a href="javascript:void(0);" onclick="edit_permiso({{ $permiso->id }});" class="btn btn-cdmx swal2-center"" style="margin-right: 3px;">Editar</a>
                    </td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
        <!--end: Datatable -->
    </div>
</div>

    @section('scripts')
    <script src="{{ URL::asset('js/permisos.js')}}" type="text/javascript"></script>
    @endsection
@endsection
