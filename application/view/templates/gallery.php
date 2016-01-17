<div class="row" id="featured">
    <div class="col-sm-12">
        <div class="page-header text-muted">
            Gallery
        </div>
    </div>
</div>
<?php if($id == UserModel::getUserId()): ?>
    <div id="galleryDropZone">
        <span>
            Drop photos here to download
        </span>
    </div>
<?php endif; ?>

<div class="row" id="galleryPhotos">
    <?php foreach($photos['photos'] as $photo):?>
    <div class="col-md-3 col-lg-4 col-sm-4 col-xs-12 thumb">
        <a>
            <img class="img-responsive" src="/application/data/users/<? echo $id; ?>/photos/<? echo $photo; ?>">
        </a>
        <?php if($id == UserModel::getUserId()): ?>
            <a class="pull-right"><i class="fa fa-trash"></i></a>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>

<div class="modal" id="modal-gallery" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div id="modal-carousel" class="carousel">
                    <div class="carousel-inner">
                    </div>
                    <a class="carousel-control left" href="#modal-carousel" data-slide="prev">
                        <i class="glyphicon glyphicon-chevron-left"></i>
                    </a>
                    <a class="carousel-control right" href="#modal-carousel" data-slide="next">
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
