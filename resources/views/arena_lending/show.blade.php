@extends('layout')

@section('title', 'Peminjaman Arena')

@section('css')

@endsection

@section('content')
    <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Detail</span> - Peminjaman Arena</h4>
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
				<form id="submit-form" class="form-validate-jquery" action="{{url('peminjaman-arena/'.$arenaLending->id.'/update-status')}}" method="post">
                    @method('PATCH')
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Peminjaman Arena</legend>

                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Nomor Pengajuan</label>
                            <label class="col-form-label col-lg-10">{{$arenaLending->number}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal Pengajuan</label>
                            <label class="col-form-label col-lg-10">{{$arenaLending->application_date}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Nama Peminjam</label>
                            <label class="col-form-label col-lg-10">{{$arenaLending->name}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">NIK</label>
                            <label class="col-form-label col-lg-10">{{$arenaLending->nik}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Telepon</label>
                            <label class="col-form-label col-lg-10">{{$arenaLending->phone}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Email</label>
                            <label class="col-form-label col-lg-10">{{$arenaLending->email}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Alamat</label>
                            <label class="col-form-label col-lg-10">{{$arenaLending->address}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Arena</label>
                            <label class="col-form-label col-lg-10">{{$arenaLending->arena->name}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tujuan Peminjaman</label>
                            <label class="col-form-label col-lg-10">{{$arenaLending->purpose}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal Awal Peminjaman</label>
                            <label class="col-form-label col-lg-10">{{$arenaLending->start_date}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal Akhir Peminjaman</label>
                            <label class="col-form-label col-lg-10">{{$arenaLending->end_date}}</label>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Status</label>
                            <label class="col-form-label col-lg-10">
                                <select name="status_id" id="status_id"
                                class="form-control form-control-select2" data-container-css-class="border-blue-700"
                                data-dropdown-css-class="border-blue-700" required>
                                @foreach ($statuses as $status)
                                    <option value="{{$status->id}}" {{$arenaLending->status_id == $status->id ? 'selected' : ''}}>{{$status->name}}</option>
                                @endforeach
                                </select>
                            </label>
						</div>


					</fieldset>
					<div class="text-right">
						<a href="{{ url('/peminjaman-arena')}}" class="btn btn-light">Kembali <i class="icon-undo"></i></a>
						<button type="submit" class="btn btn-primary">Save <i class="icon-paperplane ml-2"></i></button>
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
