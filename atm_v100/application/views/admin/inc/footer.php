<footer class="main-footer">
  <span><strong>Copyright &copy; <?php echo date('Y') ?> <b><a target="_blank" href="https://www.marswebsolution.com/"
          class="text-black">Mars Web Solutions</a></b></strong>
    All rights reserved.</span>
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 3.0.4
  </div>
</footer>
</div>
<!-- ./wrapper -->
<?php
if (!empty($page_type)) {
  if ($page_type == "list") {
    $this->load->view('admin/inc/files/footer-list', $this->data);
  }
} else {
  $this->load->view('admin/inc/files/footer', $this->data);
}
?>
<script>$('.label.ui.dropdown')
    .dropdown();

  $('.no.label.ui.dropdown')
    .dropdown({
      useLabels: false
    });

  $('.ui.button').on('click', function () {
    $('.ui.dropdown')
      .dropdown('restore defaults')
  })
</script>

<script>
  $.ajaxSetup({
    headers: {
      '<?php echo $csrf['name'] ?>': '<?php echo $csrf['hash'] ?>'
    }
  });
</script>
<script src="<?php echo _lte_files_ ?>plugins/pace-progress/pace.min.js"></script>
<?php
print_r($this->session->all_userdata());
?>
</body>

</html>