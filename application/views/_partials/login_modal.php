<div class="row" id="form-login">
    <div class="col-md-12">
        <span id="alert"></span>
        <h4 class="text-center">Login Mitra</h4>
        <div class="form-group">
            <label for="email" class="label-required">Email</label>
            <input type="email" name="email" id="email" placeholder="Email" class="form-control" required>
            <input type="hidden" value="login" name="type" id="type" class="form-control">
        </div>
        <div class="form-group">
            <label for="password" class="label-required">Password</label>
            <input type="password" name="password" id="password" placeholder="Password" class="form-control" required>
        </div>
    </div>
    <div class="col-md-12">
        <div class="text-center">
            <hr>
            <button type="button" id="btn-login-post"  class="btn mb-2 btn-primary btn-block">Login</button>
            <a href="#" id="btn-daftar">Belum punya akun?</a>
        </div>
    </div>
</div>

<script>
    $(document).on("click.ev", "#btn-login-post", function(e) {
        showLoad();
        let form = $('#form-login');
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