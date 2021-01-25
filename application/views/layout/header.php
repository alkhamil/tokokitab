<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?= $title ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <?php 
    $data = $this->db->get_where('m_info', ['id'=>1])->row_array();
  ?>
  <link href="<?= $data['info_icon'] ?>" rel="icon">
  <link href="<?= $data['info_icon'] ?>" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url('assets') ?>/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url('assets') ?>/assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="<?= base_url('assets') ?>/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?= base_url('assets') ?>/assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="<?= base_url('assets') ?>/assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="<?= base_url('assets') ?>/assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="<?= base_url('assets') ?>/assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= base_url('assets') ?>/assets/css/style.css?n=26" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
  
  
  <!-- Vendor JS Files -->
  <script src="<?= base_url('assets') ?>/assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('assets') ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('assets') ?>/assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="<?= base_url('assets') ?>/assets/vendor/php-email-form/validate.js"></script>
  <script src="<?= base_url('assets') ?>/assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="<?= base_url('assets') ?>/assets/vendor/counterup/counterup.min.js"></script>
  <script src="<?= base_url('assets') ?>/assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="<?= base_url('assets') ?>/assets/vendor/venobox/venobox.min.js"></script>
  <script src="<?= base_url('assets') ?>/assets/vendor/aos/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <link rel="stylesheet" href="<?= base_url('assets/assets/vendor/datatables/dataTables.bootstrap4.css');?>">
  <script src="<?= base_url('assets/assets/vendor/datatables/jquery.dataTables.min.js');?>"></script>
  <script src="<?= base_url('assets/assets/vendor/datatables/dataTables.bootstrap4.min.js');?>"></script>

  <link rel="stylesheet" href="<?= base_url('assets/assets/vendor/daterangepicker/daterangepicker.css')?>" />
  <script src="<?= base_url('assets/assets/vendor/daterangepicker/moment.min.js')?>"></script>
  <script src="<?= base_url('assets/assets/vendor/daterangepicker/daterangepicker.min.js')?>"></script>

  <link rel="stylesheet" href="<?= base_url('assets/assets/vendor/select2/select2.min.css?n=3')?>" />
  <script src="<?= base_url('assets/assets/vendor/select2/select2.min.js')?>"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.js"></script>

  <script>
      function showLoad(){
          let style = {
              "pointer-events" : "none",
              "opacity" : 0.8
          }
          $('#loader').removeClass('d-none').parent().css(style);
      }

      function hideLoad(){
          $('#loader').addClass('d-none').parent().removeAttr('style');
      }

      var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.profile-pic').removeClass('d-none').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
      }

      function formatCurrency(amount, decimalCount = 2, decimal = ",", thousands = ".") {
            try {
                decimalCount = Math.abs(decimalCount);
                decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

                const negativeSign = amount < 0 ? "-" : "";

                let i = parseInt(amount = Math.abs(Number(amount) || 0)).toString();
                let j = (i.length > 3) ? i.length % 3 : 0;

                return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands);
            } catch (e) {
                console.log(e)
            }
        }

        function terbilang(bilangan) {

            bilangan    = String(bilangan);
            var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
            var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
            var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');

            var panjang_bilangan = bilangan.length;

            /* pengujian panjang bilangan */
            if (panjang_bilangan > 15) {
            kaLimat = "Diluar Batas";
            return kaLimat;
            }

            /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
            for (i = 1; i <= panjang_bilangan; i++) {
            angka[i] = bilangan.substr(-(i),1);
            }

            i = 1;
            j = 0;
            kaLimat = "";


            /* mulai proses iterasi terhadap array angka */
            while (i <= panjang_bilangan) {

            subkaLimat = "";
            kata1 = "";
            kata2 = "";
            kata3 = "";

            /* untuk Ratusan */
            if (angka[i+2] != "0") {
                if (angka[i+2] == "1") {
                kata1 = "Seratus";
                } else {
                kata1 = kata[angka[i+2]] + " Ratus";
                }
            }

            /* untuk Puluhan atau Belasan */
            if (angka[i+1] != "0") {
                if (angka[i+1] == "1") {
                if (angka[i] == "0") {
                    kata2 = "Sepuluh";
                } else if (angka[i] == "1") {
                    kata2 = "Sebelas";
                } else {
                    kata2 = kata[angka[i]] + " Belas";
                }
                } else {
                kata2 = kata[angka[i+1]] + " Puluh";
                }
            }

            /* untuk Satuan */
            if (angka[i] != "0") {
                if (angka[i+1] != "1") {
                kata3 = kata[angka[i]];
                }
            }

            /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
            if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
                subkaLimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
            }

            /* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
            kaLimat = subkaLimat + kaLimat;
            i = i + 3;
            j = j + 1;

            }

            /* mengganti Satu Ribu jadi Seribu jika diperlukan */
            if ((angka[5] == "0") && (angka[6] == "0")) {
            kaLimat = kaLimat.replace("Satu Ribu","Seribu");
            }

            return kaLimat + "Rupiah";
        }  

        getCart();
        function getCart(){
            $.ajax({
                type: "get",
                url: "<?= base_url('home/get_cart') ?>",
                dataType: "json",
                success: function (res) {
                    let count = res.length;
                    $('#cart-badge').text(count);
                    data = res;
                }
            });
        }
  </script>

</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

        <!-- Uncomment below if you prefer to use an image logo -->
        <h1 class="logo mr-auto"><a href="<?= base_url('/') ?>"><span class="d-none d-md-inline"><?= $data['info_name'] ?></span></a></h1>

        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li class="active">
                    <a href="<?= base_url('/') ?>">Beranda</a>
                </li>
                <li class="drop-down"><a href="#">Katalog</a>
                    <ul>
                        <?php 
                            $category = $this->db->get('m_category')->result_array();
                        ?>
                        <?php foreach ($category as $key => $c) { ?>
                            <li><a href="<?= base_url('product?katalog='.$c['id']) ?>"><?= $c['name'] ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li><a href="#contact">Temukan Kami</a></li>
            </ul>
        </nav>
        <!-- .nav-menu -->
        
        <a href="<?= base_url('cart') ?>" class="btn-link ml-3 border-0">
          <i class="fa fa-shopping-cart"><sup><div class="badge badge-danger" id="cart-badge">0</div></sup></i>
        </a>
        <?php if ($this->userdata) { ?>
          <a href="<?= base_url('mitra') ?>" style="text-decoration:none" class="btn-link ml-3 border-0">
            <i class="fa fa-user"></i> <?= $this->userdata->name ?>
          </a>
        <?php }else{ ?>
          <a href="#" id="btn-login" style="text-decoration:none" class="btn-link ml-3 border-0">
            <i class="fa fa-user"></i> <span class="d-none d-md-inline">Mitra</span> 
          </a>
        <?php } ?>

        

    </div>
  </header>
  <!-- End Header -->

 