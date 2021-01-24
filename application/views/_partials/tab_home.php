<div class="card shadow p-3 border-0" style="border-radius:0">
    <div class="card-body">
        <h5>Home</h5>
        <hr class="hr-dashed">
        <p>Hi, <?= $this->userdata->name ?> <b>( Jika Bukan <?= $this->userdata->name ?> Silakan Logout <a href="<?= base_url('auth/logout') ?>">disini</a> )</b> <br> 
        Dari Halaman ini, Anda dapat dengan mudah memeriksa & melihat pesanan terakhir Anda, <br> 
        mengelola alamat pengiriman, serta mengedit password dan detail akun Anda.</p>
    </div>
</div>