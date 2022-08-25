@extends('admin.ds_index')

@section('cssc')
<link href="{{asset('minton/assets/libs/jquery-toast-plugin/jquery.toast.min.css')}}" rel="stylesheet" type="text/css" />

<style>

</style>
@endsection
@section('breadcrumb')
<h4 class="page-title">Profil Admin</h4>
<div class="page-title-right">
    <ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
        <li class="breadcrumb-item active"><a href="javascript: void(0);">Profil Admin</a></li>
    </ol>
</div>
@endsection

@section('body')
<div class="row">
    <div class="col-md-12 ">
        <div id="listnotif">

        </div> <!-- end card-box-->
    </div> <!-- end col -->
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-8">
                        <h4 class="header-title">Profile</h4>
                        <p class="text-muted font-13 ">
                            Manajemen Akun </p>
                    </div>
                    <div class="col-sm-4">
                        <div class="float-sm-right">
                            <a id="save" class="btn btn-success mb-2"><i class="fa fa-plus mr-1"></i> Simpan</a>
                        </div>
                    </div><!-- end col-->
                </div>
                <!-- end row -->
                <!-- tes -->
                <form action="" id="upd_id" enctype="multipart/form-data">
                    <div class="row">
                        @csrf
                        <input type="hidden" name="idid" id="idid" value="{{Auth::guard('admin')->user()->id}}}}">
                        <div class="col-sm-12 col-md-4">
                            <img src="{{asset('/img/')}}/{{Auth::user()->gambar ?? 'none.jpg'}}" alt="user-img" title="{{Auth::user()->name}}" id="previewu" class="w-100">
                            <div class="d-none" id="infoimageu">tes</div>


                            <div class="custom-file">

                                <input type="file" class="custom-file-input" name="thumbnail" id="customFileu">
                                <label class="custom-file-label" for="customFileu">Gani Foto</label>
                            </div>

                        </div>
                        <div class="col-sm-12 col-md-8">
                            <table class="table table-centered w-100 dt-responsive" id="products-datatable2" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th><input type="text" class="form-control" name="name" value="{{Auth::guard('admin')->user()->name}}" id="name"></th>

                                    </tr>
                                    <tr>
                                        <th>Username</th>
                                        <th><input type="email" class="form-control" value="{{Auth::guard('admin')->user()->username}}" name="username" id="username"></th>

                                    </tr>
                                    <tr>
                                        <th>Password</th>
                                        <th> <input id="password" class="form-control" placeholder="Set Password Baru" type="password" name="password" required autocomplete="new-password"></th>

                                    </tr>
                                    <tr>
                                        <th>Re-Password</th>
                                        <th> <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="Konfirmasi Password" required></th>

                                    </tr>

                                </thead>

                            </table>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<button style="display: none;" id="toastr-three"></button><button style="display: none;" id="toastr-one"></button><button style="display: none;" id="delete-wrong"></button><button style="display: none;" id="delete-success"></button>




<div class="modal loader fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 48px">
            <span class="fa fa-spinner fa-spin fa-3x"></span>
        </div>
    </div>
</div>
@endsection
@push('js')

<script>
    var tabel;
    let url = window.location.origin;
    var editj;
    var tabel;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function bytesToSize(bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Byte';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }


    customFileu.onchange = evt => {
        const [file] = customFileu.files
        if (file) {
            previewu.src = URL.createObjectURL(file)
            $("#infoimageu").removeClass("d-none").html('File Size: ' + bytesToSize(customFileu.files[0].size))
        }
    }

    function sizeCheck(bytes) {
        if (bytes == 0) return '0 Byte';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2);
    }

    $("#save").on('click', function() {
        $("#upd_id").trigger('submit');

    });
    $("#upd_id").on('submit', function(id) {
        console.log(id);
        id.preventDefault();
        var data = new FormData(this);
        if ($("#customFileu").val() == '') {
            size = 100
        } else {
            size = sizeCheck($("#customFileu")[0].files[0].size);

        }

        if (sizeCheck(size) > 200) {

            Swal.fire(
                'Gagal!',
                'Ukuran File Tidak Boleh Melebihi 300 KB',
                'error'
            )
        } else {
            $.ajax({
                url: '{{route("admin.useredit")}}',
                data: data,
                type: "POST",
                contentType: false,
                processData: false,
                success: function(id) {
                    console.log(id);

                    if (id.status == 'error') {
                        var data = id.data;
                        var elem;
                        var result = Object.keys(data).map((key) => [data[key]]);
                        elem = '<div class="alert alert-danger alert-dismissible fade show pt-3" role="alert">';
                        elem += '   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button><ul>';
                        result.forEach(function(data) {
                            elem += '<li>' + data[0][0] + '</li>';
                        });

                        $("#listnotif").html(elem);
                    } else {
                        elem = '<div class="alert alert-success alert-dismissible fade show pt-3" role="alert">';
                        elem += '   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button><ul>';
                        elem += '<p>Berhasil Merubah Data</p>';

                        elem += '</ul></div>';

                        $("#listnotif").html(elem);

                    }
                }
            })
        }

    })
</script>

@endpush