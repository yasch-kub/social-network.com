<div id="slider">
    <div class="col-md-1 arrow">
        <i class="fa fa-angle-left"></i>
    </div>
    <div class="col-md-10" id="slidePhoto">
        <div id="containerPhoto">
        <?php foreach ($user['photos'] as $index => $photo):?>
            <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail">
                    <img num="<? echo $index + 1; ?>" src="/application/data/users/<? echo $id; ?>/photos/<? echo $photo; ?>" alt="...">
                </a>
            </div>
        <?php endforeach ?>
        </div>
    </div>
    <div class="col-md-1 arrow">
        <i class="fa fa-angle-right"></i>
    </div>
</div>