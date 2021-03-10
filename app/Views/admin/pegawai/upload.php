<!-- Modal -->
<div class="modal fade" id="modalupload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Foto Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('', ['class' => 'formupload']) ?>
            <?= csrf_field(); ?>
            <br>
            <center>
                <img class="img-thumbnail img-preview" width="70%" src="<?= base_url('uploads/pegawai') . '/' . $foto; ?>" alt="Foto Pegawai">
            </center>
            <div class="modal-body">
                <input type="hidden" value="<?= $id ?>" name="id">
                <div class="div-col-sm-9 mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="foto" name="foto" onchange="previewImg()">
                        <label class="custom-file-label" for="foto">Foto Pegawai</label>
                        <div class="ml-1 invalid-feedback errorFoto">

                        </div>
                    </div>
                    <small>
                        <p class="ml-2 mt-1 info">File .JPEG, .JPG, .PNG - Maks 1 MB</p>
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnupload"><i class="fa fa-share-square"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    function previewImg() {
        const sampul = document.querySelector('#foto');
        const sampulLabel = document.querySelector('.custom-file-label');
        const imgPreview = document.querySelector('.img-preview');

        let filename = sampul.files[0].name;
        if (filename.length > 52) {
            sampulLabel.textContent = filename.slice(0, 35) + "...." + filename.slice(-8, filename.length + 1);
        } else {
            sampulLabel.textContent = filename;
        }

        const fileSampul = new FileReader();
        fileSampul.readAsDataURL(sampul.files[0]);

        fileSampul.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }

    $(document).ready(function() {
        $('.btnupload').click(function(e) {
            e.preventDefault();
            let form = $('.formupload')[0];
            let data = new FormData(form);

            $.ajax({
                type: "POST",
                url: '<?= base_url('Pegawai/doupload') ?>',
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnupload').attr('disable', 'disable');
                    $('.btnupload').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                },
                complete: function() {
                    $('.btnupload').removeAttr('disable', 'disable');
                    $('.btnupload').html('<i class="fa fa-share-square"></i>  Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.foto) {
                            $('#foto').addClass('is-invalid');
                            $('.errorFoto').html(response.error.foto);
                        } else {
                            $('#foto').removeClass('is-invalid');
                            $('.errorFoto').html('');
                        }
                    } else {
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.sukses,
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#modalupload').modal('hide');
                        datapegawai();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });

        });
    });
</script>