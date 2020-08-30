@extends('home')
@section('content')
<div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__head kt-portlet__head--lg">
        <div class="kt-portlet__head-label">
            <span class="kt-portlet__head-icon">
                <i class="kt-font-brand flaticon-user-add"></i>
            </span>
            <h3 class="kt-portlet__head-title">
               Control de Usuarios
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-wrapper">
                <div class="kt-portlet__head-actions">
                    <div class="dropdown dropdown-inline">
                        <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="la la-download"></i> Exportar
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="kt-nav dt_export">
                                <li class="kt-nav__section kt-nav__section--first">
                                    <span class="kt-nav__section-text">Selecciona...</span>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="javascript:void(0)" class="kt-nav__link"  data-value="0">
                                        <i class="kt-nav__link-icon la la-copy"></i>
                                        <span class="kt-nav__link-text">Copiar</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="javascript:void(0)" class="kt-nav__link"  data-value="1">
                                        <i class="kt-nav__link-icon la la-file-excel-o"></i>
                                        <span class="kt-nav__link-text">Excel</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="javascript:void(0)" class="kt-nav__link"  data-value="2">
                                        <i class="kt-nav__link-icon la la-file-text-o"></i>
                                        <span class="kt-nav__link-text">CSV</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="javascript:void(0)" class="kt-nav__link"  data-value="3">
                                        <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                                        <span class="kt-nav__link-text">PDF</span>
                                    </a>
                                </li>
                                <li class="kt-nav__item">
                                    <a href="javascript:void(0)" class="kt-nav__link" data-value="4">
                                        <i class="kt-nav__link-icon la la-print"></i>
                                        <span class="kt-nav__link-text">Imprimir</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    &nbsp;
                    <a href="javascript:void(0);" onclick="add_user_modal();" class="btn btn-cdmx btn-elevate btn-icon-sm">
                        <i class="la la-plus"></i>
                       Nuevo Usuario
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="kt-portlet__body">
        <!--begin: Datatable -->
        <table class="table table-striped- table-bordered table-hover table-checkable" id="users-table">
            <thead>
            <tr>
                <th> ID </th>
                <th> Nombre </th>
                <th> Apellido Paterno </th>
                <th> Apellido Materno </th>
                <th> Usuario </th>
                <th> Correo </th>
                <th> Acciones</th>
            </tr>
            </thead>


        </table>
        <!--end: Datatable -->
    </div>
</div>
@section('scripts')
<script src="{{ URL::asset('js/users.js')}}" type="text/javascript"></script>
@endsection
@endsection
