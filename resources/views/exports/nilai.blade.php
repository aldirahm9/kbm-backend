<html>
<table>
    <thead>
        <tr>
            <th align="center" rowspan="2">NRM</th>
            <th align="center" rowspan="2">Nama</th>
            <th align="center" colspan="{{$tugas->count()}}">Tugas</th>
            <th align="center" rowspan="2">UTS</th>
            <th align="center" rowspan="2">UAS</th>
            <th align="center" rowspan="2">Nilai Angka</th>
            <th align="center" rowspan="2">Nilai Huruf</th>
        </tr>
        <tr>
        @foreach ($tugas as $each)
            <th align="center">{{$loop->iteration}}</th>
        @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $mahasiswa)
            <tr>
                <td>{{$mahasiswa->username}}</td>
                <td>{{$mahasiswa->nama}}</td>
                @foreach ($tugas as $each)
                <td>{{$mahasiswa->tugas->where('pivot.tugas_id',$each->id)->first() == null ? '':
                $mahasiswa->tugas->where('pivot.tugas_id',$each->id)->first()->pivot->nilai}}</td>
                @endforeach
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>

</html>
<style>
th {
    border: 1px solid black;
}
</style>

