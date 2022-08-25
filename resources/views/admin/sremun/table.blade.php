<table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable2" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="thead-light">
        <tr>
            <th style="width: 20px;">
                #
            </th>
            <th style="width: 20%;">Kode Status</th>
            <th>Status</th>
            <th>Jenis Kinerja</th>

            <th style="width: 85px;">Action</th>
        </tr>
    </thead>
    @php $no = 1 @endphp
    <tbody id="tabelpos">
        @foreach($dataremun as $dt)
        <tr id="rw{{$dt->id}}">
            <td>
                <!-- <span id="spin" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span> -->
                {{$no++}}
            </td>
            <td>

                <h5 class="m-0 d-inline-block align-middle">{{$dt->kode_status}}</h5>
            </td>


            <td>
                {{$dt->status}}
            </td>
            <td>
                <h1 class="badge badge-info">{{str_replace(' ',' & ',$dt->jenis_kinerja)}}</h1>
            </td>
            <td>
                <ul class="list-inline table-action m-0">


                    <li class="list-inline-item">
                        <a href="javascript:void(0);" onclick="updatej('{{$dt->id}}')" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="javascript:void(0);" onclick="deletej('{{$dt->id}}')" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                    </li>
                </ul>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $("#products-datatable2").DataTable();

    })
</script>