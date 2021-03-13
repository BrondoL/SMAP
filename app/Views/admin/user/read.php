<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr style="text-align: center;">
            <th>No</th>
            <th>Foto</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Last Login</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($user as $u) : ?>
            <tr class="text-center">
                <td class="align-middle"><?= $no++; ?></td>
                <td class="align-middle"><img onclick="gambar(<?= $u['id_user'] ?>)" src="<?= base_url('uploads/user/thumb') . '/thumb_' . $u['foto']; ?>" width="50px" class="img-thumbnail"></td>
                <td class="align-middle"><?= $u['username']; ?></td>
                <td class="align-middle"><?= $u['email']; ?></td>
                <td class="align-middle"><?= $u['nama']; ?></td>
                <td class="align-middle"><?= $u['last_login']; ?></td>
                <td class="align-middle">
                    <button class="btn btn-warning btn-sm" onclick="edit(<?= $u['id_user']; ?>)"><i class="fa fa-tags"></i></button>
                    <button class="btn btn-danger btn-sm" onclick="hapus(<?= $u['id_user']; ?>)"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "columnDefs": [{
                "targets": [1, 5],
                "orderable": false,
            }]
        });
    });

    function edit(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('User/form_edit'); ?>",
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
                    url: "<?= base_url('User/hapus') ?>",
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
                            datauser();
                            jumlahuser();
                        }
                    }
                });
            }
        })
    }

    function gambar(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('User/form_upload'); ?>",
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