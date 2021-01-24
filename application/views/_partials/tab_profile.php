<div class="card shadow p-3 border-0" style="border-radius:0">
    <div class="card-body">
        <h5>Profile</h5>
        <hr class="hr-dashed">
        <form action="" id="form-profile">
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="avatar-wrapper">
                        <img class="profile-pic" src="<?= base_url('assets') ?>/assets/img/profile.png" />
                        <div class="upload-button">
                            <i class="fa fa-edit" aria-hidden="true"></i>
                        </div>
                        <input class="file-upload" type="file" name="avatar" accept="image/*"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" class="label-required">Nama</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="birthday" class="label-required">Tanggal Lahir</label>
                        <input type="text" name="birthday" id="birthday" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone" class="label-required">Telepon</label>
                        <input type="text" name="phone" id="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="label-required">Email</label>
                        <input type="text" name="email" id="email" class="form-control" required readonly>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
        <h5 class="mt-5">Ganti Password</h5>
        <hr class="hr-dashed">
        <form action="" id="form-ganti-password">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password" class="label-required">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="c_password" class="label-required">Konfirmasi Password</label>
                        <input type="password" name="c_password" id="c_password" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    showLoad();
    setTimeout(() => {
        hideLoad();
    }, 800);
    getProfile();

    $(".file-upload").on('change', function(){
        readURL(this);
    });

    $(".upload-button").on('click', function() {
        $(".file-upload").click();
    });

    $("#birthday").daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      locale : {
          format : 'YYYY-MM-DD'
      }
    }).on('apply.daterangepicker', function (ev, picker) {
      let startDate = picker.startDate.format('YYYY-MM-DD');
      $(this).val(startDate);
    });

    $('#form-profile').submit(function(e){
        e.preventDefault(); 
        showLoad();
        let data = new FormData(this);
        setTimeout(() => {
            $.ajax({
                type: "post",
                url: "<?= $update_profile ?>",
                data: data,
                processData:false,
                contentType:false,
                cache:false,
                async:false,
                dataType: "json",
                success: function (res) {
                    if (res.type == 'success') {
                        Swal.fire('Berhasil', res.msg, 'success');
                        getPage();
                        getProfile();
                    }else{
                        Swal.fire('Opppss', res.msg, 'error');
                    }
                    hideLoad();
                }
            });
        }, 1000);
    });

    $('#form-ganti-password').submit(function(e){
        e.preventDefault(); 
        showLoad();
        let data = new FormData(this);
        setTimeout(() => {
            $.ajax({
                type: "post",
                url: "<?= $update_password ?>",
                data: data,
                processData:false,
                contentType:false,
                cache:false,
                async:false,
                dataType: "json",
                success: function (res) {
                    if (res.type == 'success') {
                        Swal.fire('Berhasil', res.msg, 'success');
                        let logout = "<?= base_url('auth/logout') ?>";
                        location.assign(logout);
                    }else{
                        Swal.fire('Opppss', res.msg, 'error');
                    }
                    hideLoad();
                }
            });
        }, 1000);
    });

</script>