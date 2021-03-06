<div class="container-fluid p-5">
    <h1 class="h3 mb-4 text-gray-800"><?='Selamat datang <b>' . ucwords($user['first_name']) .' ' . ucwords($user['last_name']) . ' !!</b>';?></h1>
    <div class="card mb-3" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-4">
            <img src="<?=base_url('assets/img/users/' . $user['img_url']);?>" class="img-fluid p-3" alt="profile">
            </div>
            <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title">Profil</h5>
                <p class="card-text">Hi, Saya <?= ucwords($user['first_name']) .' ' . ucwords($user['last_name']) . '.'; ?></p>
                <p class="card-text"><small class="text-muted">Saya dari departemen <?= ucwords(strtolower($user['dept_name'])); ?>.</small></p>
                <footer class="blockquote-footer">Aktif sejak <?= date('d F Y', strtotime($user['created_date'])); ?></footer>
            </div>
            </div>
        </div>
    </div>
</div>