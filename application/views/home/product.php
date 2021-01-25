<div id="main">
    <div id="loader" class="d-none"></div>
    <section id="cart" class="cart">
        <div class="container" data-aos="fade-up">
            <h2 class="text-left">Product Kami</h2>
            <hr>
            <header class="border-bottom mb-4 pb-3">
                    <div class="form-inline">
                        <span class="mr-md-auto"><?= count($product) ?> Items ditemukan </span>
                        <form action="" id="form-filter">
                            <input type="text" name="q" placeholder="Cari produk.." class="form-control mr-2" value="<?= $this->input->get('q') ?>">
                            <select class="form-control" id="katalog" name="katalog">
                                <option value="" selected>Pilih Semua</option>
                                <?php foreach ($category as $key => $item) { ?>
                                    <option value="<?= $item['id'] ?>" 
                                        <?= ($item['id'] == $this->input->get('katalog')) ? 'selected' : '' ?> ><?= $item['name'] ?></option>
                                <?php } ?>
                            </select>
                        </form>
                    </div>
            </header><!-- sect-heading -->
            <div class="row">
            <?php foreach($product as $item){ ?>
                <div class="col-md-3 mb-1">
                    <div class="card" style="border-radius:0">
                        <img class="card-img" src="<?= $item->image ?>" style="height:180px; border-radius:0" alt="">
                        <div class="card-img-overlay d-flex justify-content-end">
                            <a href="#" class="card-link text-danger like">
                                <i class="fas fa-heart"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <strong><?= $item->name ?></strong><br>
                            <small class="card-subtitle mb-2 text-muted"><?= $item->code ?></small><br>
                            <small class="card-subtitle mb-2 text-muted"><strong>Rp. <?= number_format($item->final_price) ?></strong></small>
                            <?= ($item->stock > 0) ? '' : '<small class="badge badge-danger">Stock Habis</small>' ?>
                            <div class="buy d-flex justify-content-between align-items-center">
                                <button type="button" id="<?= ($this->userdata) ? 'btn-cart-awal' : 'btn-login' ?>" data-id="<?= $item->id ?>" class="btn btn-sm btn-block btn-primary mt-3" <?= ($item->stock > 0) ? '' : 'disabled' ?>>
                                    <i class="fas fa-shopping-cart"></i> Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div> <!-- row end.// -->


            <div class="row">
                <div class="col">
                    <hr>
                    <?php echo $links; ?> 
                </div>
            </div>
            <!-- <nav class="mt-4" aria-label="Page navigation sample">
                <ul class="pagination">
                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav> -->
        </div>
    </section>

</div>

<script>
$(document).ready(function() {
  $('#katalog').on('change', function() {
    $('#form-filter').submit();
  });
});
</script>