<div id="main">
    <div id="loader" class="d-none"></div>
    <section id="mitra" class="mitra">
        <div class="container" data-aos="fade-up">
            <h2 class="text-left">Hallo, <?= $this->userdata->name ?></h2>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <div class="nav shadow p-3 flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" data-url="<?= $tab_home ?>" role="tab" aria-controls="v-pills-home" aria-selected="true">
                           <i class="fa fa-home fa-fw"></i> Home
                        </a>
                        <a class="nav-link" id="v-pills-pesanan-tab" data-toggle="pill" href="#v-pills-pesanan" data-url="<?= $tab_pesanan ?>" role="tab" aria-controls="v-pills-pesanan" aria-selected="false">
                            <i class="fa fa-shopping-cart fa-fw"></i> Pesanan
                        </a>
                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" data-url="<?= $tab_profile ?>" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                            <i class="fa fa-user fa-fw"></i> Profile
                        </a>
                        <a class="nav-link" id="v-pills-address-tab" data-toggle="pill" href="#v-pills-address" data-url="<?= $tab_address ?>" role="tab" aria-controls="v-pills-address" aria-selected="false">
                            <i class="fa fa-map fa-fw"></i> Alamat
                        </a>
                        <a class="nav-link" href="<?= base_url('auth/logout') ?>">
                           <i class="fa fa-arrow-left fa-fw"></i> Logout
                        </a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab"></div>
                        <div class="tab-pane fade" id="v-pills-pesanan" role="tabpanel" aria-labelledby="v-pills-pesanan-tab"></div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab"></div>
                        <div class="tab-pane fade" id="v-pills-address" role="tabpanel" aria-labelledby="v-pills-address-tab"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<script>

    getPage();
    getProfile();

    $('[data-toggle="pill"]').click(function(e) {
        let $this = $(this);
        let data_url = $this.attr('data-url');
        let href = $this.attr('href');
        console.log(href);

        $.get(data_url, function(data) {
            $(href).html(data);
        });

        $this.tab('show');
        return false;
    });

    function getPage(){
        let $start = $('#mitra, #nav');
        let $data_url = $start.find('.active').attr('data-url')
        let $href = $start.find('.active').attr('href')
        $.get($data_url, function(data) {
            $($href).html(data);
        });
        $start.find('.active').tab('show');
    }

    function getProfile(){
        var response = null;
        $.ajax({
            type: "get",
            url: "<?= $get_profile ?>",
            dataType: "json",
            async:false,
            success: function (res) {
                // profile
                if (res.avatar) {
                    $('#form-profile').find('.profile-pic').attr('src', res.avatar);
                }
                $('#form-profile').find('[name=name]').val(res.name);
                $('#form-profile').find('[name=birthday]').val(res.birthday);
                $('#form-profile').find('[name=phone]').val(res.phone);
                $('#form-profile').find('[name=email]').val(res.email);

                // alamat
                $('#form-address').find('[name=postal_code]').val(res.postal_code);
                $('#form-address').find('[name=address]').val(res.address);
                response = res;
            }
        });
        return response;
    }

</script>