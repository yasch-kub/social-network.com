<div id="slider">
    <div class="col-md-1 arrow">
        <i class="fa fa-angle-left"></i>
    </div>
    <div class="col-md-10" id="slidePhoto">
        <div id="containerPhoto">
        <?php foreach ($user['photos'] as $index => $photo):?>
            <div>
                <a href="#" class="thumbnail">
                    <img num="<? echo $index + 1; ?>" src="/application/data/users/<? echo $id; ?>/photos/<? echo $photo; ?>">
                </a>
            </div>
        <?php endforeach ?>
        </div>
    </div>
    <div class="col-md-1 arrow">
        <i class="fa fa-angle-right"></i>
    </div>
</div>