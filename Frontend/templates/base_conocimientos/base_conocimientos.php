<?php include_once('../../includes/get_articles.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Base de Conocimientos</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* Enhanced Minimal HelpDesk UI v1 - Core Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
      color: #333333;
      line-height: 1.6;
      font-size: 16px;
      min-height: 100vh;
    }

    /* Background Pattern */
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: radial-gradient(circle at 1px 1px, rgba(74, 144, 226, 0.03) 1px, transparent 0);
      background-size: 40px 40px;
      pointer-events: none;
      z-index: -1;
    }

    /* Container */
    .mh-container {
      max-width: 1000px;
      margin: 0 auto;
      padding: 20px;
      min-height: 100vh;
      position: relative;
    }

    /* Header */
    .mh-header {
      background: linear-gradient(135deg, #ffffff 0%, #fafafa 100%);
      border-radius: 16px;
      box-shadow: 
        rgba(0, 0, 0, 0.05) 0px 4px 12px,
        rgba(0, 0, 0, 0.02) 0px 1px 3px;
      padding: 40px;
      margin-bottom: 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 20px;
      position: relative;
      overflow: hidden;
    }

    .mh-header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 2px;
      background: linear-gradient(90deg, #4a90e2, #a8e6cf);
    }

    .mh-title {
      font-size: 36px;
      font-weight: 700;
      color: #333333;
      margin: 0;
      position: relative;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .mh-title::before {
      content: '📚';
      font-size: 28px;
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-5px); }
    }

    /* Create Button */
    .mh-create-btn {
      display: inline-flex;
      align-items: center;
      text-decoration: none;
      background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
      color: #ffffff;
      padding: 14px 28px;
      border-radius: 12px;
      font-weight: 600;
      font-size: 16px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border: 2px solid transparent;
      box-shadow: 
        rgba(74, 144, 226, 0.3) 0px 4px 12px,
        rgba(0, 0, 0, 0.05) 0px 2px 8px;
      position: relative;
      overflow: hidden;
    }

    .mh-create-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.5s;
    }

    .mh-create-btn:hover::before {
      left: 100%;
    }

    .mh-create-btn:hover {
      background: linear-gradient(135deg, #357abd 0%, #2d5a9e 100%);
      transform: translateY(-2px);
      box-shadow: 
        rgba(74, 144, 226, 0.4) 0px 8px 20px,
        rgba(0, 0, 0, 0.1) 0px 4px 12px;
    }

    .mh-create-btn:focus {
      outline: none;
      border-color: #ffffff;
      box-shadow: 
        rgba(74, 144, 226, 0.3) 0px 0px 0px 3px,
        rgba(74, 144, 226, 0.4) 0px 8px 20px;
    }

    .mh-create-icon {
      margin-right: 8px;
      font-size: 18px;
      font-weight: 600;
      display: inline-block;
      transition: transform 0.3s ease;
    }

    .mh-create-btn:hover .mh-create-icon {
      transform: rotate(90deg);
    }

    /* Articles Container */
    .mh-articles-container {
      background: linear-gradient(135deg, #ffffff 0%, #fafafa 100%);
      border-radius: 16px;
      box-shadow: 
        rgba(0, 0, 0, 0.05) 0px 4px 12px,
        rgba(0, 0, 0, 0.02) 0px 1px 3px;
      padding: 40px;
      position: relative;
      overflow: hidden;
    }

    .mh-articles-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(74, 144, 226, 0.1), transparent);
    }

    .mh-articles-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .mh-article-item {
      border-bottom: 1px solid #f0f0f0;
      padding: 24px 0;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
    }

    .mh-article-item:last-child {
      border-bottom: none;
      padding-bottom: 0;
    }

    .mh-article-item:first-child {
      padding-top: 0;
    }

    .mh-article-item::before {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 4px;
      height: 0;
      background: linear-gradient(135deg, #4a90e2, #a8e6cf);
      border-radius: 2px;
      transition: height 0.3s ease;
    }

    .mh-article-item:hover {
      background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
      margin: 0 -20px;
      padding-left: 20px;
      padding-right: 20px;
      border-radius: 12px;
      box-shadow: rgba(0, 0, 0, 0.05) 0px 2px 8px;
    }

    .mh-article-item:hover::before {
      height: 60%;
    }

    .mh-article-link {
      text-decoration: none;
      color: #333333;
      font-weight: 500;
      font-size: 18px;
      display: flex;
      align-items: center;
      gap: 12px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      padding: 12px 0;
      position: relative;
    }

    .mh-article-link::before {
      content: '📄';
      font-size: 16px;
      opacity: 0.7;
      transition: all 0.3s ease;
    }

    .mh-article-link::after {
      content: '→';
      font-size: 16px;
      margin-left: auto;
      opacity: 0;
      transform: translateX(-10px);
      transition: all 0.3s ease;
      color: #4a90e2;
    }

    .mh-article-link:hover {
      color: #4a90e2;
      transform: translateX(8px);
    }

    .mh-article-link:hover::before {
      opacity: 1;
      transform: scale(1.1);
    }

    .mh-article-link:hover::after {
      opacity: 1;
      transform: translateX(0);
    }

    .mh-article-link:focus {
      outline: none;
      color: #4a90e2;
      background: rgba(74, 144, 226, 0.05);
      border-radius: 8px;
      padding: 12px 16px;
      margin: 0 -16px;
    }

    /* Empty State */
    .mh-empty-state {
      text-align: center;
      padding: 80px 20px;
      color: #4f4f4f;
      position: relative;
    }

    .mh-empty-state::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 200px;
      height: 200px;
      background: radial-gradient(circle, rgba(74, 144, 226, 0.05) 0%, transparent 70%);
      border-radius: 50%;
      z-index: -1;
    }

    .mh-empty-icon {
      font-size: 64px;
      margin-bottom: 24px;
      color: #ccc;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
    }

    .mh-empty-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 12px;
      color: #333333;
    }

    .mh-empty-text {
      font-size: 16px;
      color: #666;
      max-width: 400px;
      margin: 0 auto;
      line-height: 1.5;
    }

    /* Stats Badge */
    .mh-stats-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: linear-gradient(135deg, #a8e6cf 0%, #7dd3b0 100%);
      color: #2d5a3d;
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 14px;
      font-weight: 500;
      margin-top: 10px;
      box-shadow: rgba(168, 230, 207, 0.3) 0px 2px 8px;
    }

    /* Article Count */
    .mh-article-count {
      font-size: 14px;
      color: #666;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .mh-article-count::before {
      content: '📊';
      font-size: 16px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .mh-container {
        padding: 15px;
      }

      .mh-header {
        padding: 30px 20px;
        margin-bottom: 20px;
        flex-direction: column;
        text-align: center;
      }

      .mh-title {
        font-size: 28px;
      }

      .mh-create-btn {
        padding: 12px 24px;
        font-size: 15px;
      }

      .mh-articles-container {
        padding: 30px 20px;
      }

      .mh-article-item {
        padding: 20px 0;
      }

      .mh-article-link {
        font-size: 16px;
      }

      .mh-empty-state {
        padding: 60px 20px;
      }

      .mh-empty-icon {
        font-size: 48px;
      }

      .mh-empty-title {
        font-size: 20px;
      }
    }

    @media (max-width: 480px) {
      .mh-container {
        padding: 10px;
      }

      .mh-header {
        padding: 20px 15px;
      }

      .mh-title {
        font-size: 24px;
      }

      .mh-articles-container {
        padding: 20px 15px;
      }

      .mh-article-item {
        padding: 16px 0;
      }

      .mh-article-item:hover {
        margin: 0 -15px;
        padding-left: 15px;
        padding-right: 15px;
      }

      .mh-article-link {
        font-size: 15px;
      }

      .mh-empty-state {
        padding: 40px 15px;
      }

      .mh-empty-icon {
        font-size: 40px;
      }

      .mh-empty-title {
        font-size: 18px;
      }

      .mh-empty-text {
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
      .mh-create-btn {
        border: 2px solid #ffffff;
      }
      
      .mh-article-link:focus {
        outline: 2px solid #4a90e2;
      }
    }


  </style>
</head>
<body>
  <div class="mh-container">
    <!-- Header with Title and Create Button -->
    <header class="mh-header">
      <div>
        <h1 class="mh-title">Base de Conocimientos</h1>
        <?php if (!empty($articles)): ?>
          <div class="mh-stats-badge">
            <span>📈</span>
            <span><?= count($articles) ?> <?= count($articles) === 1 ? 'artículo' : 'artículos' ?></span>
          </div>
        <?php endif; ?>
      </div>
      <a href="create_article_form.php" class="mh-create-btn">
        <span class="mh-create-icon">+</span>
        Crear nuevo artículo
      </a>
    </header>

    <!-- Articles Container -->
    <main class="mh-articles-container">
      <?php if (!empty($articles)): ?>
        <div class="mh-article-count">
          <span>Mostrando <?= count($articles) ?> <?= count($articles) === 1 ? 'artículo' : 'artículos' ?></span>
        </div>
        <ul class="mh-articles-list">
          <?php foreach ($articles as $article): ?>
            <li class="mh-article-item">
              <a href="view_article.php?id=<?= $article['id'] ?>" class="mh-article-link">
                <span><?= htmlspecialchars($article['title']) ?></span>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <div class="mh-empty-state">
          <div class="mh-empty-icon">📚</div>
          <h2 class="mh-empty-title">No hay artículos disponibles</h2>
          <p class="mh-empty-text">Comienza creando tu primer artículo de conocimiento para ayudar a tu equipo y clientes</p>
        </div>
      <?php endif; ?>
    </main>
  </div>
</body>
</html>