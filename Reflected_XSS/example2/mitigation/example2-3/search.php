<?php
  header("Content-Security-Policy: script-src 'self'");
  $query = $_GET['query'];
  echo "You searched for: " . $query;
?>
