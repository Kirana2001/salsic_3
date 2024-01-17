@extends('layout')

@section('title', 'Ubah Password')

@section('css')

@endsection

@section('content')
    <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Ubah Password</span></h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->

    <!-- Content area -->
	<div class="content">

		<!-- Hover rows -->
		<div class="card">
			<div class="card-header header-elements-inline">
			</div>
			<div class="card-body">
				<form id="submit-form" class="form-validate-jquery" action="{{url('ubah-password/'.Auth::user()->id)}}" method="post">
                    @method('PATCH')
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Ubah Password</legend>

                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Password Lama <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="password_lama"
                                class="form-control border-blue-700 border-1 @error('password_lama') is-invalid @enderror"
                                placeholder="Password Lama" required autofocus autocomplete="off">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Password Baru <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="password_baru" id="password_baru"
                                class="form-control border-blue-700 border-1 @error('password_baru') is-invalid @enderror"
                                placeholder="Password Baru" required autofocus autocomplete="off">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Konfirmasi Password <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="konfirmasi_password"
                                class="form-control border-blue-700 border-1 @error('konfirmasi_password') is-invalid @enderror"
                                placeholder="Konfirmasi Password" required autofocus autocomplete="off">
							</div>
						</div>

					</fieldset>
					<div class="text-right">
						<a href="{{ url('/users')}}" class="btn btn-light">Kembali <i class="icon-undo"></i></a>
						<button type="submit" class="btn btn-primary">Simpan <i class="icon-paperplane ml-2"></i></button>
					</div>
				</form>
			</div>

		</div>
		<!-- /hover rows -->

	</div>
	<!-- /content area -->
@endsection

@section('js')
    <script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
    <script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>

    <script type="text/javascript">
        var FormValidation = function() {

            // Validation config
            var _componentValidation = function() {
                if (!$().validate) {
                    console.warn('Warning - validate.min.js is not loaded.');
                    return;
                }

                // Initialize
                var validator = $('.form-validate-jquery').validate({
                    ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
                    errorClass: 'validation-invalid-label',
                    // successClass: 'validation-valid-label',
                    validClass: 'validation-valid-label',
                    highlight: function(element, errorClass) {
                        $(element).removeClass(errorClass);
                    },
                    unhighlight: function(element, errorClass) {
                        $(element).removeClass(errorClass);
                    },
                    // success: function(label) {
                    //    label.addClass('validation-valid-label').text('Success.'); // remove to hide Success message
                    // },

                    // Different components require proper error label placement
                    errorPlacement: function(error, element) {

                        // Unstyled checkboxes, radios
                        if (element.parents().hasClass('form-check')) {
                            error.appendTo( element.parents('.form-check').parent() );
                        }

                        // Input with icons and Select2
                        else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
                            error.appendTo( element.parent() );
                        }

                        // Input group, styled file input
                        else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
                            error.appendTo( element.parent().parent() );
                        }

                        // Other elements
                        else {
                            error.insertAfter(element);
                        }
                    },
                    rules: {
                        password_lama: {
                            minlength: 8,
                        },
                        password_baru: {
                            minlength: 8,
                        },
                        konfirmasi_password: {
                            equalTo: '#password_baru'
                        }
                    },
                    messages: {
                        password_lama: {
                            required: 'Mohon diisi.',
                            minlength: 'Minimal 8 karakter.',
                        },
                        password_baru: {
                            required: 'Mohon diisi.',
                            minlength: 'Minimal 8 karakter.',
                        },
                        konfirmasi_password: {
                            required: 'Mohon diisi.',
                            equalTo: 'Password baru dan konfirmasi password berbeda.'
                        },
                    },
                });

                // Reset form
                $('#reset').on('click', function() {
                    validator.resetForm();
                });
            };

            // Return objects assigned to module
            return {
                init: function() {
                    _componentValidation();
                }
            }
        }();

        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            FormValidation.init();
        });
    </script>
    <script type="text/javascript">
        $('#image').on("change", function () {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    $('#preview_image').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
	<script type="text/javascript">
		$( document ).ready(function() {
            // Select2
            var $select = $('.form-control-select2').select2();

	        // Default style
	        @if(session('error'))
	            new PNotify({
	                title: 'Error',
	                text: '{{ session('error') }}.',
	                icon: 'icon-blocked',
	                type: 'error'
	            });
            @endif
            @if ( session('success'))
	            new PNotify({
	                title: 'Success',
	                text: '{{ session('success') }}.',
	                icon: 'icon-checkmark3',
	                type: 'success'
	            });
            @endif

		});
	</script>
@endsection
