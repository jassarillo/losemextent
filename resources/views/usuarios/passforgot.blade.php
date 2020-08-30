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
                            </svg> Contraseña Olvidada
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
                                                <h3 class="kt-section__title kt-section__title-sm">Solicitud de Contraseña Olvidada:
                                                        </h3>
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
                                        <div class="row">
                                            <label class="col-xl-3"></label>
                                            <div class="col-lg-9 col-xl-6">
                                                <h4 class="kt-section__title kt-section__title-sm">Correo electronico de la cuenta a Solicitar:
                                                        </h4>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            {{ Form::label('email', 'Correo Electrónico', array('class' => 'col-xl-3 col-lg-3 col-form-label')) }}

                                            <div class="col-lg-9 col-xl-6">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="la la-at"></i></span>
                                                    </div>
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="_token">
                                                    {{ Form::text('email', auth()->user()->email, array('class' => 'form-control','disabled' => true)) }}
                                                    <br>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="kt-separator kt-separator--space-lg kt-separator--fit kt-separator--border-solid"> </div>

                                        <div class="kt-form__actions">
                                            <div class="row">
                                                <div class="col-xl-3"></div>
                                                <div class="col-lg-9 col-xl-6">
                                                    <button type="submit" class="btn btn-brand" >Envio de Solicitud</button>
                                                </div>
                                            </div>
                                        </div>

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
<!-- end:: Content -->


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
    var token = $('#_token').val();
    $('#form_update_user').submit(function(event) {
    event.preventDefault();

    $.ajax({

        url: '{{ url("passForgot") }}',
        type: 'POST',
        contentType: false,
        processData: false,
        data:{
            "_token": $("meta[name='csrf-token']").attr("content"),
              email :  $('#email').val(),
            },
        beforeSend: function(){
            KTApp.block(portlet,{ message: 'Procesando...'});
        },
        success: function(data){
            swal.fire(swal_title(data.status), data.message, data.status);
            if(data.status=='success'){
                KTApp.block(portlet,{ message: 'Contraseña enviada al correo...'});
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

</script>
