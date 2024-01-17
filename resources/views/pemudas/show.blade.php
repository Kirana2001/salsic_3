@extends('layout')

@section('title', 'Pemuda')

@section('css')

@endsection

@section('content')
    <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Detail</span> - Pemuda</h4>
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
				<form id="submit-form" class="form-validate-jquery" action="{{url('pemudas/'.$pemudas->id.'/update-status')}}" method="get">
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Pemuda</legend>

                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Foto</label>
                            <label class="col-form-label col-lg-2">
                                <img class="card-img img-fluid" id="preview_image"
                                src="{{asset($pemudas->image)}}" alt="" style="height:150px;width:150px;object-fit: contain;">
                            </label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Organisasi</label>
                            <label class="col-form-label col-lg-10">{{$pemudas->organization_name}}</label>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Cabor</label>
							<label class="col-form-label col-lg-10">{{$pemudas->cabor->name}}</label>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal Didirikan</label>
							<label class="col-form-label col-lg-10">{{$pemudas->founding_date}}</label>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Pendiri</label>
							<label class="col-form-label col-lg-10">{{$pemudas->founder}}</label>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Ketua</label>
							<label class="col-form-label col-lg-10">{{$pemudas->leader}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">NIK</label>
                            <label class="col-form-label col-lg-10">{{$pemudas->nik}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Telepon</label>
                            <label class="col-form-label col-lg-10">{{$pemudas->phone}}</label>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Desa</label>
                            <label class="col-form-label col-lg-10">{{$pemudas->village}}</label>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Kelurahan</label>
                            <label class="col-form-label col-lg-10">{{$pemudas->subdistrict}}</label>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Kecamatan</label>
                            <label class="col-form-label col-lg-10">{{$pemudas->district}}</label>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Kota</label>
                            <label class="col-form-label col-lg-10">{{$pemudas->city}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Provinsi</label>
                            <label class="col-form-label col-lg-10">{{$pemudas->province}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Total Anggota</label>
                            <label class="col-form-label col-lg-10">{{$pemudas->all_member}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Anggota Pria</label>
                            <label class="col-form-label col-lg-10">{{$pemudas->male_member}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Anggota Wanita</label>
                            <label class="col-form-label col-lg-10">{{$pemudas->female_member}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Dokumen</label>
							<div style="text-align:center">
								<a href="{{ url($pemudas->document)}}" target="_blank"><button type="button" class="btn btn-warning btn-icon"><i class="icon-eye" title="File"></i></button></a>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Status</label>
                            <label class="col-form-label col-lg-10">
                                <select name="status_id" id="status_id"
                                class="form-control form-control-select2" data-container-css-class="border-blue-700"
                                data-dropdown-css-class="border-blue-700" required>
                                @foreach ($statuses as $status)
                                    <option value="{{$status->id}}" {{$pemudas->status_id == $status->id ? 'selected' : ''}}>{{$status->name}}</option>
                                @endforeach
                                </select>
                            </label>
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
