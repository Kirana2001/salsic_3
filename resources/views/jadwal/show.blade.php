@extends('layout')

@section('title', 'Jadwal')

@section('css')

@endsection

@section('content')
    <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Detail</span> - Jadwal</h4>
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
				<form id="submit-form" class="form-validate-jquery" action="{{url('jadwal/'.$jadwal->id.'/update-status')}}" method="get">
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Jadwal</legend>

						<div class="form-group row">
							<label class="col-form-label col-lg-2">Foto</label>
                            <label class="col-form-label col-lg-2">
                                <img class="card-img img-fluid" id="preview_image"
                                src="{{asset($jadwal->image)}}" alt="" style="height:150px;width:150px;object-fit: contain;">
                            </label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Cabor <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<select name="cabor_id" id="cabor_id"
                                class="form-control form-control-select2" data-container-css-class="border-blue-700"
                                data-dropdown-css-class="border-blue-700" disabled>
                                    @if ($cabors->count() < 1)
                                        <option value="">-- Pilih Cabor --</option>
                                    @endif
                                    @foreach ($cabors as $cabor)
                                        <option value="{{$cabor->id}}"{{$jadwal->cabor_id == $cabor->id ? 'selected' : ''}}>{{$cabor->name}}</option>
                                    @endforeach
                                </select>
							</div>
                        </div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tim 1 <span class="text-danger">*</span> </label>
							<label class="col-form-label col-lg-10">{{$jadwal->tim_a}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tim 2 <span class="text-danger">*</span> </label>
							<label class="col-form-label col-lg-10">{{$jadwal->tim_b}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Skor 1 <span class="text-danger">*</span> </label>
							<label class="col-form-label col-lg-10">{{$jadwal->skor_a}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Skor 2 <span class="text-danger">*</span> </label>
							<label class="col-form-label col-lg-10">{{$jadwal->skor_b}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tempat <span class="text-danger">*</span> </label>
							<label class="col-form-label col-lg-10">{{$jadwal->place}}</label>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal Permainan <span class="text-danger">*</span> </label>
							<label class="col-form-label col-lg-10">{{$jadwal->date}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Waktu <span class="text-danger">*</span> </label>
							<label class="col-form-label col-lg-10">{{$jadwal->time}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Status</label>
                            <label class="col-form-label col-lg-10">
                                <select name="status_id" id="status_id"
                                class="form-control form-control-select2" data-container-css-class="border-blue-700"
                                data-dropdown-css-class="border-blue-700" required>
                                @foreach ($statuses as $status)
                                    <option value="{{$status->id}}" {{$jadwal->status_id == $status->id ? 'selected' : ''}}>{{$status->name}}</option>
                                @endforeach
                                </select>
                            </label>
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
    <script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>

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
