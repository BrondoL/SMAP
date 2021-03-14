<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr style="text-align: center;">
            <th>No.</th>
            <th>Nama Jabatan</th>
            <th>Level Jabatan</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($jabatan as $j) : ?>
            <tr style="text-align: center;">
                <td><?= $no++; ?></td>
                <td><?= $j['nama_jabatan']; ?></td>
                <td><?= $j['level']; ?></td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="edit(<?= $j['id_jabatan']; ?>)"><i class="fa fa-tags"></i></button>
                    <button class="btn btn-danger btn-sm" onclick="hapus(<?= $j['id_jabatan']; ?>)"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "columnDefs": [{
                "targets": [3],
                "orderable": false,
            }]
        });
    });

    function edit(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('Jabatan/form_edit'); ?>",
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
            title: 'Hapus data?',
            text: `Apakah anda yakin menghapus data?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= base_url('Jabatan/hapus') ?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: response.sukses,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            datajabatan();
                            jumlahjabatan();
                        }
                    }
                });
            }
        })
    }
</script>