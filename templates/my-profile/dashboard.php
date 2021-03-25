<?php do_action("{$workspace}_before_dashboard_content"); ?>

<?php call_user_func($openForm); ?>

<?php foreach ($sections as $section) : ?>
    <section id="<?php echo $section->getSectionId(); ?>" class="my-profile-section">
        <?php echo $section->getContent(); ?>
    </section>
<?php endforeach; ?>

<?php echo $save_button; ?>

<?php call_user_func($closeForm); ?>

<?php do_action("{$workspace}_after_dashboard_content"); ?>
