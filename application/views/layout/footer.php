    <!-- Modal -->
    <div class="modal fade" id="modal-auth" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="modal-authTitle" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content border-0" style="border-radius:0">
                <div class="modal-header border-0 bg-primary" style="border-radius:0">
                    <a href="javascipt();" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div id="loader" class="d-none"></div>
                    <div class="pl-4 pr-4 pb-3 mb-3" id="content-auth">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">

                <div class="col-lg-3 col-md-6">
                    <div class="footer-info">
                    <h3><?= $data['info_name'] ?></h3>
                    <p>
                        <?= $data['info_address'] ?> <br><br>
                        <strong>Phone:</strong> <?= $data['info_phone'] ?><br>
                        <strong>Email:</strong> <?= $data['info_email'] ?><br>
                    </p>
                    <div class="social-links mt-3">
                        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                    </div>
                    </div>
                </div>

                <div class="col-lg-5 col-md-6 footer-links">
                    <h4>Katalog</h4>
                    <ul>
                        <?php 
                            $this->db->limit(5);
                            $category = $this->db->get('m_category')->result_array();
                        ?>
                        <?php foreach ($category as $key => $c) { ?>
                            <li><i class="bx bx-chevron-right"></i> <a href="<?= base_url('product?katalog='.$c['id']) ?>"><?= $c['name'] ?></a></li>
                        <?php } ?>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6 footer-newsletter">
                    <h4>Our Newsletter</h4>
                    <p>Kami tunggu saran dari anda</p>
                    <form action="" method="post">
                        <input type="email" name="email_post"><input type="submit" value="Subscribe">
                    </form>

                </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span><?= $data['info_name'] ?></span></strong>. All Rights Reserved
            </div>
        </div>
    </footer>

    <div id="preloader"></div>
    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

    <!-- Template Main JS File -->
    <script src="<?= base_url('assets') ?>/assets/js/main.js"></script>
    
    <?php if (!$this->userdata) { ?>
        <script>
            let modal_auth = $('#modal-auth');
            let content_auth = $('#content-auth');
            $(document).on("click.ev", "#btn-login", function(e) {
                modal_auth.modal('show');
                showLoad();
                content_auth.html('');
                setTimeout(() => {
                    $.ajax({
                        type: "get",
                        url: "<?= base_url('home/login_modal') ?>",
                        success: function (response) {
                            content_auth.html(response);
                        }
                    });
                    hideLoad();
                }, 500);
            });
            $(document).on("click.ev", "#btn-daftar", function(e) {
                modal_auth.modal('show');
                showLoad();
                content_auth.html('');
                setTimeout(() => {
                    $.ajax({
                        type: "get",
                        url: "<?= base_url('home/daftar_modal') ?>",
                        success: function (response) {
                            content_auth.html(response);
                        }
                    });
                    hideLoad();
                }, 500);
            });
            function auth(data){
                $.ajax({
                    type: "post",
                    url: "<?= base_url('auth/auth') ?>",
                    data: data,
                    dataType: "json",
                    success: function (res) {
                        if (data.type == 'daftar') {
                            if (res.type == 'error') {
                                Swal.fire('Pendaftaran Gagal', res.msg, 'warning');
                            }else{
                                modal_auth.modal('show');
                                showLoad();
                                content_auth.html('');
                                setTimeout(() => {
                                    $.ajax({
                                        type: "get",
                                        url: "<?= base_url('home/login_modal') ?>",
                                        success: function (response) {
                                            content_auth.html(response);
                                        }
                                    });
                                    hideLoad();
                                    Swal.fire('Pendaftaran Berhasil', 'Silahkan login', 'success');
                                }, 100);
                            }
                        }else{
                            if (res.type == 'error') {
                                Swal.fire('Login Gagal', res.msg, 'warning');
                            }else{
                                showLoad();
                                setTimeout(() => {
                                    modal_auth.modal('hide');
                                    content_auth.html('');
                                    let url = "<?= base_url('mitra') ?>";
                                    location.replace(url);
                                    hideLoad();
                                }, 1000);
                            }
                        }
                    }
                });
            }
        </script>
    <?php } ?>
    <script>
        $(document).ready(function(){
            if($('.bbb_viewed_slider').length){
                var viewedSlider = $('.bbb_viewed_slider');
                viewedSlider.owlCarousel({
                    loop:true,
                    margin:10,
                    autoplay:true,
                    autoplayTimeout:6000,
                    nav:false,
                    dots:false,
                    responsive:{
                        0:{items:1},
                        575:{items:2},
                        768:{items:3},
                        991:{items:4},
                        // 1002:{items:5},
                        // 1199:{items:6}
                    }
                });
                if($('.bbb_viewed_prev').length){
                    var prev = $('.bbb_viewed_prev');
                    prev.on('click', function(){
                        viewedSlider.trigger('prev.owl.carousel');
                    });
                }
                if($('.bbb_viewed_next').length){
                    var next = $('.bbb_viewed_next');
                    next.on('click', function(){
                        viewedSlider.trigger('next.owl.carousel');
                    });
                }
            } 
        });

        $(document).on("click.ev", "#btn-cart-awal", function(){
            showLoad();
            let $this = $(this);
            let product_id = $this.attr('data-id');
            Swal.fire({
                title: 'Tambahkan ke keranjang?',
                text: "Produk ini akan disimpan di keranjang",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tambahkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('home/add_cart') ?>",
                        data : {
                            product_id:product_id
                        },
                        method: 'get',
                        dataType: 'json',
                        success: function(data){
                            if (data.type == 'success') {
                                Swal.fire('Berhasil!', data.msg, 'success')
                                getCart();
                            }else {
                                Swal.fire('Gagal!', data.msg, 'warning')
                            }
                            hideLoad();
                        }
                    });
                }else{
                    hideLoad();
                }
            });
        });
    </script>
</body>

</html>