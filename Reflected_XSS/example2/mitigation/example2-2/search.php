<?php
  $query = filter_input(INPUT_GET, 'query', FILTER_SANITIZE_SPECIAL_CHARS);
  echo "You searched for: " . $query;
?>
