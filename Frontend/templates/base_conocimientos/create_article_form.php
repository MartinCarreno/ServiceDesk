<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nuevo artículo</title>
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
      text-align: center;
    }

    .mh-title {
      font-size: 32px;
      font-weight: 600;
      color: #333333;
      margin: 0;
    }

    /* Form Container */
    .mh-form-container {
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 12px;
      padding: 30px;
      margin-bottom: 30px;
    }

    .mh-form {
      display: flex;
      flex-direction: column;
      gap: 25px;
    }

    /* Form Groups */
    .mh-form-group {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .mh-label {
      font-weight: 500;
      color: #333333;
      font-size: 16px;
    }

    /* Input Styles */
    .mh-input {
      padding: 12px 16px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-size: 16px;
      font-family: inherit;
      transition: all 0.3s ease;
      background-color: #ffffff;
      color: #333333;
    }

    .mh-input:focus {
      outline: none;
      border-color: #4a90e2;
      box-shadow: rgba(74, 144, 226, 0.2) 0px 0px 0px 3px;
    }

    .mh-input:hover {
      border-color: #c0c0c0;
    }

    .mh-input::placeholder {
      color: #999999;
    }

    /* Textarea Specific */
    .mh-textarea {
      resize: vertical;
      min-height: 200px;
      font-family: inherit;
      line-height: 1.6;
    }

    /* Button Styles */
    .mh-button {
      padding: 14px 32px;
      background-color: #4a90e2;
      color: #ffffff;
      border: none;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      align-self: flex-start;
      box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 12px;
      font-family: inherit;
    }

    .mh-button:hover {
      background-color: #357abd;
      transform: translateY(-2px);
      box-shadow: rgba(0, 0, 0, 0.1) 0px 8px 20px;
    }

    .mh-button:focus {
      outline: none;
      box-shadow: rgba(74, 144, 226, 0.3) 0px 0px 0px 3px;
    }

    .mh-button:active {
      transform: translateY(0);
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

    /* Form Actions */
    .mh-form-actions {
      display: flex;
      gap: 15px;
      align-items: center;
      flex-wrap: wrap;
    }

    /* Error States */
    .mh-input:invalid {
      border-color: #e74c3c;
    }

    .mh-input:invalid:focus {
      border-color: #e74c3c;
      box-shadow: rgba(231, 76, 60, 0.2) 0px 0px 0px 3px;
    }

    /* Success State */
    .mh-input:valid {
      border-color: #a8e6cf;
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

      .mh-form-container {
        padding: 20px;
        margin-bottom: 20px;
      }

      .mh-form {
        gap: 20px;
      }

      .mh-textarea {
        min-height: 150px;
      }

      .mh-button {
        padding: 12px 24px;
        font-size: 15px;
        align-self: stretch;
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

      .mh-form-container {
        padding: 15px;
      }

      .mh-input {
        padding: 10px 12px;
        font-size: 15px;
      }

      .mh-textarea {
        min-height: 120px;
      }

      .mh-button {
        padding: 10px 20px;
        font-size: 14px;
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
      .mh-button {
        border: 2px solid #ffffff;
      }
      
      .mh-back-link {
        border: 2px solid #4a90e2;
      }
    }
  </style>
</head>
<body>
  <div class="mh-container">
    <!-- Header -->
    <header class="mh-header">
      <h1 class="mh-title">Crear nuevo artículo</h1>
    </header>

    <!-- Form Container -->
    <main class="mh-form-container">
      <form class="mh-form" action="../../includes/create_article.php" method="post">
        <!-- Title Field -->
        <div class="mh-form-group">
          <label class="mh-label" for="title">Título</label>
          <input 
            type="text" 
            id="title"
            name="title" 
            class="mh-input" 
            placeholder="Ingresa el título del artículo"
            required
            autocomplete="off"
          >
        </div>

        <!-- Content Field -->
        <div class="mh-form-group">
          <label class="mh-label" for="content">Contenido</label>
          <textarea 
            id="content"
            name="content" 
            class="mh-input mh-textarea" 
            placeholder="Escribe el contenido del artículo aquí..."
            required
            autocomplete="off"
          ></textarea>
        </div>

        <!-- Form Actions -->
        <div class="mh-form-actions">
          <button type="submit" class="mh-button">
            Guardar artículo
          </button>
          <a href="knowledge_base.php" class="mh-back-link">
            <span class="mh-back-icon">←</span>
            Cancelar
          </a>
        </div>
      </form>
    </main>
  </div>
</body>
</html>