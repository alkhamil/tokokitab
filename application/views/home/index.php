<?php 
    $data = $this->db->get_where('m_info', ['id'=>1])->row_array();
  ?>
<!-- ======= Hero Section ======= -->
<section id="hero">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-ride="carousel">

      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

      <div class="carousel-inner" role="listbox">

        <!-- Slide 1 -->
        <?php foreach ($banner as $key => $item) { ?>
            <div class="carousel-item <?= ($key==0) ? 'active' : '' ?>" style="background-image: url(<?= $item['image'] ?>); background-size:cover">
            </div>
        <?php } ?>

      </div>

      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon icofont-simple-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>

      <a class="carousel-control-next" href="#heroCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon icofont-simple-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>

    </div>
</section>
<!-- End Hero -->

<!-- ======== Main ========= -->
<main id="main">

    <section id="product" class="product">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col">
                    <div class="bbb_main_container">
                        <div class="bbb_viewed_title_container">
                            <h3 class="bbb_viewed_title">Product Terlaris</h3>
                            <div class="bbb_viewed_nav_container">
                                <div class="bbb_viewed_nav bbb_viewed_prev"><i class="fas fa-chevron-left"></i></div>
                                <div class="bbb_viewed_nav bbb_viewed_next"><i class="fas fa-chevron-right"></i></div>
                            </div>
                        </div>
                        <div class="bbb_viewed_slider_container">
                            <div class="owl-carousel owl-theme bbb_viewed_slider">
                                <?php foreach ($product as $key => $item) {?>
                                    <div class="card" style="border-radius:0">
                                        <img class="card-img" src="<?= $item['image'] ?>" style="height:180px; border-radius:0" alt="">
                                        <div class="card-img-overlay d-flex justify-content-end">
                                            <a href="#" class="card-link text-danger like">
                                                <i class="fas fa-heart"></i>
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <strong><?= $item['name'] ?></strong><br>
                                            <small class="card-subtitle mb-2 text-muted"><?= $item['code'] ?></small><br>
                                            <small class="card-subtitle mb-2 text-muted"><strong>Rp. <?= number_format($item['final_price']) ?></strong></small>
                                            <?= ($item['stock'] > 0) ? '' : '<small class="badge badge-danger">Stock Habis</small>' ?>
                                            <div class="buy d-flex justify-content-between align-items-center">
                                                <button type="button" id="<?= ($this->userdata) ? 'btn-cart-awal' : 'btn-login' ?>" data-id="<?= $item['id'] ?>" class="btn btn-sm btn-block btn-primary mt-3" <?= ($item['stock'] > 0) ? '' : 'disabled' ?>>
                                                    <i class="fas fa-shopping-cart"></i> Cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="product" class="product pt-0">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col">
                    <div class="bbb_main_container">
                        <div class="bbb_viewed_title_container">
                            <h3 class="bbb_viewed_title">Katalog Kitab</h3>
                            <div class="bbb_viewed_nav_container">
                                <div class="bbb_viewed_nav bbb_viewed_prev"><i class="fas fa-chevron-left"></i></div>
                                <div class="bbb_viewed_nav bbb_viewed_next"><i class="fas fa-chevron-right"></i></div>
                            </div>
                        </div>
                        <div class="bbb_viewed_slider_container">
                            <div class="owl-carousel owl-theme bbb_viewed_slider">
                                <?php foreach ($product as $key => $item) {?>
                                    <div class="card" style="border-radius:0">
                                        <img class="card-img" src="<?= $item['image'] ?>" style="height:180px; border-radius:0" alt="">
                                        <div class="card-img-overlay d-flex justify-content-end">
                                            <a href="#" class="card-link text-danger like">
                                                <i class="fas fa-heart"></i>
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <strong><?= $item['name'] ?></strong><br>
                                            <small class="card-subtitle mb-2 text-muted"><?= $item['code'] ?></small><br>
                                            <small class="card-subtitle mb-2 text-muted"><strong>Rp. <?= number_format($item['final_price']) ?></strong></small>
                                            <?= ($item['stock'] > 0) ? '' : '<small class="badge badge-danger">Stock Habis</small>' ?>
                                            <div class="buy d-flex justify-content-between align-items-center">
                                                <button type="button" id="<?= ($this->userdata) ? 'btn-cart-awal' : 'btn-login' ?>" data-id="<?= $item['id'] ?>" class="btn btn-sm btn-block btn-primary mt-3" <?= ($item['stock'] > 0) ? '' : 'disabled' ?>>
                                                    <i class="fas fa-shopping-cart"></i> Cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
        <div class="container" data-aos="zoom-in">

        <div class="text-center">
            <h3><?= $data['info_name'] ?></h3>
            <p><?= $data['info_about'] ?></p>
            <a class="cta-btn scrollto" href="<?= base_url('product') ?>">Belanja Yuk...</a>
        </div>

        </div>
    </section><!-- End Cta Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container">

            <div class="section-title">
                <h2>Temukan Kami</h2>
            </div>

        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <iframe style="border:0; width: 100%; height: 350px;" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=leuwiliang+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>

    </section>
    <!-- End Contact Section -->

</main>
<!-- End #main -->