<form action="<?= $action ?>" data-search>
  <div class="col-xs-12 panel panel-default search-panel">
    <h4 class="panel-heading search-container-title"><b>Search</b><b class="sr-ds"><i
          class="fa fa-chevron-right"></i></b>
    </h4>

    <div class="panel-body hidden">
      <div class="col-xs-12">
        <div class="form-row">
          <div class="row">
            <label>Colour Name:</label>
            <input type="text" class="input-text" placeholder="Name like" name="search[colour]">
          </div>
        </div>
      </div>
    </div>

    <div class="panel-footer hidden">
      <input data-search_reset type="reset" class="btn" value="Reset">
      <a data-search_submit type="button" class="btn pull-right">Search</a>
    </div>
  </div>
</form>
