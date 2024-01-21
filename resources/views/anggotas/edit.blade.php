@extends('layout')

@section('title', 'Anggota')

@section('css')

@endsection

@section('content')
    <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Edit</span> - Anggota</h4>
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
                <form id="submit-form" class="form-validate-jquery" action="{{url('anggotas/'.$anggotas->id)}}" method="post" enctype="multipart/form-data">
                    @method('PATCH')
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Anggota</legend>

                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Nama<span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="name"
                                class="form-control border-blue-700 border-1 @error('name') is-invalid @enderror"
                                placeholder="Nama" required autofocus autocomplete="off" value="{{ $anggotas->name }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Pemuda <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<select name="pemuda_id" id="pemuda_id"
                                class="form-control form-control-select2" data-container-css-class="border-blue-700"
                                data-dropdown-css-class="border-blue-700" required>
                                    @foreach ($pemudas as $pemuda)
                                        <option value="{{$pemuda->id}}" {{ $pemuda->id == $anggotas->pemuda_id ? 'selected' : '' }} >{{$pemuda->organization_name}}</option>
                                    @endforeach
                                </select>
							</div>
                        </div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Gender <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<select name="gender" id="gender"
                                class="form-control form-control-select2" data-container-css-class="border-blue-700"
                                data-dropdown-css-class="border-blue-700" required>
                                    <option value="pria" {{ $anggotas->gender == 'pria' ? 'selected' : '' }}>Pria</option>
                                    <option value="wanita"  {{ $anggotas->gender == 'wanita' ? 'selected' : '' }}>Wanita</option>
                                </select>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">NIK <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="nik"
                                class="form-control border-blue-700 border-1 @error('nik') is-invalid @enderror"
                                placeholder="NIK" required autocomplete="off" value="{{ $anggotas->nik }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal Lahir <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="date" name="tgl_lahir"
                                class="form-control border-blue-700 border-1 @error('tgl_lahir') is-invalid @enderror"
                                placeholder="Tanggal Lahir" required autocomplete="off" value="{{ $anggotas->tgl_lahir }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tempat Lahir <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="tmp_lahir"
                                class="form-control border-blue-700 border-1 @error('tmp_lahir') is-invalid @enderror"
                                placeholder="Tempat Lahir" required autocomplete="off" value="{{ $anggotas->tmp_lahir }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Phone <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="telp"
                                class="form-control border-blue-700 border-1 @error('telp') is-invalid @enderror"
                                placeholder="Telpon" required autocomplete="off" value="{{ $anggotas->telp }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Alamat KTP <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
                                <textarea name="alamat_ktp" id="alamat_ktp"
                                class="form-control border-blue-700 border-1 @error('alamat_ktp') is-invalid @enderror"
                                placeholder="Alamat" required autocomplete="off" cols="30" rows="5">{{ $anggotas->alamat_ktp }}</textarea>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Alamat Domisili <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
                                <textarea name="alamat_domisili" id="alamat_domisili"
                                class="form-control border-blue-700 border-1 @error('alamat_domisili') is-invalid @enderror"
                                placeholder="Alamat" required autocomplete="off" cols="30" rows="5">{{ $anggotas->alamat_domisili }}</textarea>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Kelurahan <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="kelurahan"
                                class="form-control border-blue-700 border-1 @error('kelurahan') is-invalid @enderror"
                                placeholder="Kelurahan" required autocomplete="off" value="{{ $anggotas->kelurahan }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Kecamatan <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="kecamatan"
                                class="form-control border-blue-700 border-1 @error('kecamatan') is-invalid @enderror"
                                placeholder="Kecamatan" required autocomplete="off" value="{{ $anggotas->kecamatan }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Pekerjaan <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="pekerjaan"
                                class="form-control border-blue-700 border-1 @error('pekerjaan') is-invalid @enderror"
                                placeholder="Pekerjaan" required autocomplete="off" value="{{ $anggotas->pekerjaan }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Email <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="email"
                                class="form-control border-blue-700 border-1 @error('email') is-invalid @enderror"
                                placeholder="Email" required autocomplete="off" value="{{ $anggotas->email }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Instagram</label>
							<div class="col-lg-10">
								<input type="text" name="instagram"
                                class="form-control border-blue-700 border-1 @error('instagram') is-invalid @enderror"
                                placeholder="Instagram"autocomplete="off" value="{{ $anggotas->instagram }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Youtube</label>
							<div class="col-lg-10">
								<input type="text" name="youtube"
                                class="form-control border-blue-700 border-1 @error('youtube') is-invalid @enderror"
                                placeholder="Youtube"autocomplete="off" value="{{ $anggotas->youtube }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Twitter</label>
							<div class="col-lg-10">
								<input type="text" name="twitter"
                                class="form-control border-blue-700 border-1 @error('twitter') is-invalid @enderror"
                                placeholder="Twitter"autocomplete="off" value="{{ $anggotas->twitter }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Facebook</label>
							<div class="col-lg-10">
								<input type="text" name="facebook"
                                class="form-control border-blue-700 border-1 @error('facebook') is-invalid @enderror"
                                placeholder="Facebook"autocomplete="off" value="{{ $anggotas->facebook }}">
							</div>
						</div>

					</fieldset>
					<div class="text-right">
						<a href="{{ url('/anggotas')}}" class="btn btn-light">Kembali <i class="icon-undo"></i></a>
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
                        tgl_lahir: {
                            required: 'Mohon diisi.'
                        },
                        tmp_lahir: {
                            required: 'Mohon diisi.'
                        },
                        alamat_ktp: {
                            required: 'Mohon diisi.'
                        },
                        kecamatan: {
                            required: 'Mohon diisi.'
                        },
                        kelurahan: {
                            required: 'Mohon diisi.'
                        },
                        alamat_domisili: {
                            required: 'Mohon diisi.'
                        },
                        pekerjaan: {
                            required: 'Mohon diisi.'
                        },
                        telp: {
                            required: 'Mohon diisi.'
                        },
                        email: {
                            required: 'Mohon diisi.'
                        },
                        pemuda_id: {
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
