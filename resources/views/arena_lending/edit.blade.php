@extends('layout')

@section('title', 'Peminjaman Arena')

@section('css')

@endsection

@section('content')
    <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Edit</span> - Peminjaman Arena</h4>
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
				<form id="submit-form" class="form-validate-jquery" action="{{url('peminjaman-arena/'.$arenaLending->id)}}" method="post">
                    @method('PATCH')
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Peminjaman Arena</legend>

                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal Pengajuan <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="date" name="application_date"
                                class="form-control border-blue-700 border-1 @error('application_date') is-invalid @enderror"
                                placeholder="Tanggal Pengajuan" required autofocus autocomplete="off" value="{{ $arenaLending->application_date }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Nama Peminjam <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="name"
                                class="form-control border-blue-700 border-1 @error('name') is-invalid @enderror"
                                placeholder="Nama Peminjam" required autofocus autocomplete="off" value="{{ $arenaLending->name }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">NIK <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="nik"
                                class="form-control border-blue-700 border-1 @error('nik') is-invalid @enderror"
                                placeholder="NIK" required autofocus autocomplete="off" value="{{ $arenaLending->nik }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Telepon <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="phone"
                                class="form-control border-blue-700 border-1 @error('phone') is-invalid @enderror"
                                placeholder="Telepon" required autofocus autocomplete="off" value="{{ $arenaLending->phone }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Email <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="email"
                                class="form-control border-blue-700 border-1 @error('email') is-invalid @enderror"
                                placeholder="Email" required autofocus autocomplete="off" value="{{ $arenaLending->email }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Alamat <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
                                <textarea name="address" id="address"
                                class="form-control border-blue-700 border-1 @error('address') is-invalid @enderror"
                                placeholder="Alamat" required autocomplete="off" cols="30" rows="5">{{ $arenaLending->address }}</textarea>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Arena <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
                                <select name="arena_id" id="arena_id"
                                class="form-control form-control-select2" data-container-css-class="border-blue-700"
                                data-dropdown-css-class="border-blue-700" required>
                                @if ($arenas->count() < 1)
                                    <option value="">-- Pilih Arena --</option>
                                @else
                                    @foreach ($arenas as $arena)
                                        <option value="{{$arena->id}}" {{$arenaLending->arena_id == $arena->id ? 'selected' : ''}}>{{$arena->name}}</option>
                                    @endforeach
                                @endif
                                </select>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tujuan Peminjaman <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="purpose"
                                class="form-control border-blue-700 border-1 @error('purpose') is-invalid @enderror"
                                placeholder="Tujuan Peminjaman" required autofocus autocomplete="off" value="{{ $arenaLending->purpose }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal Awal Peminjaman <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="date" name="start_date"
                                class="form-control border-blue-700 border-1 @error('start_date') is-invalid @enderror"
                                placeholder="Tanggal Awal Peminjaman" required autofocus autocomplete="off" value="{{ $arenaLending->start_date }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal Akhir Peminjaman <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="date" name="end_date"
                                class="form-control border-blue-700 border-1 @error('end_date') is-invalid @enderror"
                                placeholder="Tanggal Akhir Peminjaman" required autofocus autocomplete="off" value="{{ $arenaLending->end_date }}">
							</div>
						</div>

					</fieldset>
					<div class="text-right">
						<a href="{{ url('/peminjaman-arena')}}" class="btn btn-light">Kembali <i class="icon-undo"></i></a>
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
                        application_date: {
                            required: 'Mohon pilih satu.'
                        },
                        name: {
                            required: 'Mohon diisi.'
                        },
                        nik: {
                            required: 'Mohon diisi.'
                        },
                        phone: {
                            required: 'Mohon diisi.'
                        },
                        email: {
                            required: 'Mohon diisi.'
                        },
                        arena_id: {
                            required: 'Mohon pilih satu.'
                        },
                        purpose: {
                            required: 'Mohon diisi.'
                        },
                        start_date: {
                            required: 'Mohon diisi.'
                        },
                        end_date: {
                            required: 'Mohon diisi.'
                        }
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
