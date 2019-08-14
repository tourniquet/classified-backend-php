  <footer class="footer">
    <div class="copyright">
      Thank you for for using <a href="https://github.com/tourniquet/classified-backend-php">minClass</a>
    </div>

    <nav class="admin-footer-list">
      <a href="https://github.com/tourniquet/classified-backend-php">Documentation</a>
      <a href="https://github.com/tourniquet/classified-backend-php">Forums</a>
      <a href="https://github.com/tourniquet/classified-backend-php">Feedback</a>
    </nav>
  </footer>

  <script>
    const checkAll = () => {
      const checkboxStatus = document.getElementById('check-all').checked

      document
        .getElementsByName('items[]')
        .forEach(el => { el.checked = checkboxStatus })
    }

    const checkAllCheckboxes = document.getElementById('check-all')
    if (checkAllCheckboxes) {
      checkAllCheckboxes.addEventListener('click', checkAll)
    }
  </script>
</body>
</html>
