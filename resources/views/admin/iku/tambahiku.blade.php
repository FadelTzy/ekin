@extends('admin.ds_index')

@section('cssc')
<style>
    .bd-example-modal-lg .modal-dialog {
        display: table;
        position: relative;
        margin: 0 auto;
        top: calc(50% - 24px);
    }

    .bd-example-modal-lg .modal-dialog .modal-content {
        background-color: transparent;
        border: none;
    }
</style>
@endsection
@section('breadcrumb')
<h4 class="page-title">Tupoksi {{$iku->jabatan->jabatan}} - {{$iku->unit->unit}} </h4>
<div class="page-title-right">
    <ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="javascript: void(0);">Data Master</a></li>
        <li class="breadcrumb-item active"><a href="javascript: void(0);">IKU</a></li>
        <li class="breadcrumb-item active"><a href="javascript: void(0);">{{$iku->jabatan->jabatan}}</a></li>

    </ol>
</div>
@endsection

@section('body')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-8">
                        <h4 class="header-title">Basic Data Table</h4>
                        <p class="text-muted font-13 ">
                            DataTables has most features enabled by default, so all you need to do to use it with your own tables

                        </p>
                    </div>
                    <div class="col-sm-4">
                        <div class="float-sm-right">

                            <button class="btn btn-success mb-2" name="add" id="add"><i class="mdi mdi-plus-circle mr-1"></i> Tambah Data</button>

                        </div>
                    </div><!-- end col-->
                </div>
                <!-- end row -->
                <!-- tes -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <form name="add_name" id="add_name">
                                <input type="hidden" value="{{$iku->id}}" name="id">
                                <div class="table-responsive">
                                    <table class="table " id="dynamic_field">

                                        <tr>
                                        </tr>
                                        @if($iku->item->count() == 0)
                                        <h4 class="text-secondary ww text-center">TUPOKSI BELUM TERSEDIA, KLIK TOMBOL TAMBAH TUPOKSI UNTUK MENAMBAH DATA</h4>
                                        @else
                                        <h4 class="text-secondary ww text-center">TERDAPAT <span id="tp"></span> TUPOKSI</h4>
                                        @endif
                                    </table>
                                    <div class="d-flex justify-content-between">
                                        <a class="btn btn-primary" href="{{route('iku.index')}}">Kembali</a>
                                        <input type="button" name="submit" id="submit" class="btn btn-info" value="Submit" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="tabelpos" class="table-responsive">
                    @foreach($iku->item as $a)
                    {{$a->item}}
                    @endforeach
                    {{$iku->item->count()}}
                </div>
                <hr>
                <br>
                <div id="tabelpos" class="table-responsive">

                </div>

            </div>
        </div>
    </div>
</div>
<button style="display: none;" id="toastr-three"></button><button style="display: none;" id="toastr-one"></button><button style="display: none;" id="delete-wrong"></button><button style="display: none;" id="delete-success"></button>

<div id="con-edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div>
                <form id="edit_jab" method="POST" action="#">
                    @csrf
                    <input type="hidden" id="idposte" value="">
                    <div class="modal-body p-2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1-edit" class="control-label">Item</label>
                                    <textarea name="item" class="form-control" required id="item" cols="30" rows="3">{{old('item')}}</textarea>
                                    <div class="text-danger" id="itemerr"></div>

                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                        <button id="jab_e" class="btn btn-success waves-effect waves-light">
                            <span id="spine" class="spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                            <span id="texte">Simpan</span>
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
    function call() {
        $.get("{{route('iku.tabeliku',$iku->id)}}", {}, function(data, status) {
            $("#tabelpos").html(data);
            $("#tp").html($("#total").html());



        });
    }
    call();

    function updatej(id) {
        let url = window.location.origin;
        console.log(url)
        let data = {
            id: id
        };
        $('.loader').modal('show');

        $.ajax({
            url: url + '/admin/dm/edittupok/' + id,
            type: "get",
            data: data,
            success: function(response) {
                $('.loader').modal('hide');

                $("#con-edit-modal").modal('show');
                $("#item").val(response.item);
                $("#idposte").val(response.id);
                console.log(response);

            }
        })
    }

    function deletej(id) {

        let d = confirm("Klik Oke Untuk Melanjutkan")
        if (d) {
            $('.loader').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route("iku.hapustupok")}}',
                type: 'POST',
                data: {
                    data: id
                },
                success: function(response) {
                    if (response == 'success') {
                        $("#delete-success").trigger("click");

                        call();
                        $('.loader').modal('hide');
                    } else {
                        $("#delete-wrong").trigger("click");

                    }

                }
            })
        }

    }
    var i = 1;
    $('#add').click(function() {
        i++;
        $(".ww").hide();
        $('#dynamic_field').append('<tr id="row' + i + '"><td style="width: 95%;" ><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
    });

    $(document).on('click', '.btn_remove', function() {
        if ($("#dynamic_field tbody").children().length == 2) {
            $(".ww").show();


        }
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });
    $('#submit').click(function() {
        $('.loader').modal('show');
        let d = $('#add_name').serialize();
        console.log(d);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('iku.storeitem')}}",
            data: d,
            type: "POST",
            success: function(e) {
                if (e == 'null' || e == 'error') {
                    $("#toastr-one").trigger("click");

                } else {
                    $("#toastr-three").trigger("click");

                }
                console.log(e);
                call();
                $(".btn_remove").trigger('click');

                $('.loader').modal('hide');

            }
        });
    });
    $("#edit_jab").submit(function(e) {
        let url = window.location.origin;
        var id = $("#idposte").val();
        e.preventDefault();
        $("#itemerr").html('');
        var data = $(this).serialize();
        console.log(id);
        $("#jab_e").attr('disabled', 'true');
        $("#texte").html('Simpan...')
        $("#spine").addClass('spinner-border ');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url + '/admin/dm/updatetupok/' + id,
            type: 'POST',
            data: data,
            success: function(e) {
                $("#jab_e").removeAttr('disabled');
                $("#texte").html('Simpan');
                $("#spine").removeClass('spinner-border ');
                console.log(e)
                if (e.error != null) {
                    $("#toastr-one").trigger("click");

                    Object.keys(e.error).forEach(key => {
                        console.log(key);
                        $("#" + key + "err").html(e.error[key]);
                    });
                    console.log(e.error)
                }
                if (e.success) {
                    $("#itemerr").html('');
                    $("#toastr-three").trigger("click");
                    $("#con-edit-modal").modal('hide');
                    console.log('success');
                    call();

                }
            }
        })

    })
</script>
@endpush