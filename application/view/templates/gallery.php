<div class="row" id="featured">
    <div class="col-sm-12">
        <div class="page-header text-muted">
            Gallery
        </div>
    </div>
</div>

<div id="galleryDropZone">
    <span>
        Drop photos here to download
    </span>
</div>

<div class="panel panel-default">
    <div class="panel-body row">
        <div class="col-md-3">
            sdgsgdfg
        </div>
        <div class="col-md-8">
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar">
                </div>
            </div>
        </div>
        <div class="col-md-1">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>

    </div>
</div>

<div class="row" id="galleryPhotos">
    <?php foreach($photos['photos'] as $photo):?>
    <div class="col-md-3 col-lg-4 col-sm-4 col-xs-12 thumb">
        <a>
            <img class="img-responsive" src="/application/data/users/<? echo $id; ?>/photos/<? echo $photo; ?>">
        </a>
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
