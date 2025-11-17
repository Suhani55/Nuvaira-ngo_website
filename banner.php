<?php
// ===============================
// Nuvaira Foundation — banner.php
// ===============================

// Ensure $pageTitle is set before including
if (!isset($pageTitle) || empty($pageTitle)) {
    $pageTitle = "Nuvaira Foundation";
}

// Sanitize for output
$pageTitleSafe = htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8');
?>
<section class="page-banner" style="
  background: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
              url('images/banner-bg.jpg') center/cover no-repeat;
  color: #fff;
  text-align: center;
  padding: 100px 20px;
">
  <h1 style="font-size: 2.5rem; margin-bottom: 10px;"><?php echo $pageTitleSafe; ?></h1>
  <p style="font-size: 1.1rem;">A Breath of Hope 🌿</p>
</section>
