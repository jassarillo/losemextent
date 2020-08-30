<!-- begin:: Content -->
@extends('guest')
@section('content')
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet kt-portlet--tabs">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-space-xl nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_user_edit_tab_1" role="tab">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon id="Shape" points="0 0 24 0 24 24 0 24" />
                                    <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" id="Mask" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                    <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" id="Mask-Copy" fill="#000000" fill-rule="nonzero" />
                                </g>
                            </svg> Cambio de Contraseña
                        </a>
                    </li>
                                  </ul>
            </div>
            
        </div>
        <div class="kt-portlet__body">
                <input type="hidden" class="form-control" id="usuario" name="usuario" value="{{$datosU->usuario}}">
                <div class="tab-content">                   
                    <div class="tab-pane active" id="kt_user_edit" role="tabpanel">
                        <div class="kt-form kt-form--label-right">
                        {{ Form::open(['url' => 'foo/bar','method' => 'POST','name'=>'form_update_passwd','id'=>'form_update_passwd']) }}
                            <div class="kt-form__body">                            
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                         <div class="alert alert-solid-danger alert-bold fade show kt-margin-t-20 kt-margin-b-40" role="alert">
                                            <div class="alert-icon"><i class="fa fa-exclamation-triangle"></i>
                                            </div>
                                            <div class="alert-text">La contraseña anterior se eliminara y esta sera su nueva contraseña                                            
                                            </div>
                                            <div class="alert-close">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true"><i class="la la-close"></i></span>
                                                </button>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-sm">Ingresa tu Nueva Contraseña:</h3>
                                            </div>
                                        </div>                                       
                                        <div class="form-group row">
                                            {{ Form::label('new_password', 'Nueva Contraseña', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::password('new_password', array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                        <div class="form-group form-group-last row">
                                            {{ Form::label('verify_password', 'Verificar Contraseña', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::password('verify_password', array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>                            
                            </div>
                            <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid">
                            </div>
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-xl-3"></div>
                                    <div class="col-lg-9 col-xl-6">
                                    <button type="submit" class="btn btn-brand">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
    @section('scripts')
<script>
   
$( document).ready(function() {        
    var portlet = $("#kt_content"); 
    var message = '';
    $('#form_update_passwd').validate({
        onfocusout: false,
        onkeyup: false,
        onclick: false,
        //errorClass:'error invalid-feedback',
        //errorElement: 'input',
        errorElementClass: 'is-invalid',
        errorClass: 'error invalid-feedback',
        success: function() {           
        },
        rules: {           
            new_password: {
                required: true,
                required: true,
                            minlength: 3
            },
            verify_password: {
                required: true, equalTo: "#new_password",
                required: true,
                minlength: 3
            }
        },  messages: {
            new_password: {
                             required: 'Debe ingresar la contraseña', 
                             minlength: 'La contraseña debe tener mínimo 3 caracteres'                           
                             },
            verify_password: {
                             required: 'Debe ingresar la contraseña', 
                             minlength: 'La contraseña debe tener mínimo 3 caracteres',
                             equalTo: 'Debe ingresar la misma constraseña'
                             }
            },                                                                     
        highlight: function (element, required) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {            
            $.ajax({
                url: url+"passUpdate",
                type: 'POST',
                beforeSend: function(){                       
                   // KTApp.block(portlet,{ message: 'Procesando...'});
                },
                data: {
                    "_token": $("meta[name='csrf-token']").attr("content"),
                    new_password: $('#new_password').val(),
                    usuario: $('#usuario').val()
                },                   
                success: function(data) {   
                    if(data.status == "error"){                                                      
                        Swal.fire('La contraseña no se actualizo','Intente mas tarde','error');                                                                      
                        }
                        else{  
                            window.location.href = "../home";                                                
                        }                                        
                },
                error: function() {
                    Swal.fire('Error!','Intentar mas tarde','error');
                }
            });            
            return false;
        }
    });
});  
</script>
@endsection
@endsection