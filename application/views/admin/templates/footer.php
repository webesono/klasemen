    <footer style="text-align: center; margin-top: 100px; padding-bottom: 50px;">
      <span>©</span>
      <script>
        document.write(new Date().getFullYear())
      </script>
      <span>Penulis Cerdas Indonesia.</span>
    </footer>
    </main>
    </body>
    <!--   Core JS Files   -->
    <script src="<?php echo base_url() ?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/smooth-scrollbar.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/chartjs.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/soft-ui-dashboard.min.js"></script>
    <script src="<?= base_url('assets/js/dataTables.responsive.js') ?>"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="<?php echo base_url('assets/js/') ?>sweetalert2.all.min.js"></script>
    <script src="<?php echo base_url('assets/js/') ?>myscript.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
      var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
      })
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      })
    </script>