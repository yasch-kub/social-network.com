<div class="row" id="featured">
    <div class="col-sm-12">
        <div class="page-header text-muted">
            <? echo $dictionary['setting'] ?>
            <i class="pull-right fa fa-reply-all"></i>
        </div>
    </div>
</div>


<div class="row info-block">
    <div class="profile-property col-md-4">
        <? echo $dictionary['bg'] ?>
    </div>
    <div class="col-md-6">
       <input id="bg" type="text" class="form-control form-group" placeholder="<? echo $dictionary['settplaceholder'] ?>">
    </div>
    <div class="profile-property col-md-4">
        <? echo $dictionary['usercolor'] ?>
    </div>
    <div class="col-md-6">
        <input id="mcolor" type="text" class="form-control form-group " placeholder="<? echo $dictionary['settplaceholder'] ?>">
    </div>

    <div class="profile-property col-md-4">
        <? echo $dictionary['userhover'] ?>
    </div>
    <div class="col-md-6">
        <input id="mhover" type="text" class="form-control form-group" placeholder="<? echo $dictionary['settplaceholder'] ?>">
    </div>

    <div class="profile-property col-md-4">
        <? echo $dictionary['useractive'] ?>
    </div>
    <div class="col-md-6">
        <input id="mactive" type="text" class="form-control form-group" placeholder="<? echo $dictionary['settplaceholder'] ?>">
    </div>
</div>

<div class="row form-group">
    <button type="button" class="center-block btn btn-success"><? echo $dictionary['change'] ?></button>
</div>

<div class="row">
    <div class="center-block col-lg-5 col-md-5 form-group">
        <label class="center-block">Виберіть мову:
            <select id="changeLang" class="form-control form-group">
                <option value="eng" <?php if (UserModel::getLanguage() == 'eng') echo 'selected'; ?>>English</option>
                <option value="ukr" <?php if (UserModel::getLanguage() == 'ukr') echo 'selected'; ?>>Українська</option>
            </select>
        </label>
    </div>
</div>