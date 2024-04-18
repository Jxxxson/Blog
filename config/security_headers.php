<?php

//Content Seucrity Policy
header("Content-Security-Policy: default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com; style-src 'self' https://fonts.googleapis.com; img-src 'self' data:; font-src 'self' https://fonts.gstatic.com;");

// X-Frame-Options
header("X-Frame-Options: DENY");

// X-Content-Type-Options
header("X-Content-Type-Options: nosniff");

?>