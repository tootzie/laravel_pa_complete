<table>
    <thead>
        <tr>
            <th>EKTP</th>
            <th>Nama</th>
            <th>Nilai</th>
            <th>Penilai</th>
            <th>Tgl Akhir Periode</th>
        </tr>
    </thead>
    <tbody>
        @foreach($headerPAs as $headerPA)
            <tr>
                <td>{{ $headerPA->ektp_employee }}</td>
                <td>{{ $headerPA->nama_employee }}</td>
                <td>{{ $headerPA->nilai_akhir ?? 'Belum Dinilai' }}</td>
                <td>{{ $headerPA->nama_atasan }}</td>
                <td>{{\Carbon\Carbon::parse($masterTahunPeriode->end_date)->translatedFormat('j F Y')}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
