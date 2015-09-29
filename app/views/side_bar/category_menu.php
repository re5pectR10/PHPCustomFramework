<div class="col-md-3">
    <p class="lead">Shop Name</p>
    <div class="list-group">
        <?php
        foreach($categories as $p):
            ?>
            <a href="<?= \FW\Common::getBaseURL() ?>/category/<?= $p['id'] ?>" class="list-group-item <?= isset($currentCategory) && $currentCategory == $p['id'] ? 'list-group-item-success' : '' ?>"><?= $p['name'] ?></a>
        <?php
        endforeach;
        ?>
    </div>
</div>