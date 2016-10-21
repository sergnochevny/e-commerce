<form action="<?= $action ?>" method="post" data-search class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 panel panel-default search-panel">
      <div class="panel-heading">
        <div class="h4 search-container-title">
          <div class="row">
            <div class="col-xs-1 col-sm-2"><i class="fa fa-search"></i></div>
            <div class="col-xs-9 comment-text">
              <?=isset($search['colour'])?'<span>Like: </span><b>'.$search['colour'].'</b>':''?>
            </div>
            <b class="sr-ds">
              <i class="fa fa-chevron-right"></i>
            </b>
          </div>
        </div>
      </div>

      <div class="panel-body hidden">

        <div class="row">
          <div class="col-xs-6">
            <div class="form-row">
                <label>Title Name:</label>
                <input type="text" class="input-text" placeholder="Like ..." name="search[]"
                       value="<?= isset($search['colour']) ? $search['colour'] : '' ?>">
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-row">
                <label>Chose Category Name:</label>
                <select name="" id="">
                  <?php
                    // TODO REFACTOR THIS CODE!!! FOR DEMO ONLY
                    $categories = Model_Blogcategory::get_all();
                    foreach($categories as $category):
                  ?>
                  <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                  <?php endforeach; ?>
                </select>
            </div>
          </div>
        </div>

        <div class="row">

            <div class="col-xs-6">
              <div class="form-row">
                  <label for="discount_on">
                    Date ranges from:
                    <input type="text" id="discount_starts" placeholder="Chose start date" class="input-text" name="search[]"
                      value="<?= isset($search['']) ? $search[''] : '' ?>">
                  </label>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="form-row">
                  <label for="discount_on">
                    Date ranges to:
                    <input type="text" id="discount_ends" placeholder="Chose end date" class="input-text" name="search[]"
                           value="<?= isset($search['']) ? $search[''] : '' ?>">
                  </label>
              </div>
            </div>

      </div>

      <div class="panel-footer hidden">
        <a data-search_submit class="btn button pull-right">Search</a>
        <a data-search_reset class="btn reset">Reset</a>
      </div>
    </div>
  </div>
</form>
<script src="<?= _A_::$app->router()->UrlTo('views/js/discount/search.js'); ?>"></script>