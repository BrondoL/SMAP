<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr style="text-align: center;">
            <th>No</th>
            <th>Foto</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Telepon</th>
            <th>Jabatan</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($pegawai as $p) : ?>
            <tr class="text-center">
                <td class="align-middle"><?= $no++; ?></td>
                <td class="align-middle"><img onclick="gambar(<?= $p['id'] ?>)" src="<?= base_url('uploads/pegawai/thumb') . '/thumb_' . $p['foto']; ?>" width="50px" class="img-thumbnail"></td>
                <td class="align-middle"><?= $p['nip']; ?></td>
                <td class="align-middle"><?= $p['nama']; ?></td>
                <td class="align-middle"><?= $p['telepon']; ?></td>
                <td class="align-middle"><?= $p['nama_jabatan']; ?></td>
                <td class="align-middle">
                    <button class="btn btn-success btn-sm" onclick="detail(<?= $p['id']; ?>)"><i class="fa fa-eye"></i></button>
                    <button class="btn btn-warning btn-sm" onclick="edit(<?= $p['id']; ?>)"><i class="fa fa-tags"></i></button>
                    <button class="btn btn-danger btn-sm" onclick="hapus(<?= $p['id']; ?>)"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "columnDefs": [{
                "targets": [1, 6],
                "orderable": false,
            }]
        });
    });

    function edit(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('Pegawai/form_edit'); ?>",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modaledit').modal('show');
                }
            }
        });
    }

    function hapus(id) {
        Swal.fire({
            title: 'Hapus',
            text: "Yakin menghapus Jabatan ini ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cencelButtonText: 'Tidak',
        }).then((result) => {
            $.ajax({
                type: "POST",
                url: "<?= base_url('Pegawai/hapus'); ?>",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil...',
                            text: response.sukses,
                        });
                        datapegawai();
                        jumlahpegawai();
                    }
                }
            });
        })
    }

    function gambar(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('Pegawai/form_upload'); ?>",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.viewmodal').html(response.sukses).show();
                    $('#modalupload').modal('show');
                }
            }
        });
    }
</script>