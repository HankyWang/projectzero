<?php
  require('./RegexTools.php');
  $Ignore_Caps = new RegexTools(false, 'i');
  if (!$Ignore_Caps->noEmpty($_POST['Username'])) exit('Username must not be empty!');
  if (!$Ignore_Caps->is_email($_POST['email'])) exit('Email address is invalid!');
  if (!$Ignore_Caps->is_mobile($_POST['mobile'])) exit('Phone number is invalid!');

  print('OK!');
?>