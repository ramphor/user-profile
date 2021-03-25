<div class="field-<?php echo $field_name; ?>">
    <?php do_action("{$workspace}_profile_before_field_{$field_name}"); ?>
    <div class="edit-field field-<?php echo $input_type; ?>">
        <label for="<?php echo $field_id; ?>"><?php echo $label; ?></label>
        <div class="input-wrap">
            <input type="text" <?php echo $field_attributes; ?> value="<?php echo $value; ?>" />
        </div>
    </div>
    <?php do_action("{$workspace}_profile_after_field_{$field_name}"); ?>
</div>
