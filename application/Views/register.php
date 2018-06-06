<div class="divider"></div>
<div class="container">
  <div class="row">
    <div class="col-md-12">

      <?=form_open()?>
      <div class="form-group">
        <label> Username </label>
        <input type="text" name="username" class="form-control" placeholder="username" required>
        <?php if($errors->hasError('username')): ?>
        <?= $errors->showError('username') ?>
        <?php endif; ?>
      </div>


      <div class="form-group">
        <label> Email </label>
        <input type="email" name="email" class="form-control" placeholder="Email" required>
        <?php if($errors->hasError('email')): ?>
        <?= $errors->showError('email') ?>
        <?php endif; ?>
      </div>

      <div class="form-group">
        <label> Password </label>
        <input type="password" name="password" class="form-control" placeholder="password" required>
        <?php if($errors->hasError('password')): ?>
        <?= $errors->showError('password') ?>
        <?php endif; ?>
      </div>


      <div class="form-group">
        <label> Confirm Password </label>
        <input type="password" name="conf-password" class="form-control" placeholder="password" required>
        <?php if($errors->hasError('conf-password')): ?>
        <?= $errors->showError('conf-password') ?>
        <?php endif; ?>
      </div>

      <button type="submit" class="btn btn-default">Register</button>

      <?=form_close()?>

    </div>
  </div>
</div>