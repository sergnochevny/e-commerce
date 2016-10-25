<form action="<?= $action ?>" method="post" data-search class="col-xs-12">
  <div class="row">
    <div class="col-xs-12 panel panel-default search-panel">
      <div class="panel-heading">
        <div class="h4 search-container-title">
          <div class="row">
            <div class="col-xs-1 col-sm-2"><i class="fa fa-search"></i></div>
            <div class="col-xs-10 comment-text">
              <?php if(isset($search['a.pname'])): ?>
                <div class="row">
                  <div class="col-xs-12">Product name like: <?= $search['a.pname'] ?></div>
                </div>
              <?php endif; ?>
              <?php if(isset($search['a.pnumber'])): ?>
                <div class="row">
                  <div class="col-xs-12">Product number like: <?= $search['a.pnumber'] ?></div>
                </div>
              <?php endif; ?>
              <?php if(isset($search['b.cid'])): ?>
                <div class="row">
                  <div class="col-xs-12">Category: <?= $search['categories'][$search['b.cid']] ?></div>
                </div>
              <?php endif; ?>
              <?php if(isset($search['c.id'])): ?>
                <div class="row">
                  <div class="col-xs-12">Colour: <?= $search['colours'][$search['c.id']] ?></div>
                </div>
              <?php endif; ?>
              <?php if(isset($search['m.id'])): ?>
                <div class="row">
                  <div class="col-xs-12">Manufacturer: <?= $search['manufacturer'][$search['m.id']] ?></div>
                </div>
              <?php endif; ?>
              <?php if(isset($search['a.pvisible'])): ?>
                <div class="row">
                  <div class="col-xs-12">Visibile: <?= isset($search['a.pvisible']) && $search['a.pvisible'] == 0 ? 'YES' : 'NO' ?></div>
                </div>
              <?php endif; ?>
              <?php if(isset($search['a.pvisible'])): ?>
                <div class="row">
                  <div class="col-xs-12">Best textile: <?= isset($search['a.best']) && $search['a.best'] == 0 ? 'YES' : 'NO' ?></div>
                </div>
              <?php endif; ?>
              <?php if(isset($search['a.specials'])): ?>
                <div class="row">
                  <div class="col-xs-12">Specials: <?= isset($search['a.specials']) && $search['a.specials'] == 0 ? 'YES' : 'NO' ?></div>
                </div>
              <?php endif; ?>
              <?= isset($search['active']) ? '<a data-search_reset class="button reset">&times;</a>' : '' ?>
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
              <label>Product Name:</label>
              <input type="text" class="input-text" placeholder="Like ..." name="search[a.pname]"
                     value="<?= isset($search['a.pname']) ? $search['a.pname'] : '' ?>">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-row">
              <label for="">
                Select the status
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
        </div>
        <div class="row">
          <div class="col-xs-4">
            <div class="form-row">
              <label>Product number:
                <input type="text" name="search[a.pnumber]"
                       value="<?= isset($search['a.pnumber']) ? $search['a.pnumber'] : ''; ?>" class="input-text"
                       placeholder="e.g. abc888999">
              </label>
            </div>
          </div>
          <div class="col-xs-4">
            <div class="form-row">
              <label>Best textile:
                <select name="search[a.best]" id="best">
                  <option value=""  <?= isset($search['a.best']) ? '' : 'selected' ?>>Any</option>
                  <option value="1" <?= isset($search['a.best']) && $search['a.best'] == 1 ? 'selected' : '' ?>>Yes</option>
                  <option value="0" <?= isset($search['a.best']) && $search['a.best'] == 0 ? 'selected' : '' ?>>No</option>
                </select>
              </label>
            </div>
          </div>
          <div class="col-xs-4">
            <div class="form-row">
              <label>Specials:
                <select name="search[a.specials]" id="">
                  <option value=""  <?= isset($search['a.specials']) ? '' : 'selected' ?>>Any</option>
                  <option value="1" <?= isset($search['a.specials']) && $search['a.specials'] == 1 ? 'selected' : '' ?>>Yes</option>
                  <option value="0" <?= isset($search['a.specials']) && $search['a.specials'] == 0 ? 'selected' : '' ?>>No</option>
                </select>
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-4">
            <div class="form-row">
              <label>Specific category
                <select name="search[b.cid]" id="best">
                  <option value=""  <?= isset($search['b.cid']) ? '' : 'selected' ?>>Any</option>
                  <?php if(isset($search['categories'])):
                    foreach($search['categories'] as $category): ?>
                      <option
                        value="<?= $category['cid'] ?>" <?= (isset($search['b.cid']) && ($category['cid'] == $search['b.cid'])) ? 'selected' : '' ?>>
                        <?= $category['cname'] ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </label>
            </div>
          </div>
          <div class="col-xs-4">
            <div class="form-row">
              <label>In specific colour
                <select name="search[c.id]" id="best">
                  <option value=""  <?= isset($search['c.id']) ? '' : 'selected' ?>>Any</option>
                  <?php if(isset($search['colours'])):
                    foreach($search['colours'] as $colour):?>
                      <option
                        value="<?= $colour['id'] ?>" <?= (isset($search['c.id']) && ($colour['id'] == $search['c.id'])) ? 'selected' : '' ?>>
                        <?= $colour['colour'] ?>
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
                    foreach($search['patterns'] as $pattern):?>
                      <option
                        value="<?= $pattern['id'] ?>" <?= (isset($search['d.id']) && ($pattern['id'] == $search['d.id'])) ? 'selected' : '' ?>>
                        <?= $pattern['pattern'] ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <div class="form-row">
              <label>Piece
                <select name="search[a.best]" id="best">
                  <option value=""  <?= isset($search['a.piece']) ? '' : 'selected' ?>>Any</option>
                  <option value="1" <?= isset($search['a.piece']) && $search['a.piece'] == 1 ? 'selected' : '' ?>>Yes</option>
                  <option value="0" <?= isset($search['a.piece']) && $search['a.piece'] == 0 ? 'selected' : '' ?>>No</option>
                </select>
              </label>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="form-row">
              <label>Specific manufacturer
                <select name="search[c.id]" id="best">
                  <option value="" <?= isset($search['m.id']) ? '' : 'selected' ?>>Any</option>
                  <?php if(isset($search['manufacturers'])):
                    foreach($search['manufacturers'] as $manufacturer):?>
                      <option
                        value="<?= $manufacturer['id'] ?>" <?= (isset($manufacturer['m.id']) && ($manufacturer['id'] == $search['m.id'])) ? 'selected' : '' ?>>
                        <?= $manufacturer['manufacturer'] ?>
                      </option>
                    <?php endforeach; ?>
                  <?php endif; ?>
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
        <a data-search_submit class="btn button pull-right">Search</a>
      </div>
    </div>
  </div>
</form>
<script src="<?= _A_::$app->router()->UrlTo('views/js/search.js'); ?>"></script>