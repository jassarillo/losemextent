@extends('home')
@section('content')

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__head kt-portlet__head--lg">
            <div class="kt-portlet__head-label">
                <span class="kt-portlet__head-icon">
                    <i class="kt-font-success flaticon-graphic-2"></i>
                </span>
                <h3 class="kt-portlet__head-title">

                    Subasta de la Licitacion
                        @foreach ($subasta as $sub)
                        <label class="control-label kt-font-cdmx"> {{ $sub->nombre }}</label>
                        <input type="hidden" id="id_lic" name="id_lic" value=" {{ $sub->id }}">
                        @endforeach

                </h3>
            </div>

        </div>

        <div class="kt-portlet__body ">
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-4">

                    <div class="kt-portlet kt-iconbox kt-iconbox--success  kt-iconbox--animate-fast">

                        <div class="kt-portlet__body">
                            <div class="kt-iconbox__body">
                                <div class="kt-iconbox__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                        class="kt-svg-icon">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect id="bound" x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M10.9630156,7.5 L11.0475062,7.5 C11.3043819,7.5 11.5194647,7.69464724 11.5450248,7.95024814 L12,12.5 L15.2480695,14.3560397 C15.403857,14.4450611 15.5,14.6107328 15.5,14.7901613 L15.5,15 C15.5,15.2109164 15.3290185,15.3818979 15.1181021,15.3818979 C15.0841582,15.3818979 15.0503659,15.3773725 15.0176181,15.3684413 L10.3986612,14.1087258 C10.1672824,14.0456225 10.0132986,13.8271186 10.0316926,13.5879956 L10.4644883,7.96165175 C10.4845267,7.70115317 10.7017474,7.5 10.9630156,7.5 Z"
                                                id="Path-107" fill="#000000" />
                                            <path
                                                d="M7.38979581,2.8349582 C8.65216735,2.29743306 10.0413491,2 11.5,2 C17.2989899,2 22,6.70101013 22,12.5 C22,18.2989899 17.2989899,23 11.5,23 C5.70101013,23 1,18.2989899 1,12.5 C1,11.5151324 1.13559454,10.5619345 1.38913364,9.65805651 L3.31481075,10.1982117 C3.10672013,10.940064 3,11.7119264 3,12.5 C3,17.1944204 6.80557963,21 11.5,21 C16.1944204,21 20,17.1944204 20,12.5 C20,7.80557963 16.1944204,4 11.5,4 C10.54876,4 9.62236069,4.15592757 8.74872191,4.45446326 L9.93948308,5.87355717 C10.0088058,5.95617272 10.0495583,6.05898805 10.05566,6.16666224 C10.0712834,6.4423623 9.86044965,6.67852665 9.5847496,6.69415008 L4.71777931,6.96995273 C4.66931162,6.97269931 4.62070229,6.96837279 4.57348157,6.95710938 C4.30487471,6.89303938 4.13906482,6.62335149 4.20313482,6.35474463 L5.33163823,1.62361064 C5.35654118,1.51920756 5.41437908,1.4255891 5.49660017,1.35659741 C5.7081375,1.17909652 6.0235153,1.2066885 6.2010162,1.41822583 L7.38979581,2.8349582 Z"
                                                id="Combined-Shape" fill="#000000" opacity="0.3" />
                                        </g>
                                    </svg>
                                </div>
                                <div class="kt-iconbox__desc">
                                    <h3 class="kt-iconbox__title">
                                        <a class="kt-link" href="javascript:void(0)">Actualizar</a>
                                    </h3>
                                    <div class="kt-iconbox__content">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-6 col-md-4">
                    <div class="kt-portlet kt-iconbox {{$div}} kt-iconbox--animate-slower">
                        <div class="kt-portlet__body">
                            <div class="kt-iconbox__body">
                                <div class="kt-iconbox__icon" style="margin-right:20px">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                        class="kt-svg-icon">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect id="bound" x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z"
                                                id="Path-95" fill="#000000" fill-rule="nonzero" />
                                            <path
                                                d="M8.7295372,14.6839411 C8.35180695,15.0868534 7.71897114,15.1072675 7.31605887,14.7295372 C6.9131466,14.3518069 6.89273254,13.7189711 7.2704628,13.3160589 L11.0204628,9.31605887 C11.3857725,8.92639521 11.9928179,8.89260288 12.3991193,9.23931335 L15.358855,11.7649545 L19.2151172,6.88035571 C19.5573373,6.44687693 20.1861655,6.37289714 20.6196443,6.71511723 C21.0531231,7.05733733 21.1271029,7.68616551 20.7848828,8.11964429 L16.2848828,13.8196443 C15.9333973,14.2648593 15.2823707,14.3288915 14.8508807,13.9606866 L11.8268294,11.3801628 L8.7295372,14.6839411 Z"
                                                id="Path-97" fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                transform="translate(14.000019, 10.749981) scale(1, -1) translate(-14.000019, -10.749981) " />
                                        </g>
                                    </svg>
                                </div>
                                <div class="kt-iconbox__desc">
                                    <h3 class="kt-iconbox__title">
                                        <a class="kt-link"  onclick="estatus({{$ronda}});"href="javascript:void(0)">Estatus de Captura</a>
                                    </h3>
                                    <div class="kt-iconbox__content">
                                    Ronda  {{$ronda1}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-4">
                    <div class="kt-portlet kt-iconbox kt-iconbox--warning kt-iconbox--animate-slower">
                        <div class="kt-portlet__body">
                            <div class="kt-iconbox__body">
                                <div class="kt-iconbox__icon" style="margin-right:20px">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                        class="kt-svg-icon">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect id="bound" x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M5,19 L20,19 C20.5522847,19 21,19.4477153 21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 C4.55228475,3 5,3.44771525 5,4 L5,19 Z"
                                                id="Path-95" fill="#000000" fill-rule="nonzero" />
                                            <path
                                                d="M8.7295372,14.6839411 C8.35180695,15.0868534 7.71897114,15.1072675 7.31605887,14.7295372 C6.9131466,14.3518069 6.89273254,13.7189711 7.2704628,13.3160589 L11.0204628,9.31605887 C11.3857725,8.92639521 11.9928179,8.89260288 12.3991193,9.23931335 L15.358855,11.7649545 L19.2151172,6.88035571 C19.5573373,6.44687693 20.1861655,6.37289714 20.6196443,6.71511723 C21.0531231,7.05733733 21.1271029,7.68616551 20.7848828,8.11964429 L16.2848828,13.8196443 C15.9333973,14.2648593 15.2823707,14.3288915 14.8508807,13.9606866 L11.8268294,11.3801628 L8.7295372,14.6839411 Z"
                                                id="Path-97" fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                transform="translate(14.000019, 10.749981) scale(1, -1) translate(-14.000019, -10.749981) " />
                                        </g>
                                    </svg>
                                </div>
                                <div class="kt-iconbox__desc">
                                    <h3 class="kt-iconbox__title">
                                        <a class="kt-link" href="javascript:void(0)">Reporte por Ronda</a>
                                    </h3>
                                    <div class="kt-iconbox__content">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
              <!-- begin:: Content -->
              <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">


                        <div class="kt-portlet kt-portlet--mobile">
                            <div class="kt-portlet__head kt-portlet__head--lg">
                                <div class="kt-portlet__head-label">
                                    <span class="kt-portlet__head-icon">
                                        <i class="kt-font-brand flaticon2-line-chart"></i>
                                    </span>
                                    <h3 class="kt-portlet__head-title">
                                        Subasta
                                    </h3>
                                </div>
                            </div>

                            <div class="kt-portlet__body">
                                <!--begin: Search Form -->
                                <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
                                    <div class="row align-items-center">
                                        <div class="col-xl-8 order-2 order-xl-1">
                                            <div class="row align-items-center">
                                                <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                                    <div class="kt-input-icon kt-input-icon--left">
                                                        <input type="text" class="form-control" placeholder="Search..."
                                                            id="generalSearch">
                                                        <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                                            <span><i class="la la-search"></i></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                                    <div class="kt-form__group kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Status:</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <select class="form-control bootstrap-select"
                                                                id="kt_form_status">
                                                                <option value="">All</option>
                                                                <option value="1">Activo</option>
                                                                <option value="2">Desierto</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
                                                    <div class="kt-form__group kt-form__group--inline">
                                                        <div class="kt-form__label">
                                                            <label>Type:</label>
                                                        </div>
                                                        <div class="kt-form__control">
                                                            <select class="form-control bootstrap-select"
                                                                id="kt_form_type">
                                                                <option value="">All</option>
                                                                <option value="1">success</option>
                                                                <option value="2">danger</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 order-1 order-xl-2 kt-align-right">
                                            <a href="#" class="btn btn-default kt-hidden">
                                                <i class="la la-cart-plus"></i> New Order
                                            </a>
                                            <div
                                                class="kt-separator kt-separator--border-dashed kt-separator--space-lg d-xl-none">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Search Form -->
                            </div>
                            <div class="kt-portlet__body kt-portlet__body--fit">
                                <!--begin: Datatable -->
                                <div class="my_datatable" id="kt_datatable"></div>
                                <!--end: Datatable -->
                            </div>
                        </div>
                    </div>
                    <!-- end:: Content -->
            </div>
        </div>
    </div>
</div>
<!-- end:: Content -->

<script>

</script>
@section('scripts')
<script src="{{ URL::asset('js/dataSubastaAdmin.js')}}" type="text/javascript"></script>
@endsection
@endsection

