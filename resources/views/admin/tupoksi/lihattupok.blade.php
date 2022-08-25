<div class="row">
    @php $nomor = 1; @endphp
    @foreach($datat as $d)
    <div class="col-10">
        <h4>{{$nomor++}}. {{$d->uraian}}</h4>
    </div>
    @endforeach

</div>
<div style="display: none;" id="jabtupok">{{$jab->jabatan}}</div>