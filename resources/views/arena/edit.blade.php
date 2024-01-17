@extends('layout')

@section('title', 'Arena')

@section('css')

@endsection

@section('content')
    <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Edit</span> - Arena</h4>
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
				<form id="submit-form" class="form-validate-jquery" action="{{url('arena/'.$arena->id)}}" method="post" enctype="multipart/form-data">
                    @method('PATCH')
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Arena</legend>

                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Nama <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="name"
                                class="form-control border-blue-700 border-1 @error('name') is-invalid @enderror"
                                placeholder="Nama" required autofocus autocomplete="off" value="{{ $arena->name }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Kepemilikan <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="ownership"
                                class="form-control border-blue-700 border-1 @error('ownership') is-invalid @enderror"
                                placeholder="Kepemilikan" required autofocus autocomplete="off" value="{{ $arena->ownership }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Alamat <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
                                <textarea name="address" id="address"
                                class="form-control border-blue-700 border-1 @error('address') is-invalid @enderror"
                                placeholder="Alamat" required autocomplete="off" cols="30" rows="5">{{ $arena->address }}</textarea>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Longitude <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="number" name="longitude"
                                class="form-control border-blue-700 border-1 @error('longitude') is-invalid @enderror"
                                placeholder="Longitude" required autocomplete="off" value="{{ $arena->longitude }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Latitude <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="number" name="latitude"
                                class="form-control border-blue-700 border-1 @error('latitude') is-invalid @enderror"
                                placeholder="Latitude" required autocomplete="off" value="{{ $arena->latitude }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Fasilitas <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
                                <textarea name="facilities" id="facilities"
                                class="form-control border-blue-700 border-1 @error('facilities') is-invalid @enderror"
                                placeholder="Fasilitas" required autocomplete="off" cols="30" rows="5">{{ $arena->facilities }}</textarea>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Foto <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<div class="card-img-actions mb-3">
									<img class="card-img img-fluid" id="preview_image"
                                    src="{{ asset($arena->image) }}" alt="">
								</div>
							    <input type="file" name="image" id="image"
                                class="form-control border-blue-700 border-1 @error('image') is-invalid @enderror" required>
							</div>
						</div>

					</fieldset>
					<div class="text-right">
						<a href="{{ url('/arena')}}" class="btn btn-light">Kembali <i class="icon-undo"></i></a>
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
                        ownership: {
                            required: 'Mohon diisi.'
                        },
                        latitude: {
                            required: 'Mohon diisi.'
                        },
                        longitude: {
                            required: 'Mohon diisi.'
                        },
                        address: {
                            required: 'Mohon diisi.'
                        },
                        facilities: {
                            required: 'Mohon diisi.'
                        },
                        image: {
                            required: 'Mohon diisi.'
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
