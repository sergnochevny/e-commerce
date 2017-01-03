<?php if(!empty($data)): ?>
  <div class="panel panel-default panel-body">
    <div class="col-xs-12">
      <div class="row text-center">
        <h4 class="section-title"><?= $data['title']; ?></h4>
      </div>
    </div>
    <div class="col-xs-12">
      <div class="row text-justify">
        <?= $data['message']; ?>
      </div>
    </div>
  </div>
<?php endif; ?>