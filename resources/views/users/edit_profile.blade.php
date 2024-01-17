@extends('layout')

@section('title', 'User')

@section('css')

@endsection

@section('content')
    <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Edit Profile</span></h4>
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
				<form id="submit-form" class="form-validate-jquery" action="{{url('/profile/update')}}" method="post" enctype="multipart/form-data">
                    @method('PATCH')
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Profile</legend>

                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Nama <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="name" value="{{$user->name}}"
                                class="form-control border-blue-700 border-1 @error('name') is-invalid @enderror"
                                placeholder="Nama" required autofocus autocomplete="off">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Username <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="username" value="{{$user->username}}"
                                class="form-control border-blue-700 border-1 @error('username') is-invalid @enderror"
                                placeholder="Username" required autocomplete="off">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Email </label>
							<div class="col-lg-10">
								<input type="email" name="email" value="{{$user->email}}"
                                class="form-control border-blue-700 border-1 @error('email') is-invalid @enderror"
                                placeholder="Email" autocomplete="off">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Telepon </label>
							<div class="col-lg-10">
								<input type="string" name="phone" value="{{$user->phone}}"
                                class="form-control border-blue-700 border-1 @error('phone') is-invalid @enderror"
                                placeholder="Telepon" autocomplete="off">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Foto </label>
							<div class="col-lg-10">
								<div class="card-img-actions mb-3">
									<img class="card-img img-fluid" id="preview_image"
                                    src="{{asset($user->image) ?? asset('global_assets/images/placeholders/placeholder.jpg')}}" alt=""
                                    style="height:150px;width:150px;object-fit: contain;">
								</div>
							    <input type="file" name="image" id="image" class="form-control border-blue-700 border-1">
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
                    messages: {
                        name: {
                            required: 'Mohon diisi.'
                        },
                        username: {
                            required: 'Mohon diisi.'
                        },
                        role_id: {
                            required: 'Mohon pilih salah satu.'
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
