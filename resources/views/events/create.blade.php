@extends('layout')

@section('title', 'Evebt')

@section('css')
<style>
	.summernote ol, ul{
		list-style: disc !important;
		list-style-position: inside;
	}
</style>
@endsection

@section('content')
    <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Tambah</span> - Event</h4>
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
				<form id="submit-form" class="form-validate-jquery" action="{{url('/events')}}" method="post" enctype="multipart/form-data">
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Event</legend>

                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Event <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="event_name"
                                class="form-control border-blue-700 border-1 @error('event_name') is-invalid @enderror"
                                placeholder="Nama Event" required autofocus autocomplete="off" value="{{ old('event_name') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal Mulai <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="date" name="start_date" value="{{date('Y-m-d')}}"
                                class="form-control border-blue-700 border-1 @error('start_date') is-invalid @enderror"
                                placeholder="Tanggal Mulai" required autofocus autocomplete="off" value="{{ old('start_date') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal Selesai <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="date" name="end_date" value="{{date('Y-m-d')}}"
                                class="form-control border-blue-700 border-1 @error('end_date') is-invalid @enderror"
                                placeholder="Tanggal Selesai" required autofocus autocomplete="off" value="{{ old('end_date') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Jam Mulai <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="time" name="start_time" value="{{ date('H:i') }}"
                                class="form-control border-blue-700 border-1 @error('start_time') is-invalid @enderror"
                                placeholder="Jam Mulai" required autofocus autocomplete="off" value="{{ old('start_time') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Jam Selesai <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="time" name="end_time" value="{{ date('H:i') }}"
                                class="form-control border-blue-700 border-1 @error('end_time') is-invalid @enderror"
                                placeholder="Jam Selesai" required autofocus autocomplete="off" value="{{ old('end_time') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Judul <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<input type="text" name="header"
                                class="form-control border-blue-700 border-1 @error('header') is-invalid @enderror"
                                placeholder="Judul" required autofocus autocomplete="off" value="{{ old('header') }}">
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Deskripsi <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
                                <textarea name="description"
                                class="summernote form-control border-blue-700 border-1 @error('description') is-invalid @enderror"
                                placeholder="Deskripsi" required autocomplete="off" cols="30" rows="20">{{ old('description') }}</textarea>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Gambar <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<div class="card-img-actions mb-3">
									<img class="card-img img-fluid" id="preview_image"
                                    src="{{asset('global_assets/images/placeholders/cover.jpg')}}" alt="">
								</div>
							    <input type="file" name="image" id="image"
                                class="form-control border-blue-700 border-1 @error('image') is-invalid @enderror" required>
							</div>
						</div>

					</fieldset>
					<div class="text-right">
						<a href="{{ url('/articles')}}" class="btn btn-light">Kembali <i class="icon-undo"></i></a>
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
    <script src="{{asset('global_assets/js/plugins/editors/summernote/summernote.min.js')}}"></script>
    <script src="{{asset('global_assets/js/demo_pages/editor_summernote.js')}}"></script>

    <script type="text/javascript">
        var Summernote = function() {
            var _componentSummernote = function() {
                if (!$().summernote) {
                    console.warn('Warning - summernote.min.js is not loaded.');
                    return;
                }

                // Basic examples
                // ------------------------------

                // Default initialization
                $('.summernote').summernote({
                    toolbar: [
                    ['para', ['ul', 'ol', 'paragraph']],
                    ],
                    height: 100,
                    callbacks: {
                        onPaste: function (e) {
                        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');

                        e.preventDefault();

                        setTimeout( function(){
                            document.execCommand( 'insertText', false, bufferText );
                        }, 10 );
                        }
                    }
                });

                // Control editor height
                $('.summernote-height').summernote({
                    height: 400
                });


                // // Air mode
                // $('.summernote-airmode').summernote({
                // 	airMode: true
                // });


                // // // Click to edit
                // // // ------------------------------

                // // // Edit
                // // $('#edit').on('click', function() {
                // // 	$('.click2edit').summernote({focus: true});
                // // })

                // // // Save
                // // $('#save').on('click', function() {
                // // 	var aHTML = $('.click2edit').summernote('code');
                // // 	$('.click2edit').summernote('destroy');
                // // });
            };

            // Uniform
            var _componentUniform = function() {
                if (!$().uniform) {
                    console.warn('Warning - uniform.min.js is not loaded.');
                    return;
                }

                // Styled file input
                $('.note-image-input').uniform({
                    fileButtonClass: 'action btn bg-warning-400'
                });
            };


            //
            // Return objects assigned to module
            //

            return {
                init: function() {
                    _componentSummernote();
                    _componentUniform();
                }
            }
        }();
    </script>
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
                        event_name: {
                            required: 'Mohon diisi.'
                        },
                        start_date: {
                            required: 'Mohon diisi.'
                        },
                        end_date: {
                            required: 'Mohon diisi.'
                        },
                        start_time: {
                            required: 'Mohon diisi.'
                        },
                        end_time: {
                            required: 'Mohon diisi.'
                        },
                        header: {
                            required: 'Mohon diisi.'
                        },
                        description: {
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
