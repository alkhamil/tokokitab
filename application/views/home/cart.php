<div id="main">
    <div id="loader" class="d-none"></div>
    <section id="cart" class="cart">
        <div class="container" data-aos="fade-up">
            <h2 class="text-left">Keranjang Belanja</h2>
            <hr>
            <div class="row">
                <div class="col-md-7 mb-2">
                    <div class="card border-0 shadow">
                        <div class="card-header border-0 bg-primary">
                            <h5 class="p-0 m-0 text-white">Daftar Item</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tbody id="cart-view"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-2">
                    <div class="card border-0 shadow">
                        <div class="card-header border-0 bg-primary">
                            <h5 class="p-0 m-0 text-white">Total Item <span class="float-right"><div class="badge badge-danger" id="total_item">0</div></span></h5>
                        </div>
                        <div class="card-body">
                            <table class="table border-0 table-sm">
                                <tbody id="cart-view-detail">
                                    
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-lg-4 col-sm-5">
                                    
                                </div>

                                <div class="col-lg-6 col-sm-5 ml-auto">
                                    <table class="table table-sm table-clear">
                                        <tbody>
                                            <tr>
                                                <td class="text-left align-middle">
                                                    <strong>Grand Total</strong>
                                                </td>
                                                <td class="text-right">
                                                    <strong id="grand_total" class="text-info"></strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="col-md-12">
                                    <a href="<?= base_url('checkout') ?>" class="btn btn-block btn-outline-primary btn-checkout">Lanjutkan Pembayaran</a>
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
    getCartView();
    function getCartView(){
        $.ajax({
            type: "get",
            url: "<?= base_url('home/get_cart') ?>",
            dataType: "json",
            success: function (res) {
                $('#cart-view').html('');
                $('#cart-view-detail').html('');
                let count = res.length;
                $('#total_item').text(count);
                let grand_total = 0;
                $.each(res, function (index, dt) { 
                    index+=1;
                    grand_total+=parseInt(dt.total_price);
                    let cart_view = `<tr>
                                    <td width="150" class="align-middle">
                                        <img src="`+dt.image+`" class="img-fluid" alt="">
                                    </td>
                                    <td class="align-middle">
                                        <b>`+dt.name+`</b> /
                                        <small>`+dt.code+`</small> <br>
                                        <strong class="text-info">`+formatCurrency(dt.final_price)+`</strong>
                                    </td>
                                    <td width="100" class="align-middle">
                                        <input type="text" style="text-align:center" class="form-control form-control-sm input-qty" data-id=`+dt.id+` value="`+dt.qty+`">
                                    </td>
                                    <td class="align-middle" align="right">
                                        <span class="text-danger btn-del-item" data-id="`+dt.id+`" style="cursor:pointer" title="Hapus item">
                                            <i class="fa fa-trash"></i>  
                                        </span>
                                    </td>
                                </tr>`;
                    $('#cart-view').append(cart_view);

                    let cart_view_detail = `<tr>
                                                <td align="left">`+dt.name+` / `+dt.code+` x `+dt.qty+`</td>
                                                <td align="right"><span class="text-info">`+formatCurrency(dt.total_price)+`</span></td>
                                            </tr>`

                    $('#cart-view-detail').append(cart_view_detail);
                });

                $('#grand_total').text(formatCurrency(grand_total));
            }
        });
    }

    $(document).on("keyup.ev", ".input-qty", function(e) {
        let $this = $(this);
        let id = $this.attr('data-id');
        let qty = $this.val();

        $.ajax({
            type: "get",
            url: "<?= base_url('home/update_cart') ?>",
            data: {
                id:id,
                qty:qty
            },
            dataType: "json",
            success: function (res) {
                if (res.type == 'success') {
                    Swal.fire('Berhasil', res.msg, 'success');
                    getCart();
                    getCartView();
                }else{
                    Swal.fire('Opppss', res.msg, 'warning');
                }
            }
        });
    });

    $(document).on("click.ev", ".btn-del-item", function(e) {
        let $this = $(this);
        let id = $this.attr('data-id');

        $.ajax({
            type: "get",
            url: "<?= base_url('home/delete_cart') ?>",
            data: {
                id:id
            },
            dataType: "json",
            success: function (res) {
                if (res.type == 'success') {
                    Swal.fire('Berhasil', res.msg, 'success');
                    getCart();
                    getCartView();
                }else{
                    Swal.fire('Opppss', res.msg, 'warning');
                }
            }
        });
    });
</script>