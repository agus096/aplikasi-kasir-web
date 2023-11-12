<!--navbar-->
<nav class="navbar navbar-expand-custom navbar-mainbg">
        <a class="navbar-brand navbar-logo" href="/cart/"> <img src="https://i.ibb.co/GHqxf1b/rest.png" width="30px"> <b> <?= $_SESSION['resto'] ?></b></a>
        <button class="navbar-toggler" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars text-white"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <div class="hori-selector"><div class="left"></div><div class="right"></div></div>
                <li class="nav-item">
                    <a class="nav-link" href="beranda"><i class="fa-solid fa-cash-register"></i>Kasir</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="orderan"><i class="fa-solid fa-list-check"></i>Orderan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="board"><i class="far fa-clone"></i>Board</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tambahproduk"><i class="fa-solid fa-burger"></i>Tambah produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="buatpotongan"><i class="fa-solid fa-tag"></i>Buat Promo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="customer"><i class="fa-solid fa-crown"></i>Customer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="panduan"><i class="fa-regular fa-life-ring"></i>Panduan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout"><i class="fa-solid fa-power-off"></i><?= $_SESSION['user'].' '.$_SESSION['jabatan']?></a>
                </li>
            </ul>
        </div>
    </nav>


    