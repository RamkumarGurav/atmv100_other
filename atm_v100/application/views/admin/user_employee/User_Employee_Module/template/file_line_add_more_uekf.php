<?php
// Initialize $id to 1
$id_uekf = 1;
$action = "update";
// Check if $append_id is not empty
if (!empty($append_id_uekf)) {
  // If $append_id is not empty, assign its value to $id
  $id_uekf = $append_id_uekf;
}
?>

<!-- Start of a new table row -->
<tr class="qe_sub_table_tr_uekf">
  <!-- Table cell for the row count (this will be updated dynamically) -->
  <td class="qe_sub_table_count_uekf">1.</td>

  <!-- Table cell for the file title input -->
  <td>
    <!-- Input field for the file title with a dynamic ID -->
    <input type="text" name="file_title_uekf[]" id="file_title_uekf_<?= $id_uekf ?>" placeholder="File Title"
      class="form-control search-code form-control-sm" />
    <!-- Hidden input field for the quotation enquiry detail ID with a dynamic ID -->
    <!-- <input type="hidden" name="quotation_enquiry_detail_id[]" id="quotation_enquiry_detail_id<?= $id_uekf ?>" value="" /> -->
  </td>

  <!-- Table cell for the file input -->
  <td>
    <div class="input-group">
      <div class="custom-file">
        <!-- Hidden input field to store the file name (initially empty) -->
        <!-- <input type="hidden" name="file_name[]" value="" /> -->
        <!-- File input field for selecting a file -->
        <input type="file" name="file_uekf[]" class="custom-file-input" id="file_input_uekf_<?= $id_uekf ?>"
          onchange="previewImage(<?= $id_uekf ?>)">
        <!-- Label for the file input, initially empty -->
        <label class="custom-file-label form-control-sm" for="files">Choose file</label>
      </div>
      <!-- Image preview -->
      <!-- <img id="image_preview_uekf_<?= $id_uekf ?>" src="" alt="Image Preview" class="imageThumb"
        style="display:none;"> -->
    </div>
  </td>

  <!-- Table cell for the remove button (this will be updated dynamically) -->
  <td class="qe_sub_table_remove_td_uekf"></td>
</tr>

<script>
  function previewImage(id) {
    var input = document.getElementById('file_input_uekf_' + id);
    var preview = document.getElementById('image_preview_uekf_' + id);

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
      }

      reader.readAsDataURL(input.files[0]);
    } else {
      preview.src = '';
      preview.style.display = 'none';
    }
  }





</script>