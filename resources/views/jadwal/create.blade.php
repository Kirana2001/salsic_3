@extends('layout')

@section('title', 'Jadwal')

@section('css')

@endsection

@section('content')
    <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Tambah</span> - Jadwal</h4>
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
				<form id="submit-form" class="form-validate-jquery" action="{{url('/jadwal')}}" method="post" enctype="multipart/form-data">
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Jadwal</legend>

                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Cabor <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<select name="cabor_id" id="cabor_id"
                                class="form-control form-control-select2" data-container-css-class="border-blue-700"
                                data-dropdown-css-class="border-blue-700" required>
                                    @if ($cabors->count() < 1)
                                        <option value="">-- Pilih Cabor --</option>
                                    @endif
                                    @foreach ($cabors as $cabor)
                                        <option value="{{$cabor->id}}">{{$cabor->name}}</option>
                                    @endforeach
                                </select>
							</div>
                        </div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tim 1 <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="tim_a"
                                class="form-control border-blue-700 border-1 @error('tim_a') is-invalid @enderror"
                                placeholder="Nama Tim 1" required autofocus autocomplete="off" value="{{ old('tim_a') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tim 2 <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="tim_b"
                                class="form-control border-blue-700 border-1 @error('tim_b') is-invalid @enderror"
                                placeholder="Nama Tim 2" required autofocus autocomplete="off" value="{{ old('tim_b') }}">
							</div>
						</div>
                        
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tempat <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="place"
                                class="form-control border-blue-700 border-1 @error('place') is-invalid @enderror"
                                placeholder="Tempat" required autocomplete="off" value="{{ old('place') }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal Permainan <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="date" name="date" value="{{ date('Y-m-d') }}"
                                class="form-control border-blue-700 border-1 @error('date') is-invalid @enderror"
                                placeholder="Tanggal Permainan" required autocomplete="off" value="{{ old('date') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Waktu <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
                                <input type="time" name="time" id="time" value="{{ date('H:i') }}"
                                class="form-control border-blue-700 border-1 @error('address') is-invalid @enderror"
                                placeholder="Waktu Mulai" required autocomplete="off" cols="30" rows="5" value="{{ old('time') }}">
							</div>
						</div>

					</fieldset>
					<div class="text-right">
						<a href="{{ url('/jadwal')}}" class="btn btn-light">Kembali <i class="icon-undo"></i></a>
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
                        tim_a: {
                            required: 'Mohon diisi.'
                        },
                        tim_b: {
                            required: 'Mohon diisi.'
                        },
                        date: {
                            required: 'Mohon diisi.'
                        },
                        time: {
                            required: 'Mohon diisi.'
                        },
                        place: {
                            required: 'Mohon diisi.'
                        },
                        cabor_id: {
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
