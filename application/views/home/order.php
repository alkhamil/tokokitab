
<div id="main">
    <div id="loader" class="d-none"></div>
    <section id="cart" class="cart">
        <div class="container" data-aos="fade-up">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <div class="text-center">
                                <i class="fa fa-check text-success fa-4x"></i>
                                <h2>Pesanan berhasil</h2>
                                <h6 class="text-info">Silahkan lakukan pembayaran</h6>
                            </div>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-left">No Pesanan</td>
                                        <td class="text-right"><?= $order->code ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Total Pembayaran</td>
                                        <td class="text-right text-info">Rp <?= number_format($order->final_total) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="card border-0 shadow">
                                <div class="card-header border-0 bg-primary">
                                    <h5 class="p-0 m-0 text-white">Pilih Rekening</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-check" style="cursor:pointer">
                                        <input class="form-check-input" style="cursor:pointer" type="radio" name="atm" id="mandiri" value="">
                                        <label class="form-check-label" style="cursor:pointer" for="mandiri">
                                            Mandiri
                                        </label>
                                        <span class="float-right text-info">1330013321153 (an / Nazmudin)</span>
                                    </div>
                                    <hr>
                                    <form action="">
                                        <div class="form-group">
                                            <input type="file" name="bukti_tf" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-block btn-primary">Konfirmasi Pemabayaran</button>
                                        </div>
                                    </form>
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
    
</script>