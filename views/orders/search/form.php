<form action="<?= $action ?>" method="post" data-search class="col-xs-12">
    <div class="row">
        <div class="col-xs-12 panel panel-default search-panel">
            <div class="panel-heading">
                <div class="h4 search-container-title">
                    <div class="row">
                        <div class="col-xs-1 col-sm-2"><i class="fa fa-search"></i></div>
                        <div class="col-xs-9 comment-text">
                            <?= isset($search['pname']) ? '<span>Like: </span><b>' . $search['pname'] . '</b>' : '' ?>
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
                            <label>Order transaction code:</label>
                            <input type="text" class="input-text" placeholder="Like ..." name="search[trid]"
                                   value="<?= isset($search['trid']) ? $search['trid'] : '' ?>">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-row">
                            <label>Customer:</label>
                            <input type="text" class="input-text" placeholder="Like ..." name="search[full_name]"
                                   value="<?= isset($search['name']) ? $search['name'] : '' ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <div class="form-row">
                            <label>Date ranges from:</label>
                            <input type="text" class="input-text" id="date-from" placeholder="Chose start date"
                                   name="search[order_date][starts]"
                                   value="<?= isset($search['order_date']['starts']) ? $search['order_date']['starts'] : '' ?>">
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-row">
                            <label>Date ranges to:</label>
                            <input type="text" class="input-text" id="date-to" placeholder="Chose end date"
                                   name="search[order_date][ends]"
                                   value="<?= isset($search['order_date']['ends']) ? $search['order_date']['ends'] : '' ?>">
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-row">
                            <label>Status:</label>
                            <select name="" id="">
                                <option value selected>Any</option>
                                <option value="0" <?= isset($search['status']) && $search['status'] == 0 ? 'selected' : '' ?>>In process</option>
                                <option value="1" <?= isset($search['status']) && $search['status'] == 1 ? 'selected' : '' ?>>Completed</option>
                            </select>
                        </div>
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
<script src='<?= _A_::$app->router()->UrlTo('views/js/search.js'); ?>' type="text/javascript"></script>