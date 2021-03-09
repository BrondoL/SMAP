<?= $this->extend('admin/layout/index'); ?>
<?= $this->section('content'); ?>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Total Jabatan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">5 Jabatan</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-id-card-alt fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Jabatan Pegawai</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>Tiger Nixon</td>
                        <td>System Architect</td>
                        <td>Edinburgh</td>
                        <td>61</td>
                        <td>2011/04/25</td>
                        <td>$320,800</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="edit(<?= 1; ?>)"><i class="fa fa-tags"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="hapus(<?= 1; ?>)"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>Garrett Winters</td>
                        <td>Accountant</td>
                        <td>Tokyo</td>
                        <td>63</td>
                        <td>2011/07/25</td>
                        <td>$170,750</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="edit(<?= 1; ?>)"><i class="fa fa-tags"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="hapus(<?= 1; ?>)"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>Ashton Cox</td>
                        <td>Junior Technical Author</td>
                        <td>San Francisco</td>
                        <td>66</td>
                        <td>2009/01/12</td>
                        <td>$86,000</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="edit(<?= 1; ?>)"><i class="fa fa-tags"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="hapus(<?= 1; ?>)"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('myscript'); ?>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "columnDefs": [{
                "targets": [7],
                "orderable": false,
            }]
        });
    });
</script>

<?= $this->endSection(); ?>