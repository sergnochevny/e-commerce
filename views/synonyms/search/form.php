<form action="<?= $action ?>" method="post" data-search class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 panel panel-default search-panel">
      <div class="panel-heading">
        <div class="search-container-title">
          <div class="row">
            <div class="col-xs-1 col-sm-1"><i class="fa fa-2x fa-search"></i></div>
            <div class="h4 col-xs-10 search-result-list comment-text">
              <?=isset($search['keywords'])?'<div class="label label-search-info">Like: '.$search['keywords'].'</div>':''?>
              <?=isset($search['synonyms'])?'<div class="label label-search-info">Like: '.$search['synonyms'].'</div>':''?>
              <?= isset($search['active']) ? '<a data-search_reset title="Reset search" href="javascript:void(0)" class="reset"><i class="fa fa-2x fa-times" aria-hidden="true"></i></a>' : '' ?>
            </div>
            <b class="sr-ds"><i class="fa fa-2x fa-chevron-right"></i></b>
          </div>
        </div>
      </div>

      <div class="panel-body hidden">
        <div class="col-xs-12">
          <div class="form-row">
            <div class="row">
              <label>Keywords:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[keywords]"
                     value="<?= isset($search['keywords']) ? $search['keywords'] : '' ?>">
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <div class="form-row">
            <div class="row">
              <label>Synonyms:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[synonyms]"
                     value="<?= isset($search['synonyms']) ? $search['synonyms'] : '' ?>">
            </div>
          </div>
        </div>
      </div>

      <div class="panel-footer hidden">
        <div class="row">
          <div class="col-sm-12">
            <a data-search_submit class="button pull-right" href="<?= $action ?>">Search</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

