<div class="card shadow p-3 border-0" style="border-radius:0">
    <div class="card-body">
        <h5>Pesanan</h5>
        <hr class="hr-dashed">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-sm table-striped" id="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>No Pesanan</th>
                                <th>Total</th>
                                <th>Pembayaran</th>
                                <th>Pengiriman</th>
                                <th>Tanggal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order as $key => $item) { ?>
                                <tr>
                                    <td><?= $key+1 ?></td>
                                    <td><?= $item['code'] ?></td>
                                    <td><b>Rp. <?= number_format($item['final_total']) ?></b></td>
                                    <td>
                                        <?php if ($item['is_paid'] == 0) { ?>
                                            <div class="badge badge-danger">Belum Bayar</div>
                                        <?php }else { ?>
                                            <div class="badge badge-success">Lunas</div>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($item['is_delivered'] == 0) { ?>
                                            <div class="badge badge-danger">Pending</div>
                                        <?php }else { ?>
                                            <div class="badge badge-success">Terkirim</div>
                                        <?php } ?>
                                    </td>
                                    <td><?= $item['created_date'] ?></td>
                                    <td>
                                        <a href="<?= base_url('order?order_id='.$item['id']) ?>" class="btn btn-sm btn-primary">Lihat</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#table').DataTable();
</script>