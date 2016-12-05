<form action="<?= $action ?>" method="post" data-search class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 panel panel-default search-panel">
      <div class="panel-heading">
        <div class="search-container-title">
          <div class="row">
            <div class="col-xs-1 col-sm-1"><i class="fa fa-2x fa-search"></i></div>
            <div class="h4 col-xs-10 search-result-list comment-text">
              <?php if(isset($search['email'])): ?>
                <div class="label label-search-info">Email Like:<?= $search['email'] ?></div>
              <?php endif; ?>
              <?php if(isset($search['full_name'])): ?>
                <div class="label label-search-info">Full Name Like: <?= $search['full_name'] ?></div>
              <?php endif; ?>
              <?php if(isset($search['organization'])): ?>
                <div class="label label-search-info">Organization Like: <?= $search['organization'] ?></div>
              <?php endif; ?>
              <?php if(isset($search['address'])): ?>
                <div class="label label-search-info">Address Like: <?= $search['address'] ?></div>
              <?php endif; ?>
              <?php if(isset($search['country'])): ?>
                <div class="label label-search-info">Country: <?= $search['countries'][$search['country']] ?>
                </div>
              <?php endif; ?>
              <?php if(isset($search['province'])): ?>
                <div class="label label-search-info">State: <?= $search['states'][$search['province']] ?>
                </div>
              <?php endif; ?>
              <?php if(!empty($search['registered']['from'])): ?>
                <div class="label label-search-info">
                  Date from: <?= $search['registered']['from'] ?></div>
              <?php endif; ?>
              <?php if(!empty($search['registered']['to'])): ?>
                <div class="label label-search-info">
                  Date to: <?= $search['registered']['to'] ?></div>
              <?php endif; ?>
              <?php if(isset($search['city'])): ?>
                <div class="label label-search-info">City Like: <?= $search['city'] ?>
                </div>
              <?php endif; ?>
              <?php if(isset($search['postal'])): ?>
                <div class="label label-search-info">Postal Code: <?= $search['postal'] ?>
                </div>
              <?php endif; ?>
              <?php if(isset($search['phone'])): ?>
                <div class="label label-search-info">Phone Like: <?= $search['phone'] ?>
                </div>
              <?php endif; ?>
              <?= isset($search['active']) ? '<a data-search_reset href="javascript:void(0)" title="Reset search" class="reset"><i class="fa fa-2x fa-times" aria-hidden="true"></i></a>' : '' ?>
            </div>
            <b class="sr-ds">
              <i class="fa fa-2x fa-chevron-right"></i>
            </b>
          </div>
        </div>
      </div>

      <div class="panel-body hidden">
        <div class="row">
          <div class="col-sm-4">
            <div class="form-row">
              <label>User Email:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[email]"
                     value="<?= isset($search['email']) ? $search['email'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-8">
            <div class="form-row">
              <label>User Full Name:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[full_name]"
                     value="<?= isset($search['full_name']) ? $search['full_name'] : '' ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-row">
              <label>Organization Name:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[organization]"
                     value="<?= isset($search['organization']) ? $search['organization'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-row">
              <label>Address:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[address]"
                     value="<?= isset($search['address']) ? $search['address'] : '' ?>">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-row">
              <label>Country:</label>
              <select data-change-province data-destination="search[province]" name="search[country]">
                <option value="" <?= isset($search['country']) ? '' : 'selected' ?>>Any</option>
                <?php if(isset($search['countries'])): ?>
                  <?php foreach($search['countries'] as $key => $val): ?>
                    <option
                      value="<?= $key ?>" <?= (isset($search['country']) && ($key == $search['country'])) ? 'selected' : '' ?>>
                      <?= $val ?>
                    </option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-row">
              <label>State:</label>
              <select name="search[province]">
                <option value="" <?= isset($search['province']) ? '' : 'selected' ?>>Any</option>
                <?php if(isset($search['states'])): ?>
                  <?php foreach($search['states'] as $key => $val): ?>
                    <option
                      value="<?= $key ?>" <?= (isset($search['province']) && ($key == $search['province'])) ? 'selected' : '' ?>>
                      <?= $val ?>
                    </option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select></div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4">
            <div class="form-row">
              <label>City Like:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[city]"
                     value="<?= isset($search['city']) ? $search['city'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-row">
              <label>Postal Code:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[postal]"
                     value="<?= isset($search['postal']) ? $search['postal'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-row">
              <label>Phone Like:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[phone]"
                     value="<?= isset($search['phone']) ? $search['phone'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-row">
              <label>Date ranges from:</label>
              <input type="text" class="input-text" id="date-from" placeholder="Chose start date"
                     name="search[registered][from]"
                     value="<?= isset($search['registered']['from']) ? $search['registered']['from'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-row">
              <label>Date ranges to:</label>
              <input type="text" class="input-text" id="date-to" placeholder="Chose end date"
                     name="search[registered][to]"
                     value="<?= isset($search['registered']['to']) ? $search['registered']['to'] : '' ?>">
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
<script src='<?= _A_::$app->router()->UrlTo('views/js/search.js'); ?>' type="text/javascript"></script>