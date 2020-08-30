// Validar formulario mediante plugin jquery-validation
function formValidate(element) {
	var form = $(element);
	form.validate();
	return form.valid();
}

$.extend($.validator, {
	messages: {
		required: "Campo requerido.",
		remote: "Favor de revisar la información.",
		email: "Favor de ingresar una cuenta de email valida.",
		url: "Favor de ingresar un URL valida.",
		date: "Favor de ingresa una fecha valida.",
		dateISO: "Favor de ingresa una fecha valida ( ISO ).",
		number: "Favor de ingresar un número valido.",
		digits: "Favor de ingresar sólo digitos.",
		creditcard: "Número de tarjeta de crédito invalido.",
		equalTo: "El valor no coincide.",

	},

	defaults: {
		messages: {},
		groups: {},
		rules: {},
		errorElementClass: 'is-invalid',
		errorClass: 'error invalid-feedback',
		//errorElement: 'span', //default input error message container
		focusCleanup: false,
		focusInvalid: true,
		errorContainer: $([]),
		errorLabelContainer: $([]),
		doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
		onsubmit: true,
		ignore: ":hidden",
		ignoreTitle: false,
		onfocusin: function (element) {
			this.lastActive = element;

			// Hide error label and remove error class on focus if enabled
			if (this.settings.focusCleanup) {
				if (this.settings.unhighlight) {
					this.settings.unhighlight.call(this, element, this.settings.errorClass, this.settings.validClass);
				}
				this.hideThese(this.errorsFor(element));
			}
		},
		onfocusout: function (element) {
			if (!this.checkable(element) && (element.name in this.submitted || !this.optional(element))) {
				this.element(element);
			}
		},
		onkeyup: function (element, event) {
			// Avoid revalidate the field when pressing one of the following keys
			// Shift       => 16
			// Ctrl        => 17
			// Alt         => 18
			// Caps lock   => 20
			// End         => 35
			// Home        => 36
			// Left arrow  => 37
			// Up arrow    => 38
			// Right arrow => 39
			// Down arrow  => 40
			// Insert      => 45
			// Num lock    => 144
			// AltGr key   => 225
			var excludedKeys = [
				16, 17, 18, 20, 35, 36, 37,
				38, 39, 40, 45, 144, 225
			];

			if (event.which === 9 && this.elementValue(element) === "" || $.inArray(event.keyCode, excludedKeys) !== -1) {
				return;
			} else if (element.name in this.submitted || element === this.lastElement) {
				this.element(element);
			}
		},
		onclick: function (element) {
			// click on selects, radiobuttons and checkboxes
			if (element.name in this.submitted) {
				this.element(element);
				// or option elements, check parent select in that case
			} else if (element.parentNode.name in this.submitted) {
				this.element(element.parentNode);
			}
		},
		highlight: function (element, required) {
			$(element).addClass('is-invalid');
			if (element.type === "radio") {
				this.findByName(element.name).addClass(errorClass).removeClass(validClass);
			} else {
				// $( element ).removeClass( errorClass ).addClass( validClass );
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
			}
		},
		unhighlight: function (element, errorClass, validClass) {
			$(element).removeClass('is-invalid');
		},
		errorPlacement: function (error, element) { // render error placement for each input type
			if (element.hasClass("select2")) {
				var element_select2 = $(element).siblings('.select2-container');
				error.insertAfter(element_select2); // input with select2
			} else {
				error.insertAfter(element); // for other inputs, just perform default behavior
			}
		},
		success: function (label) {
			label.addClass('valid') // mark the current input as valid and display OK icon
				.closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
		},

	},


});


function carga_archivo(div_contenedor, ruta, parametros) {
	//$('body').addClass('m-page--loading-non-block');
	$('#' + div_contenedor).load(ruta, parametros, function () {
		$('body').removeClass('m-page--loading-non-block');
	});
}


function bloquea_pantalla() {
	var nombre = $('#nombre').val();  // trae el nombre del usuario logeado
	Swal.fire({
		title: nombre,
		allowOutsideClick: false,
		allowEscapeKey: false,
		input: 'password',
		inputAttributes: {
			'data-lpignore': true
		},
		imageUrl: "assets/media/logos/lock2.png",
		imageWidth: 200,
		imageHeight: 200,
		imageAlt: 'Custom image',
		confirmButtonText: 'Desbloquear',

		footer: '<a href="logout">¿No es tu usuario?</a>',
		preConfirm: (login) => {

			console.log(login);
			return fetch(`//api.github.com/users/${login}`)
				.then(response => {
					if (!response.ok) {
						throw new Error(response.statusText)
					}
					return response.json()
				})
				.catch(error => {
					Swal.showValidationMessage(
						'Password Incorrecto!'
					)
				})
		},
		background: '#fff url(assets/media/bg/bg-3.jpg)',
		backdrop: 'rgba(0,0,123,0.4)url("assets/media/bg/bg-3.jpg") center left',
	  }).then((result) => {
		if (result.value) {
			Swal.close();
		}
	})
}
var initScrolltop = function () {
	var scrolltop = new KTScrolltop('kt_scrolltop', {
		offset: 300,
		speed: 600
	});
}

"use strict";

var KTSessionTimeoutDemo = function () {

	var initDemo = function () {
		$.sessionTimeout({
			// title: 'Notifiación de tiempo  de  sesión',
			// message: 'Tu sesión esta a punto de expirar.',
			// keepAliveUrl: url,
			// redirUrl: '?p=page_user_lock_1',
			// logoutUrl: '?p=page_user_login_1',
			// warnAfter: 10000, //warn after 10 seconds
			// redirAfter: 30000, //redirect after 20 seconds,
			// ignoreUserActivity: true,
			// countdownMessage: 'Redireccionando en {timer} segundos.',
			// countdownBar: true
			title: '¡Su sesión está a punto de caducar!',
			message: 'Su sesión se bloqueará en un minuto.',
			logoutButton: 'Salir',
			keepAliveButton: 'Mantenerme Conectado',
			//keepAliveAjaxRequestType: 'GET',
			ajaxData: {
				"_token": $("meta[name='csrf-token']").attr("content"),
			},
			keepAliveUrl: url + 'block_screen',
			logoutUrl: url + 'logout',
			redirUrl: url + 'block_screen',
			warnAfter: 10000, //10000 -> 10s
			redirAfter: 30000, // 30000 -> 20s
			countdownMessage: 'Redireccionando en {timer} segundos.',
			countdownBar: true
		});
	}


	return {
		//main function to initiate the module
		init: function () {
			initDemo();
		}
	};

}();
var KTBootstrapDatepicker = function () {

    var arrows;
    if (KTUtil.isRTL()) {
        arrows = {
            leftArrow: '<i class="la la-angle-right"></i>',
            rightArrow: '<i class="la la-angle-left"></i>'
        }
    } else {
        arrows = {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    }

    // Private functions
    var demos = function () {

 // input group layout
 $('#kt_datepicker_2, #kt_datepicker_2_validate').datepicker({
    rtl: KTUtil.isRTL(),
    todayHighlight: true,
    orientation: "bottom left",
    templates: arrows
});

// input group layout for modal demo
$('#kt_datepicker_2_modal').datepicker({
    rtl: KTUtil.isRTL(),
    todayHighlight: true,
    orientation: "bottom left",
    templates: arrows
});
        // minimum setup
                // enable clear button
        $('#kt_datepicker_3, #kt_datepicker_3_validate').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            templates: arrows
        });

        // enable clear button for modal demo
        $('#kt_datepicker_3_modal').datepicker({
            rtl: KTUtil.isRTL(),
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            templates: arrows
        });

        // orientation
        $('#kt_datepicker_4_1').datepicker({
            rtl: KTUtil.isRTL(),
            orientation: "top left",
            todayHighlight: true,
            templates: arrows
        });

        $('#kt_datepicker_4_2').datepicker({
            rtl: KTUtil.isRTL(),
            orientation: "top right",
            todayHighlight: true,
            templates: arrows
        });

        $('#kt_datepicker_4_3').datepicker({
            rtl: KTUtil.isRTL(),
            orientation: "bottom left",
            todayHighlight: true,
            templates: arrows
        });

        $('#kt_datepicker_4_4').datepicker({
            rtl: KTUtil.isRTL(),
            orientation: "bottom right",
            todayHighlight: true,
            templates: arrows
        });

        // range picker
        $('#kt_datepicker_5').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            templates: arrows
        });

         // inline picker
        $('#kt_datepicker_6').datepicker({
            rtl: KTUtil.isRTL(),
            todayHighlight: true,
            templates: arrows
        });
    }

    return {
        // public functions
        init: function() {
            demos();
        }
    };
}();

jQuery(document).ready(function () {
	// KTSessionTimeoutDemo.init();
    initScrolltop();
    KTBootstrapDatepicker.init();

    $("#termCond").on('click',function(t){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'condTerminos',
            dataType: 'html',
            success: function(resp_success) {
                var modal = resp_success;
                $(modal).modal().on('shown.bs.modal', function() {

                }).on('hidden.bs.modal', function() {
                    $(this).remove();
                });
            },
            error: function(respuesta) {
                Swal.fire('¡Alerta!','Error de conectividad de red USR-03','warning');
            }
        });




        });


    $("#contactos_dash").on('click',function(t){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url +  'home/contactos',
            dataType: 'html',
            success: function(resp_success) {
                var modal = resp_success;
                $(modal).modal().on('shown.bs.modal', function() {

                }).on('hidden.bs.modal', function() {
                    $(this).remove();
                });
            },
            error: function(respuesta) {
                Swal.fire('¡Alerta!','Error de conectividad de red USR-03','warning');
            }
        });
    });
});

/**
 *
 * functions to add, hide or reload modals
 *
 */



function setSelectOption(id,valor){
    $("#"+id+" option[value='"+valor+"']").prop('selected', true);
}

function destroyModal(modal){

    $("#"+modal).modal('hide').on('hidden.bs.modal', function() {
        $(this).remove();
    });
}

function reloadTable(table){
    $('#'+table).DataTable().ajax.reload();
}

function addClassSpinner(id,position){
	var pos = (position=='L')?'kt-spinner--left':'kt-spinner--right';
    $("#"+id).addClass("kt-spinner kt-spinner--sm kt-spinner--success "+pos+" kt-spinner--input");
}

function removeClassSpinner(id,position){
	var pos = (position=='L')?'kt-spinner--left':'kt-spinner--right';
    $("#"+id).removeClass("kt-spinner kt-spinner--sm kt-spinner--success "+pos+" kt-spinner--input");
}

function setSelectOption(id,valor){
    $("#"+id+" option[value='"+valor+"']").prop('selected', true);
}

function destroyModal(modal){

    $("#"+modal).modal('hide').on('hidden.bs.modal', function() {
        $(this).remove();
    });
}

function reloadTable(table){
    $('#'+table).DataTable().ajax.reload();
}

function onlyNumber(e){
	var key = window.Event ? e.which : e.keyCode;
	return (key >= 48 && key <= 57);
}

