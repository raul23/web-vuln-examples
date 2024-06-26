<?php
  $query = htmlspecialchars($_GET['query'], ENT_QUOTES, 'UTF-8');
  echo "You searched for: " . $query;
?>
