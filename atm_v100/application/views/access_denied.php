<style>
  :root {
    --primary-color: #2c3e50;
    --secondary-color: #34495e;
    --accent-color: #e74c3c;
    --text-color: #ecf0f1;
  }



  .container {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    padding: clamp(1.5rem, 5vw, 3rem);
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 450px;
    text-align: center;
    color: var(--text-color);
  }

  .icon {
    width: clamp(60px, 15vw, 100px);
    height: clamp(60px, 15vw, 100px);
    margin-bottom: clamp(1rem, 4vw, 2rem);
    fill: var(--accent-color);
  }

  .message {
    font-size: clamp(1.2rem, 4vw, 1.5rem);
    font-weight: 600;
    margin-bottom: 1rem;
    line-height: 1.4;
  }

  .sub-message {
    font-size: clamp(0.9rem, 3vw, 1rem);
    opacity: 0.8;
    line-height: 1.5;
  }

  @media (max-width: 480px) {

    body,
    html {
      padding: 10px;
    }
  }

  @media (prefers-color-scheme: light) {
    :root {
      --primary-color: #ecf0f1;
      --secondary-color: #bdc3c7;
      --text-color: #2c3e50;
    }

    .container {
      background: rgba(255, 255, 255, 0.7);
    }
  }
</style>

<div class="container mt-4">
  <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
  </svg>
  <p class="message">This service is not accessible in your system.</p>
  <p class="sub-message">Please use an authorized device or contact your system administrator for assistance.</p>
</div>