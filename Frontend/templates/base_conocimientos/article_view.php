<?php
include_once('../../includes/get_article_by_id.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($article['title']) ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* Minimal HelpDesk UI v1 - Core Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background-color: #f5f5f5;
      color: #333333;
      line-height: 1.6;
      font-size: 16px;
    }

    /* Container */
    .mh-container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      min-height: 100vh;
    }

    /* Header */
    .mh-header {
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 12px;
      padding: 30px;
      margin-bottom: 30px;
    }

    .mh-title {
      font-size: 32px;
      font-weight: 600;
      color: #333333;
      margin-bottom: 15px;
      line-height: 1.3;
    }

    /* Content Card */
    .mh-content-card {
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 12px;
      padding: 30px;
      margin-bottom: 30px;
    }

    .mh-content {
      font-size: 16px;
      line-height: 1.8;
      color: #4f4f4f;
    }

    .mh-content p {
      margin-bottom: 16px;
    }

    .mh-content p:last-child {
      margin-bottom: 0;
    }

    /* Navigation */
    .mh-nav {
      display: flex;
      justify-content: flex-start;
      align-items: center;
    }

    .mh-back-link {
      display: inline-flex;
      align-items: center;
      text-decoration: none;
      color: #4a90e2;
      font-weight: 500;
      padding: 12px 24px;
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 12px;
      transition: all 0.3s ease;
      border: 2px solid transparent;
    }

    .mh-back-link:hover {
      background-color: #4a90e2;
      color: #ffffff;
      transform: translateY(-2px);
      box-shadow: rgba(0, 0, 0, 0.1) 0px 8px 20px;
    }

    .mh-back-link:focus {
      outline: none;
      border-color: #4a90e2;
      box-shadow: rgba(74, 144, 226, 0.3) 0px 0px 0px 3px;
    }

    .mh-back-icon {
      margin-right: 8px;
      font-size: 18px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .mh-container {
        padding: 15px;
      }

      .mh-header {
        padding: 20px;
        margin-bottom: 20px;
      }

      .mh-title {
        font-size: 24px;
      }

      .mh-content-card {
        padding: 20px;
        margin-bottom: 20px;
      }

      .mh-content {
        font-size: 15px;
      }

      .mh-back-link {
        padding: 10px 20px;
        font-size: 14px;
      }
    }

    @media (max-width: 480px) {
      .mh-container {
        padding: 10px;
      }

      .mh-header {
        padding: 15px;
      }

      .mh-title {
        font-size: 20px;
      }

      .mh-content-card {
        padding: 15px;
      }

      .mh-back-link {
        padding: 8px 16px;
        font-size: 14px;
      }
    }

    /* Accessibility */
    @media (prefers-reduced-motion: reduce) {
      * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
      }
    }

    /* High contrast mode support */
    @media (prefers-contrast: high) {
      .mh-back-link {
        border: 2px solid #4a90e2;
      }
    }
  </style>
</head>
<body>
  <div class="mh-container">
    <!-- Header with Title -->
    <header class="mh-header">
      <h1 class="mh-title"><?= htmlspecialchars($article['title']) ?></h1>
    </header>

    <!-- Content Card -->
    <main class="mh-content-card">
      <div class="mh-content">
        <?= nl2br(htmlspecialchars($article['content'])) ?>
      </div>
    </main>

    <!-- Navigation -->
    <nav class="mh-nav">
      <a href="knowledge_base.php" class="mh-back-link">
        <span class="mh-back-icon">←</span>
        Volver
      </a>
    </nav>
  </div>
</body>
</html>