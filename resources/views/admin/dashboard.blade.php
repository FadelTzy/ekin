@extends('admin.ds_index')

@section('breadcrumb')
<h4 class="page-title">Dashboard</h4>
<div class="page-title-right">
    <ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="javascript: void(0);">Menu</a></li>
        <li class="breadcrumb-item active"><a href="javascript: void(0);">Dashboard</a></li>
    </ol>
</div>
@endsection


@section('body')
<div class="row">


</div>
<!-- end row -->



<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="modal-title">Selamat Datang Di Aplikasi E - Kinerja UNM </div>
                <div>Admin</div>

            </div>

        </div> <!-- end card-->
    </div> <!-- end col -->
</div>

<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="text-muted font-weight-normal mt-0 text-truncate" title="Jumlah Konten">Total Pegawai</h5>
                        <h3 class="my-2 py-1"><span data-plugin="counterup">{{$tp}}</span></h3>

                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-soft-primary rounded">
                            <i class="fas fa-newspaper font-20 text-primary"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="text-muted font-weight-normal mt-0 text-truncate" title="Total Admin">Rencana SKP </h5>
                        <h3 class="my-2 py-1"><span data-plugin="counterup">10</span></h3>

                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-soft-primary rounded">
                            <i class="fas fa-users-cog font-20 text-primary"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="text-muted font-weight-normal mt-0 text-truncate" title="Pesan">Realisasi SKP</h5>
                        <h3 class="my-2 py-1"><span data-plugin="counterup">1</span></h3>

                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-soft-primary rounded">
                            <i class="fas fa-paper-plane font-20 text-primary"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="text-muted font-weight-normal mt-0 text-truncate" title="Pengunjung">Pegawai Aktif</h5>
                        <h3 class="my-2 py-1"><span data-plugin="counterup">2</span></h3>

                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-soft-primary rounded">
                            <i class="fas fa-users font-20 text-primary"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end col -->
</div>
<!-- end row -->
@endsection