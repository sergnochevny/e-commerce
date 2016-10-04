<?php
  $keys = array_keys($data);
  array_unshift($keys,0);
  $values = array_values($data);
  array_unshift($values,'Select Manufacturer..');
  $data = array_combine( $keys, $values );
  foreach($data as $key => $value) {
    echo '<option value="' . $key . '" ' . (in_array($key, $selected) ? 'selected' : '') . ' >' . $value . '</option>';
  }