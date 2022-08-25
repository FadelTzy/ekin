<table class="table table-centered w-100 " id="products-datatable2" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="thead-light">
        <tr>
            <th style="width: 5%x;">
                #
            </th>
            <th style="width: 85%;">Item</th>


            <th style="width: 10%;">Aksi</th>
        </tr>
    </thead>
    @php $no = 1 @endphp
    <tbody id="tabelpos">
        @foreach($datatupok as $dt)
        <tr id="rw{{$dt->id}}">
            <td>
                <!-- <span id="spin" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span> -->
                {{$no++}}
            </td>
            <td>

                <h5 class="m-0 d-inline-block align-middle">{{$dt->item}}</h5>
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
<p id="total" style="display:none">{{$datatupok->count()}}</p>
<script>
    $(document).ready(function() {
        $("#products-datatable2").DataTable();

    })
</script>