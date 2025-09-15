<footer class="site-footer">
  <div class="container py-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
    <div class="small text-muted">© <?= date('Y') ?> <?= htmlspecialchars($site['company']) ?></div>
    <div class="small">
      <a class="me-3" href="/privacy">Политика конфиденциальности</a>
      <a class="" href="mailto:<?= htmlspecialchars($site['contacts']['email']) ?>"><?= htmlspecialchars($site['contacts']['email']) ?></a>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/inputmask/dist/inputmask.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/just-validate@4.3.0/dist/just-validate.production.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="/assets/js/main.js"></script>
</body>
</html>
