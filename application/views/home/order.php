
<div id="main">
    <div id="loader" class="d-none"></div>
    <section id="cart" class="cart">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($order['is_paid'] == 0) { ?>
                        <div class="alert alert-info"><strong>Segera lakukan pembayaran!</strong></div>
                    <?php } ?>
                </div>
                <div class="col-md-8">
                    <div class="card shadow border-0">
                        <div class="card-header border-0 bg-info text-white">
                            <span><strong>Dibuat: </strong><?= $order['created_date'] ?></span>
                            <span class="float-right"><strong>No: </strong> <?= $order['code'] ?></span>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <h6 class="mb-1">Dari:</h6>
                                    <div>
                                        <strong>Toko Kitab H. Uding</strong> <br>
                                        <span id="branch_address"></span> <br>
                                        <span id="branch_phone"></span> <br>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <h6 class="mb-1">Kepada:</h6>
                                    <div>
                                        <strong><?= ucfirst($order['name']) ?></strong> <br>
                                        <span><?= $order['address'] ?></span> <br>
                                        <span><?= $order['province_name'].', '.$order['city_name'].', '.$order['postal_code'] ?></span> <br>
                                    </div>
                                </div>

                            </div>

                            <div class="table-responsive-sm">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Deskripsi</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th class="text-right">TotalTotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($order['detail'] as $key => $item) { ?>
                                            <tr>
                                                <td><?= $key+1 ?></td>
                                                <td><?= $item['name'].' / '.$item['code'] ?></td>
                                                <td><?= $item['qty'] ?></td>
                                                <td>Rp. <?= number_format($item['final_price']) ?></td>
                                                <td class="text-right">Rp. <?= number_format($item['total_price']) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">

                                <div class="col-lg-5 col-sm-5 ml-auto">
                                    <table class="table table-sm table-clear">
                                        <tbody>
                                            <tr>
                                                <td class="align-middle">
                                                    <strong>Sub Total</strong>
                                                </td>
                                                <td class="text-right">
                                                    <strong>Rp. <?= number_format($order['grand_total']) ?></strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle">
                                                    <strong>Biaya Pengiriman</strong>
                                                </td>
                                                <td class="text-right">
                                                    <strong>Rp. <?= number_format($order['courier_price']) ?></strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="align-middle">
                                                    <strong>Grand Total</strong>
                                                </td>
                                                <td class="text-right">
                                                    <strong>Rp. <?= number_format($order['final_total']) ?></strong>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="text-center"><strong><i>Terbilang : <?= terbilang($order['final_total']) ?></i></strong></h6>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow border-0">
                        <div class="card-header border-0 bg-info text-white">
                            <span>Metode Pembayaran</span>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="accordion" id="accordionBank">
                                        <?php foreach ($bank as $key => $item) { ?>
                                            <div class="card border-0 shadow">
                                                <div class="card-header border-0 bg-primary" id="headingOne<?= $key ?>">
                                                    <h6 class="m-0 p-0">
                                                        <a href="" class="text-white" data-toggle="collapse" data-target="#collapseOne<?= $key ?>" aria-expanded="true" aria-controls="collapseOne<?= $key ?>">
                                                            ATM <?= $item['name'] ?>
                                                        </a>
                                                    </h6>
                                                </div>
        
                                                <div id="collapseOne<?= $key ?>" class="collapse show" aria-labelledby="headingOne<?= $key ?>" data-parent="#accordionBank">
                                                    <div class="card-body">
                                                        <img class="float-right" src="<?= $item['image'] ?>" width="80" alt="">
                                                        <h5><?= $item['no_rekening'] ?></h5>
                                                        <h6><?= $item['atas_nama'] ?></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <a class="btn btn-outline-primary btn-block"  data-toggle="collapse" href="#confirm_payment">Konfirmasi Pembayaran</a>
                                    <div class="collapse mt-2" id="confirm_payment">
                                        <div class="card shadow card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?php if ($order['is_paid'] == 0) { ?>
                                                        <form action="" id="form-confirm">
                                                            <h6 class="text-center">Upload Bukti Transfer</h6>
                                                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                            <div class="input-group mb-3">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input file-upload" id="bukti_tf" name="bukti_tf" accept="image/*"/>
                                                                    <label class="custom-file-label" for="bukti_tf">Pilih file</label>
                                                                </div>
                                                            </div>
                                                            <div class="text-center mb-2">
                                                                <img class="profile-pic img-fliud img-thumbnail d-none" src="">
                                                            </div>
                                                            <button type="submit" class="btn btn-success btn-block">Submit</button>
                                                        </form>
                                                    <?php }else { ?>
                                                        <div class="text-center mb-2">
                                                            <h6 class="text-danger">Anda sudah melakukan pembayaran</h6>
                                                            <img class="profile-pic img-fliud img-thumbnail" src="<?= $order['bukti_tf'] ?>">
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(".file-upload").on('change', function(){
        readURL(this);
    });

    $('#form-confirm').submit(function(e){
        e.preventDefault(); 
        showLoad();
        let data = new FormData(this);
        setTimeout(() => {
            $.ajax({
                type: "post",
                url: "<?= base_url('order/confirm_payment') ?>",
                data: data,
                processData:false,
                contentType:false,
                cache:false,
                async:false,
                dataType: "json",
                success: function (res) {
                    if (res.type == 'success') {
                        Swal.fire('Berhasil', res.msg, 'success');
                        let url = "<?= base_url('mitra') ?>";
                        setTimeout(() => {
                            location.replace(url);
                        }, 2000);
                    }else{
                        Swal.fire('Opppss', res.msg, 'error');
                    }
                    hideLoad();
                }
            });
        }, 1000);
    });
</script>