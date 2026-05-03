@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">DATA ADMINISTRASI LAHAN DESA (SUMBER: DHKP)</h6>
                </div>
                <div class="col-md-4">
                    <form action="{{ route('lahan.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control form-control-sm" 
                                   placeholder="Cari NOP atau Nama..." 
                                   value="{{ request('search') }}">
                            <button class="btn btn-sm btn-primary" type="submit">
                                <i class="bi bi-search"></i> Cari
                            </button>
                            @if(request('search'))
                                <a href="{{ route('lahan.index') }}" class="btn btn-sm btn-secondary">Reset</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="bg-light text-center small fw-bold">
                        <tr>
                            <th>NO</th>
                            <th>NOP</th>
                            <th>NAMA WP (DHKP)</th>
                            <th>LUAS SPPT</th>
                            <th>LETAK (P/B)</th>
                            <th>PEMILIK RIIL</th>
                            <th>ALAMAT PEMILIK</th>
                            <th>LUAS MILIK (M2)</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @forelse($data_lahan as $index => $lahan)
                            @php 
                                $pemiliks = $lahan->pemiliks;
                                $total_pemilik = $pemiliks->count();
                                $nomor = $data_lahan->firstItem() + $index;
                            @endphp

                            @if($total_pemilik == 0)
                                <tr>
                                    <td class="text-center">{{ $nomor }}</td>
                                    <td class="fw-bold">{{ $lahan->nop }}</td>
                                    <td>{{ $lahan->nama_wp }}</td>
                                    <td class="text-center">{{ $lahan->luas_bumi }}</td>
                                    <td class="text-center">{{ $lahan->no_persil }} / {{ $lahan->no_blok }}</td>
                                    <td class="text-primary fw-bold">{{ $lahan->nama_wp }}</td>
                                    <td class="text-muted">{{ $lahan->alamat_wp }}</td>
                                    <td class="text-center">{{ $lahan->luas_bumi }}</td>
                                    <td class="text-center"><span class="badge bg-secondary shadow-sm">ASLI DHKP</span></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary" 
                                                onclick="tambahMutasi('{{ $lahan->id }}', '{{ $lahan->nop }}', '{{ $lahan->nama_wp }}', '{{ $lahan->luas_bumi }}')"
                                                title="Tambah Mutasi">
                                            <i class="bi bi-plus-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                            @else
                                @foreach($pemiliks as $key => $pemilik)
                                <tr>
                                    @if($key == 0)
                                        <td class="text-center" rowspan="{{ $total_pemilik }}">{{ $nomor }}</td>
                                        <td class="fw-bold" rowspan="{{ $total_pemilik }}">{{ $lahan->nop }}</td>
                                        <td rowspan="{{ $total_pemilik }}">{{ $lahan->nama_wp }}</td>
                                        <td class="text-center" rowspan="{{ $total_pemilik }}">{{ $lahan->luas_bumi }}</td>
                                        <td class="text-center" rowspan="{{ $total_pemilik }}">{{ $lahan->no_persil }} / {{ $lahan->no_blok }}</td>
                                    @endif
                                    <td class="fw-bold text-success">{{ $pemilik->nama_pemilik_baru }}</td>
                                    <td>{{ $pemilik->alamat_pemilik ?? '-' }}</td>
                                    <td class="text-center">{{ $pemilik->luas_milik }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $pemilik->status == 'SINKRON' ? 'bg-success' : 'bg-warning text-dark' }} shadow-sm">
                                            {{ $pemilik->status }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            {{-- TOMBOL LIHAT DETAIL (IKON MATA) --}}
                                            <a href="{{ route('lahan.detail', $pemilik->id) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="Lihat Detail & Scan">
                                                <i class="bi bi-eye text-white"></i>
                                            </a>

                                            {{-- TOMBOL EDIT --}}
                                            <button class="btn btn-sm btn-warning" 
                                                    onclick="editMutasi('{{ $pemilik->id }}', '{{ $lahan->nop }}', '{{ $lahan->nama_wp }}', '{{ $pemilik->nama_pemilik_baru }}', '{{ $pemilik->alamat_pemilik }}', '{{ $pemilik->luas_milik }}', '{{ $pemilik->status }}', '{{ $pemilik->no_c_desa }}')"
                                                    title="Edit">
                                                <i class="bi bi-pencil-square text-white"></i>
                                            </button>
                                            
                                            {{-- TOMBOL HAPUS --}}
                                            <form action="{{ route('lahan.destroyPemilik', $pemilik->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data mutasi ini bolo?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        @empty
                            <tr><td colspan="10" class="text-center py-4">Data tidak ditemukan, bolo!</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3 d-flex justify-content-center">
                {{ $data_lahan->links() }}
            </div>
        </div>
    </div>
</div>

{{-- MODAL MUTASI --}}
<div class="modal fade" id="modalMutasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalTitle">Mutasi Lahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formMutasi" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="methodField"></div>
                <input type="hidden" name="lahan_desa_id" id="mutasi_lahan_id">
                
                <div class="modal-body">
                    <div class="alert alert-info small shadow-sm">
                        NOP: <strong id="mutasi_text_nop"></strong><br>
                        WP Asal: <strong id="mutasi_text_nama"></strong>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Pemilik Riil Sekarang</label>
                        <input type="text" name="nama_pemilik_baru" id="in_nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat Pemilik</label>
                        <textarea name="alamat_pemilik" id="in_alamat" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Luas Milik (m2)</label>
                            <input type="number" name="luas_milik" id="in_luas" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" id="in_status" class="form-select">
                                <option value="SINKRON">SINKRON</option>
                                <option value="BELUM MUTASI">BELUM MUTASI</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">No. C Desa</label>
                        <input type="text" name="no_c_desa" id="in_cdesa" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-danger">Unggah Bukti Mutasi (PDF/JPG)</label>
                        <input type="file" name="bukti_peralihan" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                        <small class="text-muted text-italic">*Kosongkan jika tidak ingin mengubah file</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success" id="btnSimpan">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function tambahMutasi(lahanId, nop, nama, luas) {
        $('#modalTitle').text('Tambah Mutasi Baru');
        $('#btnSimpan').text('Simpan Data Baru');
        $('#formMutasi').attr('action', "{{ route('lahan.storePemilik') }}");
        $('#methodField').html(''); 
        
        $('#mutasi_lahan_id').val(lahanId);
        $('#mutasi_text_nop').text(nop);
        $('#mutasi_text_nama').text(nama);
        
        $('#in_nama').val('');
        $('#in_alamat').val('');
        $('#in_luas').val(luas);
        $('#in_status').val('BELUM MUTASI');
        $('#in_cdesa').val('');
        
        $('#modalMutasi').modal('show');
    }

    function editMutasi(id, nop, wp_asal, nama, alamat, luas, status, cdesa) {
        $('#modalTitle').text('Edit Data: ' + nama);
        $('#btnSimpan').text('Update Data');
        
        let url = "{{ route('lahan.updatePemilik', ':id') }}";
        url = url.replace(':id', id);
        
        $('#formMutasi').attr('action', url);
        $('#methodField').html('<input type="hidden" name="_method" value="PUT">'); 
        
        $('#mutasi_text_nop').text(nop);
        $('#mutasi_text_nama').text(wp_asal);
        
        $('#in_nama').val(nama);
        $('#in_alamat').val(alamat);
        $('#in_luas').val(luas);
        $('#in_status').val(status);
        $('#in_cdesa').val(cdesa);
        
        $('#modalMutasi').modal('show');
    }
</script>
@endsection