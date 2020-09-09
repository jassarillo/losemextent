{{-- \resources\views\users\index.blade.php --}}

@extends('home')

@section('title', '| Users')

@section('content')
<!-- begin:: Content -->
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
                            </svg> Datos Generales
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_user_edit_tab_3" role="tab">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect id="bound" x="0" y="0" width="24" height="24" />
                                    <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" id="Path-50" fill="#000000" opacity="0.3" />
                                    <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" id="Mask" fill="#000000" opacity="0.3" />
                                    <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" id="Mask-Copy" fill="#000000" opacity="0.3" />
                                </g>
                            </svg> Bienes
                        </a>
                    </li>

                    
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_user_edit_tab_4" role="tab">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect id="bound" x="0" y="0" width="24" height="24" />
                                    <path d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 Z M7.5,5 C7.22385763,5 7,5.22385763 7,5.5 C7,5.77614237 7.22385763,6 7.5,6 L13.5,6 C13.7761424,6 14,5.77614237 14,5.5 C14,5.22385763 13.7761424,5 13.5,5 L7.5,5 Z M7.5,7 C7.22385763,7 7,7.22385763 7,7.5 C7,7.77614237 7.22385763,8 7.5,8 L10.5,8 C10.7761424,8 11,7.77614237 11,7.5 C11,7.22385763 10.7761424,7 10.5,7 L7.5,7 Z" id="Combined-Shape" fill="#000000" opacity="0.3" />
                                    <path d="M3.79274528,6.57253826 L12,12.5 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 Z" id="Combined-Shape" fill="#000000" />
                                </g>
                            </svg> Configuración
                        </a>
                    </li>

                   
                </ul>
            </div>
        </div>
        <div class="kt-portlet__body">
            
                <div class="tab-content">
                    <div class="tab-pane active" id="kt_user_edit_tab_1" role="tabpanel">
                        <div class="kt-form kt-form--label-right">
                        {{ Form::open(['url' => 'foo/bar','method' => 'POST','name'=>'form_update_user','id'=>'form_update_user','files' => true]) }}
                            <div class="kt-form__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-sm">Captura de Datos Requisición:
                                                        </h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Imagen de Perfil</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="kt-avatar kt-avatar--outline kt-avatar--circle-" id="kt_user_edit_avatar">
                                                    <div class="kt-avatar__holder">
                                                    </div>
                                                    <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="" data-original-title="Change avatar">
                                                        <i class="fa fa-pen"></i>
                                                        <input type="file" id="file" name="file" accept=".png, .jpg, .jpeg">
                                                    </label>
                                                    <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="" data-original-title="Cancel avatar">
                                                                <i class="fa fa-times"></i>
                                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('usuario', 'Usuario', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="la la-user kt-font-brand"></i></span>
                                                    </div>
                                                    {{ Form::text('usuario', auth()->user()->usuario, array('class' => 'form-control','disabled' => true)) }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            {{ Form::label('name', 'Nombre(s)', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::text('name', auth()->user()->name, array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('apellido_paterno', 'Apellido Paterno', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::text('apellido_paterno', auth()->user()->apellido_paterno, array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('apellido_materno', 'Apellido Materno', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::text('apellido_materno', auth()->user()->apellido_materno, array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('email', 'Correo Electrónico', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="la la-at"></i></span>
                                                    </div>
                                                    {{ Form::text('email', auth()->user()->email, array('class' => 'form-control','disabled' => true)) }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"> </div>

                                        <div class="kt-form__actions">
                                            <div class="row">
                                                <div class="col-xl-3"></div>
                                                <div class="col-lg-9 col-xl-6">                                                    
                                                    <button type="submit" class="btn btn-brand" >Editar Perfil</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                        </div>
                    </div>

                    <div class="tab-pane" id="kt_user_edit_tab_3" role="tabpanel">
                        <div class="kt-form kt-form--label-right">
                        {{ Form::open(['url' => 'foo/bar','method' => 'POST','name'=>'form_update_passwd','id'=>'form_update_passwd']) }}
                            <div class="kt-form__body">
                            

                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <!-- <div class="alert alert-solid-danger alert-bold fade show kt-margin-t-20 kt-margin-b-40" role="alert">
                                            <div class="alert-icon"><i class="fa fa-exclamation-triangle"></i>
                                            </div>
                                            <div class="alert-text">Configure las contraseñas de los usuarios para que caduquen periódicamente.
                                                <br>¡Los usuarios necesitarán advertencias de que sus contraseñas caducarán, o podrían quedar bloqueadas del sistema sin darse cuenta!
                                            </div>
                                            <div class="alert-close">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true"><i class="la la-close"></i></span>
                                                </button>
                                            </div>
                                        </div> -->

                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-sm">Cambiar o Recuperar Contraseña:</h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {{ Form::label('password_actual', 'Contraseña actual', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}
                                            <div class="col-lg-9 col-xl-6">
                                                {{ Form::password('password_actual', array('class' => 'form-control')) }}
                                                <a href="#" class="kt-link kt-font-sm kt-font-bold kt-margin-t-5">¿Olvidaste tu contraseña?</a>
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

                    
                    <div class="tab-pane" id="kt_user_edit_tab_4" role="tabpanel">
                        <div class="kt-form kt-form--label-right">
                            <div class="kt-form__body">
                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-sm">Setup Email
                                                            Notification:</h3>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-sm row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Email Notification
                                            </label>
                                            <div class="col-lg-9 col-xl-6">
                                                <span class="kt-switch">
                                                            <label>
                                                                <input type="checkbox" checked="checked"
                                                                    name="email_notification_1">
                                                                <span></span>
                                                </label>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-last row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Send Copy To Personal Email
                                            </label>
                                            <div class="col-lg-9 col-xl-6">
                                                <span class="kt-switch">
                                                            <label>
                                                                <input type="checkbox" name="email_notification_2">
                                                                <span></span>
                                                </label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit kt-separator--space-lg">
                                </div>

                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-sm">Activity
                                                            Related
                                                            Emails:</h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">When To Email
                                            </label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="kt-checkbox-list">
                                                    <label class="kt-checkbox">
                                                        <input type="checkbox"> You have new notifications.
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-checkbox">
                                                        <input type="checkbox"> You're sent a direct message
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-checkbox">
                                                        <input type="checkbox" checked="checked"> Someone adds you as a connection
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-last row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">When To Escalate Emails
                                            </label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="kt-checkbox-list">
                                                    <label class="kt-checkbox kt-checkbox--brand">
                                                        <input type="checkbox"> Upon new order.
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-checkbox kt-checkbox--brand">
                                                        <input type="checkbox"> New membership approval
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-checkbox kt-checkbox--brand">
                                                        <input type="checkbox" checked="checked"> Member registration
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit kt-separator--space-lg">
                                </div>

                                <div class="kt-section kt-section--first">
                                    <div class="kt-section__body">
                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <h3 class="kt-section__title kt-section__title-sm">Updates From
                                                            Keenthemes:</h3>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Email You With
                                            </label>
                                            <div class="col-lg-9 col-xl-6">
                                                <div class="kt-checkbox-list">
                                                    <label class="kt-checkbox">
                                                        <input type="checkbox"> News about Metronic product and feature updates
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-checkbox">
                                                        <input type="checkbox"> Tips on getting more out of Keen
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-checkbox">
                                                        <input type="checkbox" checked="checked"> Things you missed since you last logged into Keen
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-checkbox">
                                                        <input type="checkbox" checked="checked"> News about Metronic on partner products and other services
                                                        <span></span>
                                                    </label>
                                                    <label class="kt-checkbox">
                                                        <input type="checkbox" checked="checked"> Tips on Metronic business products
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   

                </div>
            
        </div>
    </div>
</div>
<!-- end:: Content -->
@section('scripts')

<script>

$( document).ready(function() {
    
// Class definition
var KTUserEdit = function () {
	// Base elements
    var avatar;  
	 
	var initUserForm = function() {
		avatar = new KTAvatar('kt_user_edit_avatar');
	}	

	return {
		// public functions
		init: function() {            
			initUserForm(); 
		}
	};
}();


    KTUserEdit.init();
    
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
            //alert('success');
        },
        rules: {
            password_actual: {
                required: true, 
                    remote: {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url+'users/validPassword', type: 'POST', cache: false, dataType: 'json', data: {
                            password_actual: function() {
                                return $('#password_actual').val();
                            }
                        },
                        dataFilter: function(response) {                            
                            response=$.parseJSON(response);
                            if (response.status==='valido') {
                                return true;
                            }
                            else {
                                message="La contraseña es incorrecta";
                                return false;
                            }

                            
                        },
                        error: function(respuesta) {
                            
                        }
                    }
            },
            new_password: {
                required: true
            },
            verify_password: {
                required: true, equalTo: "#new_password"
            }
        },
        messages: {
            password_actual: {
                remote: function(){ return message; }
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
                url: url+"users/updatePassword",
                type: 'POST',
                beforeSend: function(){                       
                    KTApp.block(portlet,{ message: 'Procesando...'});
                },
                data: {
                    "_token": $("meta[name='csrf-token']").attr("content"),
                    new_password: $('#new_password').val()
                },                   
                success: function(data) {
                    console.log(data);
                    swal.fire(swal_title(data.status), data.message, data.status);
                    KTApp.unblock(portlet);
                    $("#form_update_passwd")[0].reset();
                },
                error: function() {
                    KTApp.unblock(portlet); 
                }
            });
            
            return false;
        }
    });


    $('#form_update_user').submit(function(event) {
    event.preventDefault();
    
    $.ajax({
        url: '{{ url('/users/editUser') }}',
        type: 'POST', 
        contentType: false,
        processData: false,             
        data:new FormData($("#form_update_user")[0]),
        beforeSend: function(){                       
            KTApp.block(portlet,{ message: 'Procesando...'});
        },
        success: function(data){
            swal.fire(swal_title(data.status), data.message, data.status);
            if(data.status=='success'){
                $("#img_avatar_header").attr("src",'{{env('APP_URL')}}storage/app/'+data.avatar);
                $("#img_avatar_header_menu").attr("src",'{{env('APP_URL')}}storage/app/'+data.avatar);
            }
            KTApp.unblock(portlet);
           //location.reload();
        },
        error: function(data)
        {
            KTApp.unblock(portlet);
            console.log(data);
        }
    });

});
});

function  editUser(){ 
      
    /*var formData = new FormData($("#form_update_user")[0]); 

    $.ajax({
        url: url+"users/editUser",
        type: 'POST',
        data: formData,                
        success: function(data) {
            console.log(data);
            if(callback){
                callback();
            }else{
                sweet_response(data.status,data.message);
            }            
        },
        error: function() {
            sweet_response('error','');
        }
    }); */

    //requestAjax("users/editUser","form_update_user");
}

function requestAjax(liga,form,callback){
    var form = $("#"+form);    
    $.ajax({
        url: url+liga,
        type: 'POST',
        data: form.serialize(),                
        success: function(data) {
            console.log(data);
            if(callback){
                callback();
            }else{
                swal.fire(swal_title(data.status), data.message, data.status);
            }            
        },
        error: function() {
            sweet_response('error','');
        }
    }); 
}

function swal_title(typeResponse){
    return (typeResponse=='success')?'Bien hecho!':'Ups, ocurrió  un error!';
}
/*function sweet_response(typeResponse,message){
    var titulo = (typeResponse=='success')?'Bien hecho!':'Ups, ocurrió  un error!';
    swal.fire({
        "title": titulo, 
        "text": message, 
        "type": typeResponse,
        "confirmButtonClass": "btn btn-brand btn-elevate",
        "onClose": function(e) {
            //console.log('on close event fired!');
        }
    });
}*/
    
</script>

@endsection	
@endsection