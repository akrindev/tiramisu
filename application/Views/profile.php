<div class="my-3 my-md-5">
  <div class="container">

                <div class="card card-profile">
                  <div class="card-header" style="background-image: url(/img/profile.jpg);"></div>
                  <div class="card-body text-center">
                    <img class="card-profile-img" src="<?=$poto;?>">
                    <h3 class="mb-3"><?=$nama?></h3>
                    <p class="mb-4">
                      Big belly rude boy, million dollar hustler. Unemployed.
                    </p>
                    <button class="btn btn-outline-primary btn-sm">
                      <span class="fa fa-twitter"></span> Follow
                    </button>
                  </div>
                </div>
    <?php if(session('user')):
   		 if(count($ucap) > 0): ?>

    <div class="row">
      <div class="col-xs-12 col-md-6">
	<div class="card">
      <div class="card-header">
        <h3 class="class-title">Ucapan pribadi saya</h3>
      </div>
      <table class="table card-table">
<?php foreach($ucap as $u): ?>

        <tr>
          <td width="70%"> <a href="/ucapan/lihat/<?=$u->slug?>"><?=substr($u->ucapan,0,20).'...'?> </a><br>
            <small class="text-muted"><?=$u->created_at?></small></td>
          <td> <a href="/ucapan/edit/<?=$u->slug?>" class="btn btn-sm btn-pill btn-outline-primary">edit</a> <a href="/ucapan/delete/<?=$u->slug?>" class="btn btn-sm btn-pill btn-outline-danger" onClick="if(confirm('Yakin mau ngehapus?')) { return true; } else { return false;}">hapus</a>  </td>
        </tr>
<?php endforeach;?>
      </table>
        </div>
      </div>
    </div>
    <?php endif; endif;?>
  </div>
</div>