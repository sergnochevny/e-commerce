<?php if(isset($rows) && is_array($rows)): ?>
  <?php foreach($rows as $row): ?>
    <url>
      <loc><?=$row['loc']?></loc>
      <?php if(isset($row['lastmod'])):?>
      <lastmod><?=$row['lastmod']?></lastmod>
      <?php endif;?>
      <changefreq><?= isset($row['changefreq'])?$row['changefreq']:'weekly';?></changefreq>
      <priority><?= isset($row['priority'])?$row['priority']:'0.5';?></priority>
    </url>
  <?php endforeach; ?>
<?php endif; ?>