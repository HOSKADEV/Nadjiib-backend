<!-- Modal -->
<div class="modal fade" id="appSettingModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form action="{{route('dashboard.app-setting.store') }}" method="POST">
      @csrf
      @if(isset($setting))
      @method('PUT')
      @endif
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ isset($setting) ? 'Edit App Setting' : 'Create App Setting' }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <!-- Key input -->
          <div class="mb-3">
            <label for="key" class="form-label">Key</label>
            <input type="text" name="key" id="key" class="form-control" placeholder="Enter setting key" value="{{ old('key', isset($setting) ? $setting->key : '') }}" required>
          </div>

          <!-- Value type selection -->
          <div class="mb-3">
            <label class="form-label">Value Type</label>
            <div>
              <input type="radio" name="value_type" id="value_type_boolean" value="boolean" required {{ old('value_type')=='boolean' ? 'checked' : '' }}>
              <label for="value_type_boolean">Boolean</label>
              &nbsp;&nbsp;
              <input type="radio" name="value_type" id="value_type_text" value="text" required {{ old('value_type')=='text' ? 'checked' : '' }}>
              <label for="value_type_text">Text</label>
            </div>
          </div>

          <!-- Boolean options -->
          <div class="mb-3" id="boolean-options" style="display: none;">
            <label class="form-label">Select Boolean Value</label>
            <div>
              <input type="radio" name="boolean_value" id="bool_true" value="true" >
              <label for="bool_true">True</label>
              &nbsp;&nbsp;
              <input type="radio" name="boolean_value" id="bool_false" value="false" >
              <label for="bool_false">False</label>
            </div>
          </div>

          <!-- Text options -->
          <div id="text-options" style="display: none;">
            <div class="mb-3">
              <label class="form-label">Text Input Type</label>
              <div>
                <input type="radio" name="text_type" id="text_type_kv" value="key_value" required>
                <label for="text_type_kv">Key–Value Pair</label>
                &nbsp;&nbsp;
                <input type="radio" name="text_type" id="text_type_array" value="array" required>
                <label for="text_type_array">Array</label>
              </div>
            </div>

            <!-- Key-Value input -->
            <div id="key-value-input" style="display: none;">
              <div id="key_value_container">
                <div class="row mb-2">
                  <div class="col-5">
                    <input type="text" name="key_values[0][key]" class="form-control" placeholder="Key">
                  </div>
                  <div class="col-5">
                    <input type="text" name="key_values[0][value]" class="form-control" placeholder="Value">
                  </div>
                  <div class="col-2">
                    <button type="button" class="btn btn-outline-primary add-kv-row">+</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Array input -->
            <div id="array-input" style="display: none;">
              <div id="array_container">
                <div class="row mb-2">
                  <div class="col-10">
                    <input type="text" name="array_values[]" class="form-control" placeholder="Value">
                  </div>
                  <div class="col-2">
                    <button type="button" class="btn btn-outline-primary add-array-row">+</button>
                  </div>
                </div>
              </div>
            </div>
          </div> <!-- end text options -->
        </div><!-- modal-body -->

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">{{ isset($setting) ? 'Update' : 'Create' }}</button>
        </div>
      </div><!-- modal-content -->
    </form>
  </div><!-- modal-dialog -->
</div><!-- modal -->

<!-- JavaScript to show/hide groups and add dynamic rows -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  // Cache selectors
  const boolRadio = document.getElementById("value_type_boolean");
  const textRadio = document.getElementById("value_type_text");
  const booleanOptions = document.getElementById("boolean-options");
  const textOptions = document.getElementById("text-options");
  const textTypeKv = document.getElementById("text_type_kv");
  const textTypeArray = document.getElementById("text_type_array");
  const kvInput = document.getElementById("key-value-input");
  const arrayInput = document.getElementById("array-input");

  // Toggle showing options when value type is selected
  function toggleValueType() {
    if (boolRadio.checked) {
      booleanOptions.style.display = "block";
      textOptions.style.display = "none";
      kvInput.style.display = "none";
      arrayInput.style.display = "none";
    } else if (textRadio.checked) {
      booleanOptions.style.display = "none";
      textOptions.style.display = "block";
      // Clear any selection of inner radio buttons if needed
      if (textTypeKv.checked) {
        kvInput.style.display = "block";
        arrayInput.style.display = "none";
      } else if (textTypeArray.checked) {
        kvInput.style.display = "none";
        arrayInput.style.display = "block";
      } else {
        kvInput.style.display = "none";
        arrayInput.style.display = "none";
      }
    }
  }

  // Event listeners for value type radios
  [boolRadio, textRadio].forEach(radio => {
    radio.addEventListener("change", toggleValueType);
  });

  // Event listeners for text type radios
  [textTypeKv, textTypeArray].forEach(radio => {
    radio.addEventListener("change", function () {
      if (textTypeKv.checked) {
        kvInput.style.display = "block";
        arrayInput.style.display = "none";
      } else if (textTypeArray.checked) {
        kvInput.style.display = "none";
        arrayInput.style.display = "block";
      }
    });
  });

  // Function to add new key-value row
  document.querySelector(".add-kv-row").addEventListener("click", function () {
    const container = document.getElementById("key_value_container");
    const rowCount = container.querySelectorAll('.row').length;
    const row = document.createElement("div");
    row.classList.add("row", "mb-2");
    row.innerHTML = `
      <div class="col-5">
        <input type="text" name="key_values[${rowCount}][key]" class="form-control" placeholder="Key">
      </div>
      <div class="col-5">
        <input type="text" name="key_values[${rowCount}][value]" class="form-control" placeholder="Value">
      </div>
      <div class="col-2">
        <button type="button" class="btn btn-outline-danger remove-kv-row">-</button>
      </div>
    `;
    container.appendChild(row);
  });

  // Event delegation for removing key-value row
  document.getElementById("key_value_container").addEventListener("click", function (e) {
    if (e.target && e.target.classList.contains("remove-kv-row")) {
      e.target.closest('.row').remove();
    }
  });

  // Function to add new array row
  document.querySelector(".add-array-row").addEventListener("click", function () {
    const container = document.getElementById("array_container");
    const rowCount = container.querySelectorAll('.row').length;
    const row = document.createElement("div");
    row.classList.add("row", "mb-2");
    row.innerHTML = `
      <div class="col-10">
        <input type="text" name="array_values[]" class="form-control" placeholder="Value">
      </div>
      <div class="col-2">
        <button type="button" class="btn btn-outline-danger remove-array-row">-</button>
      </div>
    `;
    container.appendChild(row);
  });

  // Event delegation for removing array row
  document.getElementById("array_container").addEventListener("click", function (e) {
    if (e.target && e.target.classList.contains("remove-array-row")) {
      e.target.closest('.row').remove();
    }
  });

  // On page load, trigger the toggle function in case there is old input selected.
  toggleValueType();
});
</script>
