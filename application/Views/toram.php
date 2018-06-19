
        <div class="my-3 my-md-5">
          <div class="container">
        <h1>Selamat datang!</h1>

        Jelajahi informasi Toram Online, senjata, armor, drop dan lainnya.

       <hr>
        <?= view('cari')?>



      <?php if(session('sukses')):?>
                  <div class="card-alert alert alert-success mb-0">
                    <?=session('sukses')?>
                  </div>
            <hr>
      <?php endif; ?>


      <?php if(session('gagal')):?>
                  <div class="card-alert alert alert-danger mb-0">
                    <?=session('gagal')?>
                  </div>
            <hr>
      <?php endif; ?>

        <?php if(session('user') && session('role') != 'user'):?>
                    <a href="/store-equip" class="btn btn-secondary">Tambah data equip</a>
                    <a href="/store-mob" class="btn btn-secondary">Tambah data monster</a>
                    <a href="/store-crysta" class="btn btn-secondary">Tambah data crysta</a>

                    <a href="/fill_stats/add" class="btn btn-secondary">Tambah data fill stats</a>
                    <?php endif;?>
      </div>
    </div>