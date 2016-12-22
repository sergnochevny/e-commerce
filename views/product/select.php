<?php
  $keys = array_keys($rows);
  array_unshift($keys,0);
  $values = array_values($rows);
  array_unshift($values,'Select Manufacturer..');
  $rows = array_combine($keys, $values );
  foreach($rows as $key => $value) {
    echo '<option value="' . $key . '" ' . (in_array($key, $selected) ? 'selected' : '') . ' >' . $value . '</option>';
  }