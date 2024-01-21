@extends('layout')

@section('title', 'Pemuda')

@section('css')

@endsection

@section('content')
    <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Tambah</span> - Pemuda</h4>
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
				<form id="submit-form" class="form-validate-jquery" action="{{url('/pemudas')}}" method="post" enctype="multipart/form-data">
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Pemuda</legend>

                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Organisasi<span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="organization_name"
                                class="form-control border-blue-700 border-1 @error('organization_name') is-invalid @enderror"
                                placeholder="Organisasi" required autofocus autocomplete="off" value="{{ old('organization_name') }}">
							</div>
						</div>
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
							<label class="col-form-label col-lg-2">Pendiri <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="founder"
                                class="form-control border-blue-700 border-1 @error('founder') is-invalid @enderror"
                                placeholder="Pendiri" required autocomplete="off" value="{{ old('founder') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Ketua <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="leader"
                                class="form-control border-blue-700 border-1 @error('leader') is-invalid @enderror"
                                placeholder="Ketua" required autocomplete="off" value="{{ old('leader') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Sekretaris <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="secretary"
                                class="form-control border-blue-700 border-1 @error('secretary') is-invalid @enderror"
                                placeholder="Sekretaris" required autocomplete="off" value="{{ old('secretary') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Bendahara <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="treasurer"
                                class="form-control border-blue-700 border-1 @error('treasurer') is-invalid @enderror"
                                placeholder="Bendahara" required autocomplete="off" value="{{ old('treasurer') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Phone <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="phone"
                                class="form-control border-blue-700 border-1 @error('phone') is-invalid @enderror"
                                placeholder="Phone" required autocomplete="off" value="{{ old('phone') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Alamat <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
                                <textarea name="address" id="address"
                                class="form-control border-blue-700 border-1 @error('address') is-invalid @enderror"
                                placeholder="Alamat" required autocomplete="off" cols="30" rows="5">{{ old('address') }}</textarea>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Deskripsi <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
                                <textarea name="description" id="description"
                                class="form-control border-blue-700 border-1 @error('description') is-invalid @enderror"
                                placeholder="Deskripsi" required autocomplete="off" cols="30" rows="5">{{ old('description') }}</textarea>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Total Anggota Pria <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="number" name="male_member"
                                class="form-control border-blue-700 border-1 @error('male_member') is-invalid @enderror"
                                placeholder="Total Anggota Pria" required autocomplete="off" value="{{ old('male_member') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Total Anggota Wanita <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="number" name="female_member"
                                class="form-control border-blue-700 border-1 @error('female_member') is-invalid @enderror"
                                placeholder="Total Angoota Wanita" required autocomplete="off" value="{{ old('female_member') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Dokumen <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
							    <input type="file" name="document[]" id="document"
                                class="form-control border-blue-700 border-1 @error('document') is-invalid @enderror" multiple="multiple" required>
							</div>
						</div>

					</fieldset>
					<div class="text-right">
						<a href="{{ url('/pemudas')}}" class="btn btn-light">Kembali <i class="icon-undo"></i></a>
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
                        organization_name: {
                            required: 'Mohon diisi.'
                        },
                        founding_date: {
                            required: 'Mohon diisi.'
                        },
                        founder: {
                            required: 'Mohon diisi.'
                        },
                        leader: {
                            required: 'Mohon diisi.'
                        },
                        nik: {
                            required: 'Mohon diisi.'
                        },
                        phone: {
                            required: 'Mohon diisi.'
                        },
                        address: {
                            required: 'Mohon diisi.'
                        },
                        village: {
                            required: 'Mohon diisi.'
                        },
                        subdistrict: {
                            required: 'Mohon diisi.'
                        },
                        district: {
                            required: 'Mohon diisi.'
                        },
                        city: {
                            required: 'Mohon diisi.'
                        },
                        province: {
                            required: 'Mohon diisi.'
                        },
                        all_member: {
                            required: 'Mohon diisi.'
                        },
                        male_member: {
                            required: 'Mohon diisi.'
                        },
                        female_member: {
                            required: 'Mohon diisi.'
                        },
                        document: {
                            required: 'Mohon diisi.'
                        },
                        image: {
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
