<div class="row" id="form-daftar">
    <div class="col-md-12">
        <span id="alert"></span>
        <h4 class="text-center">Daftar Mitra</h4>
        <div class="form-group">
            <label for="name" class="label-required">Nama</label>
            <input type="text" name="name" id="name" placeholder="Nama" class="form-control" required>
            <div class="invalid-feedback"></div>
            <input type="hidden" value="daftar" name="type" id="type" class="form-control">
        </div>
        <div class="form-group">
            <label for="phone" class="label-required">Telepon</label>
            <input type="number" name="phone" id="phone" placeholder="Telepon" class="form-control" required>
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">
            <label for="email" class="label-required">Email</label>
            <input type="email" name="email" id="email" placeholder="Email" class="form-control" required>
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">
            <label for="password" class="label-required">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" class="form-control" required>
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="text-center">
            <hr>
            <button type="button" id="btn-daftar-post" class="btn mb-2 btn-primary btn-block">Daftar</button>
            <a href="#" id="btn-login">Sudah punya akun?</a>
        </div>
    </div>
</div>

<script>
    $(document).on("click.ev", "#btn-daftar-post", function(e) {
        showLoad();
        let form = $('#form-daftar');
        let data = {};
        let next = true;
        form.find('.form-control').each(function(){
            let $this = $(this);
            let key = $this.attr('name');
            let label = $this.prev().text();
            let value = $this.val();
            if (value == '' || value == null) {
                let feedback = 'Kolom '+label+' tidak boleh kosong';
                $this.addClass('is-invalid').next().text(feedback);
                next = false;
            }else{
                $this.removeClass('is-invalid').addClass('is-valid').next().text('');
            }
            data[key] = value;
        });
        setTimeout(() => {
            if (next) {
                auth(data);
            }
            hideLoad();
        }, 800);
    });
</script>