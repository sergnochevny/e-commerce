<center>
    <a href="<?php echo $base_url;?>/add_discounts"><input type="submit" value="ADD DISCOUNT" class="button"/></a><br><br><br>
</center>

<div class="">
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>
                Details
            </th>
            <th>
                Enabled
            </th>
            <th>
                Multiple
            </th>
            <th>
                Coupon Code
            </th>
            <th>
                Start Date
            </th>
            <th>
                End Date
            </th>
            <th style="">
                <center>Actions</center>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        echo $discounts_list;
        ?>
        </tbody>
    </table>
</div>
<br/>
<script type="text/javascript">
    (function($){
        $('a').on('click',
            function(event){
                $('body').waitloader('show');
            }
        );
    })(jQuery);
</script>