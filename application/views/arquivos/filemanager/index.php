<?php
header("Expires: Mon, 26 Jul 2019 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." UM3");

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

header("Location: ../");
exit;
