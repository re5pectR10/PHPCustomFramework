<div class="col-md-3">
    <p class="lead">Categories</p>
    <?php if($isEditor): ?>
        <a href="<?= \FW\Common::getBaseURL() ?>/category/add" class="btn btn-success">Add</a>
    <?php endif ?>
    <div class="list-group">
        <?php
        foreach($categories as $p):
            ?>
            <div class="list-group-item">
                <a href="<?= \FW\Common::getBaseURL() ?>/category/<?= $p['id'] ?>" class="list-group-item <?= isset($currentCategory) && $currentCategory == $p['id'] ? 'list-group-item-success' : '' ?>">
                    <?= $p['name'] ?>

                </a>
                <?php if($isEditor): ?>
                    <a href="<?= \FW\Common::getBaseURL() ?>/category/delete/<?= $p['id'] ?>" class="btn btn-danger">Delete</a>
                    <a href="<?= \FW\Common::getBaseURL() ?>/category/edit/<?= $p['id'] ?>" class="btn btn-primary">Edit</a>
                <?php endif ?>
            </div>
        <?php
        endforeach;
        ?>
    </div>
</div>