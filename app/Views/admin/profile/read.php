<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <i class="mdi mdi-image-filter-hdr"></i> Foto Profile User <br>
                <small>*Klik foto untuk mengganti foto.</small>
                <hr>
                <div class="form-group text-center">
                    <img class="img-thumbnail logoweb" onclick="foto(<?= $profile['id_user']; ?>)" src="<?= base_url('uploads/user/' . $profile['foto']); ?>" width="200px" alt="Foto">
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <?= form_open('Profile/submit', ['class' => 'formtambah']) ?>
            <div class="card-body">
                <i class="mdi mdi-circle-edit-outline"></i> Konfigurasi Profile
                <hr>
                <input type="hidden" class="form-control" id="konfigurasi_id" name="konfigurasi_id" readonly>

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-account"></i>
                            Username
                        </label>
                        <input type="text" id="username" name="username" value="<?= $profile['username']; ?>" class="form-control">
                        <div class="invalid-feedback errorUsername">
                        </div>
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-email"></i>
                            Email
                        </label>
                        <input type="email" id="email" name="email" value="<?= $profile['email']; ?>" class="form-control">
                        <div class="invalid-feedback errorEmail">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-lock"></i>
                            Password
                        </label>
                        <input type="password" id="password" name="password" class="form-control">
                        <small><span>Kosongkan password jika tidak ingin diubah</span></small>
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-lock-alert"></i>
                            Confirm Password
                        </label>
                        <input type="password" id="password2" name="password2" class="form-control">
                        <div class="invalid-feedback errorPassword">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-account-star"></i>
                            Role
                        </label>
                        <input type="text" id="role" name="role" value="<?= $profile['nama']; ?>" class="form-control" readonly>
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label> <i class="mdi mdi-timer"></i>
                            Last Login
                        </label>
                        <input type="text" id="login" name="login" value="<?= $profile['last_login']; ?>" class="form-control" readonly>
                    </div>
                </div>

                <button type="submit" class="mt-2 btn btn-primary btnsimpan"><i class="fa fa-paper-plane"></i> Update</button>
            </div>
            <?= form_close() ?>
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
                username: $('input#username').val(),
                email: $('input#email').val(),
                password: $('input#password').val(),
                password2: $('input#password2').val(),
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
                    if (response.error.username) {
                        $('#username').addClass('is-invalid');
                        $('.errorUsername').html(response.error.username);
                    } else {
                        $('#username').removeClass('is-invalid');
                        $('.errorUsername').html('');
                    }
                    if (response.error.email) {
                        $('#email').addClass('is-invalid');
                        $('.errorEmail').html(response.error.email);
                    } else {
                        $('#email').removeClass('is-invalid');
                        $('.errorEmail').html('');
                    }
                    if (response.error.password) {
                        $('#password2').addClass('is-invalid');
                        $('.errorPassword').html(response.error.password);
                    } else {
                        $('#password2').removeClass('is-invalid');
                        $('.errorPassword').html('');
                    }
                } else {
                    Swal.fire({
                        title: "Berhasil!",
                        text: response.sukses,
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    dataprofileuser();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    })

    function foto(id) {
        $.ajax({
            type: "POST",
            url: "<?= Base_url('Profile/formuploadlogo') ?>",
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