<div class="card shadow p-3 border-0" style="border-radius:0">
    <div class="card-body">
        <h5>Alamat</h5>
        <hr class="hr-dashed">
        <form action="" id="form-address">
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="province_id" class="label-required">Provinsi</label>
                        <select name="province_id" id="province_id" class="form-control" required></select>
                        <input type="hidden" name="province_name" id="province_name" class="form-control" requred>
                    </div>
                    <div class="form-group">
                        <label for="city_id" class="label-required">Kota / Kabupaten</label>
                        <select name="city_id" id="city_id" class="form-control" style="width:100%" required></select>
                        <input type="hidden" name="city_name" id="city_name" class="form-control" requred>
                    </div>
                    <div class="form-group">
                        <label for="postal_code" class="label-required">Postal Code</label>
                        <input type="text" name="postal_code" id="postal_code" class="form-control" requred>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address">ALamat Lengkap</label>
                        <textarea name="address" id="address" class="form-control" cols="10" rows="3"></textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    showLoad();
    var getProfileData = getProfile();

    $.ajax({
        type: "get",
        url: "<?= $select_province ?>",
        dataType: "json",
        success: function (res) {
            let data = JSON.parse(res).rajaongkir.results;
            $.each(data, function (i, dt) { 
                let selected = (parseInt(getProfileData.province_id) == parseInt(dt.province_id)) ? 'selected' : '';
                if (selected != '') {
                    getCity(getProfileData.province_id);
                }
                let opt = `<option value="`+dt.province_id+`" `+selected+`>`+dt.province+`</option>`;
                $('#province_id').append(opt);
            });
            hideLoad();
        }
    });

    var province_id;
    $('#province_id').on('change', function(){
        let $this = $(this);
        province_id = $this.val();
        getCity(province_id);
    });

    function getCity(province_id){
        showLoad();
        $('#city_id').html('');
        $('#postal_code').val('');
        $.ajax({
            type: "get",
            url: "<?= $select_city ?>",
            data:{
                province_id:province_id
            },
            dataType: "json",
            success: function (res) {
                let data = JSON.parse(res).rajaongkir.results;
                $.each(data, function (i, dt) { 
                    let selected = (parseInt(getProfileData.city_id) == parseInt(dt.city_id)) ? 'selected' : '';
                    if (selected != '') {
                        province_id = getProfileData.province_id;
                        getPostalCode(getProfileData.city_id);
                        $('#postal_code').val(getProfileData.postal_code);
                    }
                    let opt = `<option value="`+dt.city_id+`" `+selected+`>`+dt.type+` - `+dt.city_name+`</option>`;
                    $('#city_id').append(opt);
                });
                hideLoad();
            }
        });
    }

    var city_id;
    $('#city_id').on('change', function(){
        let $this = $(this);
        city_id = $this.val();
        getPostalCode(city_id);
    });

    function getPostalCode(city_id){
        showLoad();
        $.ajax({
            type: "get",
            url: "<?= $select_city ?>",
            data:{
                province_id:province_id,
                city_id:city_id
            },
            dataType: "json",
            success: function (res) {
                let data = JSON.parse(res).rajaongkir.results;
                $('#province_name').val(data.province);
                $('#city_name').val(data.type + '-' + data.city_name);
                // $('#postal_code').val(data.postal_code);
                hideLoad();
            }
        });
    }

    $('#form-address').submit(function(e){
        e.preventDefault(); 
        showLoad();
        let data = new FormData(this);
        setTimeout(() => {
            $.ajax({
                type: "post",
                url: "<?= $update_address ?>",
                data: data,
                processData:false,
                contentType:false,
                cache:false,
                async:false,
                dataType: "json",
                success: function (res) {
                    if (res.type == 'success') {
                        Swal.fire('Berhasil', res.msg, 'success');
                        getPage();
                        getProfile();
                    }else{
                        Swal.fire('Opppss', res.msg, 'error');
                    }
                    hideLoad();
                }
            });
        }, 1000);
    });

    
</script>