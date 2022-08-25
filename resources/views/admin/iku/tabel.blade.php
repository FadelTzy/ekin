<table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable2" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="thead-light">
        <tr>
            <th style="width: 15px;">
                #
            </th>
            <th>Jabatan</th>
            <th>Unit</th>
            <th>Status Remun</th>
            <th>Status Kepegawaian</th>
            <th>Tupoksi</th>

            <th style="width: 85px;">Action</th>
        </tr>
    </thead>
    @php $no = 1 @endphp
    <tbody id="tabelpos">
        <tr>
            <td>1</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $("#products-datatable2").DataTable();

    })
</script>