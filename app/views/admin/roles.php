<?php
use \FW\View\View;
use \FW\Helpers\Common;
use \FW\Session\Session;
?>
<?= View::getLayoutData('header') ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-12">
                <?php if(Session::hasMessage()): ?>
                    <div class="alert alert-success" role="alert"><?= Session::getMessage() ?></div>
                <?php endif; ?>
                <?php if(Session::hasError()): ?>
                    <div class="alert alert-danger" role="alert"><?= Session::getError() ?></div>
                <?php endif; ?>
                <h1>Users</h1>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Tools</th>
                        <th>User Products</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($users as $u):
                        ?>
                        <tr>
                            <td><?= $u['username'] ?></td>
                            <td><?= $u['is_banned'] ? 'ban' : $u['role'] ?></td>
                            <td>
                            <?php if($u['role'] == 'admin'): ?>
                                <a class="btn btn-primary" href="<?= Common::getBaseURL() ?>/admin/make/<?= $u['id'] ?>/editor">Make Editor</a>
                                <a class="btn btn-warning" href="<?= Common::getBaseURL() ?>/admin/make/<?= $u['id'] ?>/user">Make User</a>
                            <?php elseif($u['role'] == 'editor'): ?>
                                <a class="btn btn-primary" href="<?= Common::getBaseURL() ?>/admin/make/<?= $u['id'] ?>/admin">Make Admin</a>
                                <a class="btn btn-warning" href="<?= Common::getBaseURL() ?>/admin/make/<?= $u['id'] ?>/user">Make User</a>
                            <?php else: ?>
                                <a class="btn btn-primary" href="<?= Common::getBaseURL() ?>/admin/make/<?= $u['id'] ?>/admin">Make Admin</a>
                                <a class="btn btn-warning" href="<?= Common::getBaseURL() ?>/admin/make/<?= $u['id'] ?>/editor">Make Editor</a>
                            <?php endif; ?>
                                <a class="btn btn-danger" href="<?= Common::getBaseURL() ?>/admin/ban/<?= $u['id'] ?>">Ban</a>
                            </td>
                            <td>
                                <a class="btn btn-default" href="<?= Common::getBaseURL() ?>/user/<?= $u['id'] ?>/products">User Products</a>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2015</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
<?= View::getLayoutData('footer') ?>