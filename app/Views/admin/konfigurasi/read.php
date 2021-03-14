<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <?= form_open('Konfigurasi/submit', ['class' => 'formtambah']) ?>
            <div class="card-body">
                <i class="mdi mdi-circle-edit-outline"></i> Konfigurasi Website
                <hr>
                <input type="hidden" class="form-control" id="konfigurasi_id" value="<?= $profile[0]['id']; ?>" name="konfigurasi_id" readonly>
                <div class="form-group">
                    <label> <i class="mdi mdi-text-shadow"></i>
                        Nama Perusahaan
                    </label>
                    <input type="text" id="nama_web" value="<?= $profile[0]['nama_pt']; ?>" name="nama_web" class="form-control">
                    <div class="invalid-feedback errorNama">
                    </div>
                </div>

                <div class="form-group">
                    <label> <i class=" mdi mdi-playlist-star"></i>
                        Deskripsi
                    </label>
                    <textarea rows="5" type="text" id="deskripsi" name="deskripsi" class="form-control"><?= $profile[0]['profile_pt']; ?></textarea>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-instagram"></i>
                            Instagram
                        </label>
                        <input type="text" id="instagram" name="instagram" value="<?= $profile[0]['instagram']; ?>" class="form-control">
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-facebook"></i>
                            Facebook
                        </label>
                        <input type="text" id="facebook" name="facebook" value="<?= $profile[0]['facebook']; ?>" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-whatsapp"></i>
                            Whatsapp
                        </label>
                        <input type="text" id="whatsapp" name="whatsapp" value="<?= $profile[0]['whatsapp']; ?>" class="form-control">
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-email"></i>
                            Email
                        </label>
                        <input type="text" id="email" name="email" value="<?= $profile[0]['email']; ?>" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-phone"></i>
                            Telepon Kantor
                        </label>
                        <input type="text" id="telepon" name="telepon" value="<?= $profile[0]['no_telp']; ?>" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label> <i class="mdi mdi-office-building"></i>
                        Alamat
                    </label>
                    <input type="text" id="alamat" name="alamat" value="<?= $profile[0]['tempat']; ?>" class="form-control">
                </div>

                <button type="submit" class="mt-2 btn btn-primary btnsimpan"><i class="fa fa-paper-plane"></i> Update</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body">
                <i class="mdi mdi-image-filter-hdr"></i> Logo Website <br>
                <small>*Klik foto untuk mengganti foto.</small>
                <hr>
                <div class="form-group text-center">
                    <img class="img-thumbnail logoweb" onclick="logo(<?= $profile[0]['id']; ?>)" src="<?= base_url('uploads/profile/thumb' . '/thumb_' . $profile[0]['logo_pt']); ?>" width="200px" alt="Foto">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.formtambah').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: {
                konfigurasi_id: $('input#konfigurasi_id').val(),
                nama_web: $('input#nama_web').val(),
                deskripsi: $('textarea#deskripsi').val(),
                instagram: $('input#instagram').val(),
                facebook: $('input#facebook').val(),
                whatsapp: $('input#whatsapp').val(),
                telepon: $('input#telepon').val(),
                email: $('input#email').val(),
                alamat: $('input#alamat').val(),
            },
            dataType: "json",
            beforeSend: function() {
                $('.btnsimpan').attr('disable', 'disable');
                $('.btnsimpan').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
            },
            complete: function() {
                $('.btnsimpan').removeAttr('disable', 'disable');
                $('.btnsimpan').html('<i class="fa fa-paper-plane"></i> Update');
            },
            success: function(response) {
                if (response.error) {
                    if (response.error.nama_web) {
                        $('#nama_web').addClass('is-invalid');
                        $('.errorNama').html(response.error.nama_web);
                    } else {
                        $('#nama_web').removeClass('is-invalid');
                        $('.errorNama').html('');
                    }
                } else {
                    Swal.fire({
                        title: "Berhasil!",
                        text: response.sukses,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    dataprofile();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    })

    function logo(id) {
        $.ajax({
            type: "POST",
            url: "<?= site_url('Konfigurasi/formuploadlogo') ?>",
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