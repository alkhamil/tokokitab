<div id="main">
    <div id="loader" class="d-none"></div>
    <section id="cart" class="cart">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-md-7 mb-2">
                    <div class="card border-0 shadow">
                        <div class="card-header border-0 bg-primary">
                            <h5 class="p-0 m-0 text-white">Data Pengiriman</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <h6 class="p-0 m-0">Tujuan Pengiriman</h6>
                                    <hr>
                                    <div>
                                        <strong><?= $customer->name ?> ( <?= $customer->phone ?> )</strong> <a href="<?= base_url('mitra') ?>">Edit Alamat <i class="fa fa-edit"></i></a>
                                        <p class="mt-2"><?= $customer->address ?></p>
                                        <p><?= $customer->city_name.', '.$customer->province_name.', '.$customer->postal_code ?></p>
                                    </div>
                                    <hr>
                                    <h6 class="p-0 m-0">Metode Pengiriman</h6>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <?= ($customer->city_name == '' || $customer->city_name == null) ? 'Alamat Harus di lengkapi!' : '' ?>
                                                <select <?= ($customer->city_name == '' || $customer->city_name == null) ? 'disabled' : '' ?> name="courier" id="courier" class="form-control" data-placeholder="Pilih Kurir" data-allow-clear="true" style="width:100%">
                                                    <option value="" disabled selected>Pilih</option>
                                                    <option value="jne">JNE</option>
                                                    <option value="pos">POS</option>
                                                    <option value="tiki">TIKI</option>
                                                </select>
                                            </div>
                                            <div id="detail-courier">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-2">
                    <div class="card border-0 shadow">
                        <div class="card-header border-0 bg-primary">
                            <h5 class="p-0 m-0 text-white">Ringkasan Belanja</h5>
                        </div>
                        <div class="card-body">
                            <h6>Item</h6>
                            <table class="table border-0 table-sm table-striped table-dashed">
                                <tbody id="cart-view-detail">
                                    
                                </tbody>
                            </table>
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <table class="table table-sm table-clear">
                                        <tbody>
                                            <tr>
                                                <td class="text-left align-middle">
                                                    <strong>Sub Total</strong>
                                                </td>
                                                <td class="text-right">
                                                    <strong id="sub_total" class="text-info"></strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-left align-middle">
                                                    <strong>Biaya Pengiriman</strong>
                                                </td>
                                                <td class="text-right">
                                                    <strong id="courier_price" class="text-info">0</strong>
                                                </td>
                                            </tr>
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
                                    <form action="" id="form-payment">
                                        <input type="hidden" name="courier_price">
                                        <button type="submit" class="btn btn-block btn-primary btn-payment" disabled style="cursor:not-allowed">Bayar Sekarang</button>
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
    getCartView();
    let sub_total = 0;
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
                $.each(res, function (index, dt) { 
                    index+=1;
                    sub_total+=parseInt(dt.total_price);
                    let cart_view_detail = `<tr>
                                                <td align="left">`+dt.name+` / `+dt.code+` x `+dt.qty+`</td>
                                                <td align="right"><span class="text-info">`+formatCurrency(dt.total_price)+`</span></td>
                                            </tr>`

                    $('#cart-view-detail').append(cart_view_detail);
                });

                $('#sub_total').text(formatCurrency(sub_total));
                $('#grand_total').text(formatCurrency(sub_total));
            }
        });
    }

    $('#courier').select2().on('select2:select', function(e){
        showLoad();
        let courier = e.params.data.id;
        $.ajax({
            type: "get",
            url: "<?= base_url('checkout/get_cost') ?>",
            data: {
                courier:courier 
            },
            dataType: "json",
            success: function (res) {
                let detail_courier = $('#detail-courier');
                detail_courier.html('');
                if (res.rajaongkir.results.length > 0) {
                    $.each(res.rajaongkir.results, function (index, data) { 
                         let card = `<div class="card border-0 shadow">
                                        <div class="card-header border-0 bg-primary">
                                            <h5 class="p-0 m-0 text-white" id="courier_name">`+data.name+`</h5>
                                        </div>
                                        <div class="card-body" id="detail_courier_data"></div>
                                    </div>`
                         detail_courier.append(card);
                         $.each(data.costs, function (i, dt) { 
                            let radio = `<div class="form-check" style="cursor:pointer">
                                            <input class="form-check-input select-courier" style="cursor:pointer" data-value="`+dt.cost[0].value+`" type="radio" name="courier_name" id="courier_id_`+i+`" value="">
                                            <label class="form-check-label" style="cursor:pointer" for="courier_id_`+i+`">
                                                `+dt.service+`
                                            </label>
                                            <span class="float-right text-info">Rp. `+formatCurrency(dt.cost[0].value)+` ( `+dt.cost[0].etd+` HARI )</span>
                                        </div>`;
                            $('#detail_courier_data').append(radio);
                         });
                    });
                }
                hideLoad();
            }
        });
    }).on('select2:unselect', function(e){
        showLoad();
        setTimeout(() => {
            $('#detail-courier').html('');
            hideLoad();
            $('#courier_price').text(0);
            $('#form-payment').find('[name=courier_price]').val(0);
            $('#grand_total').text(formatCurrency(sub_total));
            $('.btn-payment').prop('disabled', true).css('cursor', 'not-allowed');
        }, 800);
    });

    $(document).on("click.ev", ".select-courier", function(e){
        showLoad();
        let value = $(this).attr('data-value');
        let grand_total = sub_total + parseInt(value);
        setTimeout(() => {
            $('#courier_price').text(formatCurrency(value));
            $('#form-payment').find('[name=courier_price]').val(value);
            $('#grand_total').text(formatCurrency(grand_total));
            $('.btn-payment').prop('disabled', false).css('cursor', 'pointer');
            hideLoad();
        }, 800);
    });

    $('#form-payment').submit(function(e){
        showLoad();
        e.preventDefault(); 
        let data = new FormData(this);
        setTimeout(() => {
            $.ajax({
                type: "post",
                url: "<?= base_url('checkout/payment_proses') ?>",
                data: data,
                processData:false,
                contentType:false,
                cache:false,
                async:false,
                dataType: "json",
                success: function (res) {
                    if (res.type == 'success') {
                        Swal.fire('Berhasil', res.msg, 'success');
                        setTimeout(() => {
                            let url = "<?= base_url('order?order_id=') ?>" + res.order_id
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