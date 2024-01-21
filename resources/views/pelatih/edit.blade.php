@extends('layout')

@section('title', 'Pelatih')

@section('css')

@endsection

@section('content')
    <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Edit</span> - Pelatih</h4>
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
				<form id="submit-form" class="form-validate-jquery" action="{{url('pelatih/'.$pelatih->id)}}" method="post" enctype="multipart/form-data">
                    @method('PATCH')
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Atlet</legend>

                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Nama <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="name"
                                class="form-control border-blue-700 border-1 @error('name') is-invalid @enderror"
                                placeholder="Nama" required autofocus autocomplete="off" value="{{ $pelatih->name }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">NIK <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="nik"
                                class="form-control border-blue-700 border-1 @error('nik') is-invalid @enderror"
                                placeholder="NIK" required autofocus autocomplete="off" value="{{ $pelatih->nik }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">No KK <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="no_kk"
                                class="form-control border-blue-700 border-1 @error('no_kk') is-invalid @enderror"
                                placeholder="No KK" required autofocus autocomplete="off" value="{{ $pelatih->no_kk }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Gender <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<select name="gender" id="gender"
                                class="form-control form-control-select2" data-container-css-class="border-blue-700"
                                data-dropdown-css-class="border-blue-700" required>
                                    <option value="pria"  {{$pelatih->gender == 'pria' ? 'selected' : ''}}>Pria</option>
                                    <option value="wanita" {{$pelatih->gender == 'wanita' ? 'selected' : ''}}>Wanita</option>
                                </select>
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
                                    <option value="newCabor" class="font-weight-bold">Tambah Cabor</option>
                                    @foreach ($cabors as $cabor)
                                        <option value="{{$cabor->id}}"
                                            {{$pelatih->cabor_id == $cabor->id ? 'selected' : ''}}>{{$cabor->name}}</option>
                                    @endforeach
                                </select>
							</div>
                        </div>
                        <div class="form-group row" id="addCaborDiv" style="display: none">
							<label class="col-form-label col-lg-2">Tambah Cabor <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="addCabor" id="addCabor"
                                class="form-control border-blue-700 border-1 @error('addCabor') is-invalid @enderror"
                                placeholder="Tambah Cabor" autocomplete="off" value="{{ old('addCabor') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tempat Lahir <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="birth_place"
                                class="form-control border-blue-700 border-1 @error('birth_place') is-invalid @enderror"
                                placeholder="Tempat Lahir" required autocomplete="off" value="{{ $pelatih->birth_place }}">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal Lahir <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="date" name="birth_date"
                                class="form-control border-blue-700 border-1 @error('birth_date') is-invalid @enderror"
                                placeholder="Tanggal Lahir" required autocomplete="off" value="{{ $pelatih->birth_date }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Alamat <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
                                <textarea name="address" id="address"
                                class="form-control border-blue-700 border-1 @error('address') is-invalid @enderror"
                                placeholder="Alamat" required autocomplete="off" cols="30" rows="5">{{ $pelatih->address }}</textarea>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Telepon <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="string" name="phone"
                                class="form-control border-blue-700 border-1 @error('phone') is-invalid @enderror"
                                placeholder="Telepon" required autocomplete="off" value="{{ $pelatih->phone }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Provinsi <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="string" name="province"
                                class="form-control border-blue-700 border-1 @error('province') is-invalid @enderror"
                                placeholder="Provinsi" required autocomplete="off" value="{{ $pelatih->province }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Kota <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="string" name="city"
                                class="form-control border-blue-700 border-1 @error('city') is-invalid @enderror"
                                placeholder="Kota" required autocomplete="off" value="{{ $pelatih->city }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Asal Sekolah <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="string" name="school"
                                class="form-control border-blue-700 border-1 @error('school') is-invalid @enderror"
                                placeholder="Asal Sekolah" required autocomplete="off" value="{{ $pelatih->school }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Email <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="string" name="email"
                                class="form-control border-blue-700 border-1 @error('email') is-invalid @enderror"
                                placeholder="email" required autocomplete="off" value="{{ $pelatih->email }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">No Rekening <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="string" name="no_rek"
                                class="form-control border-blue-700 border-1 @error('no_rek') is-invalid @enderror"
                                placeholder="No Rekening" required autocomplete="off" value="{{ $pelatih->no_rek }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Nama Bank<span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="string" name="bank"
                                class="form-control border-blue-700 border-1 @error('bank') is-invalid @enderror"
                                placeholder="Nama Bank" required autocomplete="off" value="{{ $pelatih->bank }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Lini <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="string" name="lini"
                                class="form-control border-blue-700 border-1 @error('lini') is-invalid @enderror"
                                placeholder="Lini" required autocomplete="off" value="{{ $pelatih->lini }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Klasifikasi <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="string" name="klasifikasi"
                                class="form-control border-blue-700 border-1 @error('klasifikasi') is-invalid @enderror"
                                placeholder="Klasifikasi" required autocomplete="off" value="{{ $pelatih->klasifikasi }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Foto </label>
							<div class="col-lg-10">
								<div class="card-img-actions mb-3">
									<img class="card-img img-fluid" id="preview_image"
                                    src="{{asset($pelatih->image)}}" alt=""
                                    style="height:150px;width:150px;object-fit: contain;">
								</div>
							    <input type="file" name="image" id="image"
                                class="form-control border-blue-700 border-1 @error('image') is-invalid @enderror">
							</div>
						</div>

					</fieldset>
					<div class="text-right">
						<a href="{{ url('/pelatih')}}" class="btn btn-light">Kembali <i class="icon-undo"></i></a>
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
                        nik: {
                            required: 'Mohon diisi.'
                        },
                        no_kk: {
                            required: 'Mohon diisi.'
                        },
                        gender: {
                            required: 'Mohon pilih salah satu.'
                        },
                        birth_place: {
                            required: 'Mohon diisi.'
                        },
                        birth_date: {
                            required: 'Mohon diisi.'
                        },
                        address: {
                            required: 'Mohon diisi.'
                        },
                        phone: {
                            required: 'Mohon diisi.'
                        },
                        province: {
                            required: 'Mohon diisi.'
                        },
                        city: {
                            required: 'Mohon diisi.'
                        },
                        school: {
                            required: 'Mohon diisi.'
                        },
                        email: {
                            required: 'Mohon diisi.'
                        },
                        no_rek: {
                            required: 'Mohon diisi.'
                        },
                        bank: {
                            required: 'Mohon diisi.'
                        },
                        lini: {
                            required: 'Mohon diisi.'
                        },
                        phone: {
                            required: 'Mohon diisi.'
                        },
                        klasifikasi: {
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

        $('#cabor_id').on('change', function(){
            if($(this).val() == 'newCabor'){
                $('#addCaborDiv').show();
                $('#cabor_id').attr('required', false);
                $('#addCabor').attr('required', true);
            } else {
                $('#addCaborDiv').hide();
                $('#cabor_id').attr('required', true);
                $('#addCabor').attr('required', false);
            }
        })
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
