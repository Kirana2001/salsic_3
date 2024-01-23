@extends('layout')

@section('title', 'Dashboard')
    
@section('content')
    <!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><span class="font-weight-semibold">Dashboard</span></h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>
		</div>
	</div>
	<!-- /page header -->

    <div class="content">
        <div class="card pt-3 pl-3 pr-3">
			{{-- <div class="card-header header-elements-inline">
				<a href="{{url('/atlets/create')}}"><button type="button" class="btn btn-success rounded-round"><i class="icon-add mr-2"></i> Tambah</button></a>
			</div> --}}

            <div class="row">
                <div class="col">
                    <div class="card bg-primary-400 mb-4 mb-xl-3">
                        <div class="card-body">
                          <div class="row">
                            <div class="col">
                              <h5 class="card-title text-uppercase text-white mb-0">Arena</h5>
                              <span class="h2 font-weight-bold mb-0">{{ $arena }}</span>
                            </div>
                            <div class="col-auto">
                                <i class="icon-location4 mr-3 icon-3x"></i>
                            </div>
                          </div>
                          <p class="mt-3 mb-0 text-white text-sm">
                            <span class="text-nowrap">Penyewaan: {{ $sewa }}</span>
                          </p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-teal-400 mb-4 mb-xl-3">
                        <div class="card-body">
                          <div class="row">
                            <div class="col">
                              <h5 class="card-title text-uppercase text-white mb-0">Anggota Pemuda</h5>
                              <span class="h2 font-weight-bold mb-0">{{ $anggota_all }}</span>
                            </div>
                            <div class="col-auto">
                                <i class="icon-users4 mr-3 icon-3x"></i>
                            </div>
                          </div>
                          <p class="mt-3 mb-0 text-white text-sm">
                            <span class="text-nowrap">Pria: {{ $pria }}</span>
                            <span> | </span>
                            <span class="text-nowrap">Wanita: {{ $wanita }}</span>
                          </p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-violet-400 mb-4 mb-xl-3">
                        <div class="card-body">
                          <div class="row">
                            <div class="col">
                              <h5 class="card-title text-uppercase text-white mb-0">Organisasi</h5>
                              <span class="h2 font-weight-bold mb-0">{{ $pemuda }}</span>
                            </div>
                            <div class="col-auto">
                                <i class="icon-collaboration mr-3 icon-3x"></i>
                            </div>
                          </div>
                          <p class="mt-3 mb-0 text-white text-sm">
                            <span class="text-nowrap">Total: {{ $pemuda_pria + $pemuda_wanita }} anggota</span>
                            <span> | </span>
                            <span class="text-nowrap">Pria: {{ $pemuda_pria }}</span>
                            <span> | </span>
                            <span class="text-nowrap">Wanita: {{ $pemuda_wanita }}</span>
                          </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card bg-danger-400 mb-4 mb-xl-3">
                        <div class="card-body">
                          <div class="row">
                            <div class="col">
                              <h5 class="card-title text-uppercase text-white mb-0">Atlet</h5>
                              <span class="h2 font-weight-bold mb-0">{{ $atlet }}</span>
                            </div>
                            <div class="col-auto">
                                <i class="icon-accessibility mr-3 icon-3x"></i>
                            </div>
                          </div>
                          <p class="mt-3 mb-0 text-white text-sm">
                            <span class="text-nowrap">Pria: {{ $atlet_pria }}</span>
                            <span> | </span>
                            <span class="text-nowrap">Wanita: {{ $atlet_wanita }}</span>
                          </p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-indigo-400 mb-4 mb-xl-3">
                        <div class="card-body">
                          <div class="row">
                            <div class="col">
                              <h5 class="card-title text-uppercase text-white mb-0">Pelatih</h5>
                              <span class="h2 font-weight-bold mb-0">{{ $pelatih }}</span>
                            </div>
                            <div class="col-auto">
                                <i class="icon-brain mr-3 icon-3x"></i>
                            </div>
                          </div>
                          <p class="mt-3 mb-0 text-white text-sm">
                            <span class="text-nowrap">Pria: {{ $pelatih_pria }}</span>
                            <span> | </span>
                            <span class="text-nowrap">Wanita: {{ $pelatih_wanita }}</span>
                          </p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bg-grey-400 mb-4 mb-xl-3">
                        <div class="card-body">
                          <div class="row">
                            <div class="col">
                              <h5 class="card-title text-uppercase text-white mb-0">Wasit</h5>
                              <span class="h2 font-weight-bold mb-0">{{ $wasit }}</span>
                            </div>
                            <div class="col-auto">
                                <i class="icon-clipboard4 mr-3 icon-3x"></i>
                            </div>
                          </div>
                          <p class="mt-3 mb-0 text-white text-sm">
                            <span class="text-nowrap">Pria: {{ $wasit_pria }}</span>
                            <span> | </span>
                            <span class="text-nowrap">Wanita: {{ $wasit_wanita }}</span>
                          </p>
                        </div>
                    </div>
                </div>
            </div>
		</div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $( document ).ready(function() {
    
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