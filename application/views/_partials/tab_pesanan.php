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
                                <th>Status</th>
                                <!-- <th>Tanggal</th> -->
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order as $key => $item) { ?>
                                <tr>
                                    <td><?= $key+1 ?></td>
                                    <td><?= $item['code'] ?></td>
                                    <td><b><?= number_format($item['final_total']) ?></b></td>
                                    <td>
                                        <?php if ($item['is_paid'] == 0) { ?>
                                            <div class="badge badge-danger">Belum Bayar</div>
                                        <?php }else { ?>
                                            <div class="badge badge-success">Sudah Bayar</div>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($item['status'] == 'pending') { ?>
                                            <div class="badge badge-danger"><?= ucfirst($item['status']) ?></div>
                                        <?php }else if($item['status'] == 'diterima') { ?>
                                            <div class="badge badge-success"><?= ucfirst($item['status']) ?></div>
                                        <?php }else if($item['status'] == 'sedang dalam pengiriman') { ?>
                                            <div class="badge badge-info"><?= ucfirst($item['status']) ?></div> <br>
                                            <small>Resi : <?= $item['no_resi'] ?></small>
                                        <?php }else { ?>
                                            <div class="badge badge-warning"><?= ucfirst($item['status']) ?></div>
                                        <?php } ?>
                                    </td>
                                    <!-- <td><?= $item['created_date'] ?></td> -->
                                    <td width="200" align="center">
                                        <?php if ($item['status'] == 'sedang dalam pengiriman') { ?>
                                            <button type="button" data-id="<?= $item['id'] ?>" class="btn btn-sm btn-success btn-received">Sudah diterima</button>
                                        <?php } ?>
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
    $(document).on("click.ev", ".btn-received", function (e) {
        e.preventDefault();
        showLoad();
        let $this = $(this);
        let id = $this.attr("data-id");
        setTimeout(() => {
            hideLoad();
            Swal.fire({
                title: 'Anda yakin ?',
                text: 'Pastikan barang sudah diterima',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "get",
                        url: "<?= base_url('order/order_received') ?>",
                        data: {
                            id:id
                        },
                        dataType: "json",
                        success: function (res) {
                            if (res.type == 'success') {
                                Swal.fire('Berhasil', res.msg, 'success')
                            }else{
                                Swal.fire('Opppss', res.msg, 'warning')
                            }   
                        }
                    });
                }
            })
        }, 1000);
    });
</script>