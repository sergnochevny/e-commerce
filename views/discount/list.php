    <div class="text-center">
        <a href="<?= _A_::$app->router()->UrlTo('discounts/add');?>">
            <input type="submit" value="ADD DISCOUNT" class="button"/>
        </a>
        <br><br><br>
    </div>

    <div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Details</th>
                    <th>Enabled</th>
                    <th>Multiple</th>
                    <th>Coupon Code</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th><div class="text-center">Actions</div></th>
                </tr>
            </thead>
            <tbody>
                <?= $discounts_list; ?>
            </tbody>
        </table>
    </div>

    <br/>

    <script src="<?= _A_::$app->router()->UrlTo('views/js/discount/list.js');?>"></script>