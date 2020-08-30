@extends('home')
@section('content')

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="row">
        <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobil">
            <div class="kt-portlet kt-portlet--height-fluid kt-portlet--mobile ">
                <div
                    class="kt-portlet__head kt-portlet__head--lg kt-portlet__head--noborder kt-portlet__head--break-sm">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                        Subastas Actualmente en el sistema de Subasta Inversa
                        </h3>
                    </div>

                    <div class="kt-portlet__head-toolbar">
                        <div class="dropdown dropdown-inline">
                            <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="flaticon-more-1"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-md dropdown-menu-fit">
                                <ul class="kt-nav">

                                </ul>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="kt-portlet__body">
                    <!--begin: Datatable -->
                    <table class="table table-striped- table-bordered table-hover table-checkable"
                        id="dash-subastas-table">
                        <thead>
                            <tr>
                                <th> ID </th>
                                <th> Nombre de la Licitacion </th>
                                <th> Numero de la Licitacion</th>
                                <th> Estatus de la Subasta</th>
                                <th> Informacion</th>
                                <th> Ir a la subasta</th>
                            </tr>
                        </thead>
                    </table>
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
<script src="{{ URL::asset('js/subastaAdmin.js')}}" type="text/javascript"></script>
@endsection
@endsection
