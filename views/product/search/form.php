<form action="<?= $action ?>" method="post" data-search class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 panel panel-default search-panel">
      <div class="panel-heading">
        <div class="h4 search-container-title">
          <div class="row">
            <div class="col-xs-1 col-sm-1"><i class="fa fa-search"></i></div>
            <div class="col-xs-10 search-result-list comment-text">
              <?php if(isset($search['a.pname'])): ?>
                  <div class="label label-search-info">Name like:<?= $search['a.pname'] ?></div>
              <?php endif; ?>
              <?php if(isset($search['a.pnumber'])): ?>
                  <div class="label label-search-info">Product number like: <?= $search['a.pnumber'] ?></div>
              <?php endif; ?>
              <?php if(isset($search['b.cid'])): ?>
                  <div class="label label-search-info">Category: <?= $search['categories'][$search['b.cid']] ?></div>
              <?php endif; ?>
              <?php if(isset($search['c.id'])): ?>
                  <div class="label label-search-info">Colour: <?= $search['colours'][$search['c.id']] ?></div>
              <?php endif; ?>
              <?php if(isset($search['e.id'])): ?>
                  <div class="label label-search-info">Manufacturer: <?= $search['manufacturers'][$search['e.id']] ?>
                  </div>
              <?php endif; ?>
              <?php if(isset($search['a.pvisible'])): ?>
                <div class="label label-search-info">
                  Visibile: <?= isset($search['a.pvisible']) && $search['a.pvisible'] == 1 ? 'YES' : 'NO' ?>
                </div>
              <?php endif; ?>
              <?php if(isset($search['a.best'])): ?>
                  <div class="label label-search-info">Best
                    textile: <?= isset($search['a.best']) && $search['a.best'] == 1 ? 'YES' : 'NO' ?></div>
              <?php endif; ?>
              <?php if(isset($search['a.specials'])): ?>
                <div class="label label-search-info">
                    Specials: <?= isset($search['a.specials']) && $search['a.specials'] == 1 ? 'YES' : 'NO' ?></div>
              <?php endif; ?>
              <?php if(isset($search['a.piece'])): ?>
                <div class="label label-search-info">
                    Piece: <?= isset($search['a.piece']) && $search['a.piece'] == 1 ? 'YES' : 'NO' ?></div>
              <?php endif; ?>
              <?php if(!empty($search['a.dt']['from'])): ?>
                <div class="label label-search-info">
                    Date from: <?= $search['a.dt']['from']  ?></div>
              <?php endif; ?>
              <?php if(!empty($search['a.dt']['to'])): ?>
                <div class="label label-search-info">
                    Date to: <?= $search['a.dt']['to']  ?></div>
              <?php endif; ?>
              <?= isset($search['active']) ? '<a data-search_reset title="Reset search" class="button reset">&times;</a>' : '' ?>
            </div>
            <b class="sr-ds">
              <i class="fa fa-chevron-right"></i>
            </b>
          </div>
        </div>
      </div>

      <div class="panel-body hidden">

        <div class="row">
          <div class="col-sm-6">
            <div class="form-row">
              <label>
                Product Name:
                <input type="text" class="input-text" placeholder="Like ..." name="search[a.pname]"
                       value="<?= isset($search['a.pname']) ? $search['a.pname'] : '' ?>">
              </label>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-row">
              <label>Product number:
                <input type="text" name="search[a.pnumber]"
                       value="<?= isset($search['a.pnumber']) ? $search['a.pnumber'] : ''; ?>" class="input-text"
                       placeholder="e.g. abc888999">
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="form-row">
              <label>Specific category
                <select name="search[b.cid]" id="best">
                  <option value="" <?= isset($search['b.cid']) ? '' : 'selected' ?>>Any</option>
                  <?php if(isset($search['categories'])):
                    foreach($search['categories'] as $key => $val): ?>
                      <option
                        value="<?= $key ?>" <?= (isset($search['b.cid']) && ($key == $search['b.cid'])) ? 'selected' : '' ?>>
                        <?= $val ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </label>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-row">
              <label>Specific manufacturer
                <select name="search[e.id]" id="best">
                  <option value="" <?= isset($search['e.id']) ? '' : 'selected' ?>>Any</option>
                  <?php if(isset($search['manufacturers'])):
                    foreach($search['manufacturers'] as $key => $val):?>
                      <option
                        value="<?= $key ?>" <?= (isset( $search['e.id']) && ($key == $search['e.id'])) ? 'selected' : '' ?>>
                        <?= $val ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </label>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-row">
              <label for="">
                Select the status:
                <select name="search[a.pvisible]" id="">
                  <option value="" <?= isset($search['a.pvisible']) ? '' : 'selected' ?>>Any</option>
                  <option value="0" <?= isset($search['a.pvisible']) && $search['a.pvisible'] == 0 ? 'selected' : '' ?>>
                    Hidden
                  </option>
                  <option value="1" <?= isset($search['a.pvisible']) && $search['a.pvisible'] == 1 ? 'selected' : '' ?>>
                    Visible
                  </option>
                </select>
              </label>
            </div>
          </div>

          <div class="col-xs-4">
            <div class="form-row">
              <label>Best textile:
                <select name="search[a.best]" id="best">
                  <option value="" <?= isset($search['a.best']) ? '' : 'selected' ?>>Any</option>
                  <option value="1" <?= isset($search['a.best']) && $search['a.best'] == 1 ? 'selected' : '' ?>>Yes
                  </option>
                  <option value="0" <?= isset($search['a.best']) && $search['a.best'] == 0 ? 'selected' : '' ?>>No
                  </option>
                </select>
              </label>
            </div>
          </div>
          <div class="col-xs-4">
            <div class="form-row">
              <label>Specials:
                <select name="search[a.specials]" id="">
                  <option value="" <?= isset($search['a.specials']) ? '' : 'selected' ?>>Any</option>
                  <option value="1" <?= isset($search['a.specials']) && $search['a.specials'] == 1 ? 'selected' : '' ?>>
                    Yes
                  </option>
                  <option value="0" <?= isset($search['a.specials']) && $search['a.specials'] == 0 ? 'selected' : '' ?>>
                    No
                  </option>
                </select>
              </label>
            </div>
          </div>
        </div>
        <div class="row">

          <div class="col-xs-4">
            <div class="form-row">
              <label>In specific colour
                <select name="search[c.id]" id="best">
                  <option value="" <?= isset($search['c.id']) ? '' : 'selected' ?>>Any</option>
                  <?php if(isset($search['colours'])):
                    foreach($search['colours'] as $key => $val):?>
                      <option
                        value="<?= $key ?>" <?= (isset($search['c.id']) && ($key == $search['c.id'])) ? 'selected' : '' ?>>
                        <?= $val ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </label>
            </div>
          </div>
          <div class="col-xs-4">
            <div class="form-row">
              <label>With specific pattern
                <select name="search[d.id]" id="best">
                  <option value="" <?= isset($search['d.id']) ? '' : 'selected' ?>>Any</option>
                  <?php if(isset($search['patterns'])):
                    foreach($search['patterns'] as $key => $val):?>
                      <option
                        value="<?= $key ?>" <?= (isset($search['d.id']) && ($key == $search['d.id'])) ? 'selected' : '' ?>>
                        <?= $val ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </label>
            </div>
          </div>
          <div class="col-xs-4">
            <div class="form-row">
              <label>Piece
                <select name="search[a.piece]" id="best">
                  <option value="" <?= isset($search['a.piece']) ? '' : 'selected' ?>>Any</option>
                  <option value="1" <?= isset($search['a.piece']) && $search['a.piece'] == 1 ? 'selected' : '' ?>>Yes
                  </option>
                  <option value="0" <?= isset($search['a.piece']) && $search['a.piece'] == 0 ? 'selected' : '' ?>>No
                  </option>
                </select>
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="form-row">
              <label for="discount_on">
                Starts at:
                <input placeholder="Chose start date" type="text" id="date-from" class="input-text"
                       name="search[a.dt][from]"
                       value="<?= isset($search['a.dt']['from']) ? $search['a.dt']['from'] : '' ?>">
              </label>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-row">
              <label for="discount_on">
                Ends at:
                <input placeholder="Chose end date" type="text" id="date-to" class="input-text" name="search[a.dt][to]"
                       value="<?= isset($search['a.dt']['to']) ? $search['a.dt']['to'] : '' ?>">
              </label>
            </div>
          </div>
        </div>

      </div>

      <div class="panel-footer hidden">
        <div class="row">
          <div class="col-sm-12">
            <a data-search_submit class="button pull-right">Search</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<script src="<?= _A_::$app->router()->UrlTo('views/js/search.js'); ?>"></script>