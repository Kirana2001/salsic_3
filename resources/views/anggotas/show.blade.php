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
				<form id="submit-form" class="form-validate-jquery" action="{{url('anggotas/'.$anggotas->id.'/update-status')}}" method="get">
					@csrf
					<fieldset class="mb-3">
						<legend class="text-uppercase font-size-sm font-weight-bold">Data Anggota</legend>

                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Nama<span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<label>{{ $anggotas->name }}</label>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Pemuda <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<select name="pemuda_id" id="pemuda_id"
                                class="form-control form-control-select2" data-container-css-class="border-blue-700"
                                data-dropdown-css-class="border-blue-700" disabled>
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
                                data-dropdown-css-class="border-blue-700" disabled>
                                    <option value="pria" {{ $anggotas->gender == 'pria' ? 'selected' : '' }}>Pria</option>
                                    <option value="wanita"  {{ $anggotas->gender == 'wanita' ? 'selected' : '' }}>Wanita</option>
                                </select>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">NIK <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<label>{{ $anggotas->nik }}</label>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tanggal Lahir <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<label>{{ $anggotas->tgl_lahir }}</label>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Tempat Lahir <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<label>{{ $anggotas->tmp_lahir }}</label>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Phone <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<label>{{ $anggotas->telp }}</label>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Alamat KTP <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
                                <textarea name="alamat_ktp" id="alamat_ktp"
                                class="form-control border-blue-700 border-1 @error('alamat_ktp') is-invalid @enderror"
                                placeholder="Alamat" disabled autocomplete="off" cols="30" rows="5">{{ $anggotas->alamat_ktp }}</textarea>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Alamat Domisili <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
                                <textarea name="alamat_domisili" id="alamat_domisili"
                                class="form-control border-blue-700 border-1 @error('alamat_domisili') is-invalid @enderror"
                                placeholder="Alamat" disabled autocomplete="off" cols="30" rows="5">{{ $anggotas->alamat_domisili }}</textarea>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Kelurahan <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<label>{{ $anggotas->kelurahan }}</label>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Kecamatan <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<label>{{ $anggotas->kecamatan }}</label>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Pekerjaan <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<label>{{ $anggotas->pekerjaan }}</label>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Email <span class="text-danger">*</span> </label>
							<div class="col-lg-10">
								<label>{{ $anggotas->email }}</label>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Instagram</label>
							<div class="col-lg-10">
								<label>{{ $anggotas->instagram }}</label>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Youtube</label>
							<div class="col-lg-10">
								<label>{{ $anggotas->youtube }}</label>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Twitter</label>
							<div class="col-lg-10">
								<label>{{ $anggotas->twitter }}</label>
							</div>
						</div>
                        <div class="form-group row">
							<label class="col-form-label col-lg-2">Facebook</label>
							<div class="col-lg-10">
								<label>{{ $anggotas->facebook }}</label>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-lg-2">Status</label>
                            <label class="col-form-label col-lg-10">
                                <select name="status_id" id="status_id"
                                class="form-control form-control-select2" data-container-css-class="border-blue-700"
                                data-dropdown-css-class="border-blue-700" required>
                                @foreach ($statuses as $status)
                                    <option value="{{$status->id}}" {{$anggotas->status_id == $status->id ? 'selected' : ''}}>{{$status->name}}</option>
                                @endforeach
                                </select>
                            </label>
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
