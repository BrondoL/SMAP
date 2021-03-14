<?= $this->extend('admin/layout/index'); ?>
<?= $this->section('content'); ?>

<div class="viewdata"></div>
<div class="viewmodal"></div>

<?= $this->endSection(); ?>

<?= $this->section('myscript'); ?>

<script>
    function dataprofile() {
        $.ajax({
            url: "<?= base_url('Konfigurasi/fetch_data'); ?>",
            dataType: "json",
            success: function(response) {
                $('.viewdata').html(response.data);
            }
        });
    }

    $(document).ready(function() {
        dataprofile();
    });
</script>

<?= $this->endSection(); ?>