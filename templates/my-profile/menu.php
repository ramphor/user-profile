<div class="<?php echo $unique_id ?>-profile-menu">
    <ul class="profile-menu">
        <?php foreach ($menu_items as $menu_item) : ?>
            <li class="profile-menu-item<?php if ($current_feature === $menu_item['type']) {
                echo ' active';
                                        } ?>">
                <?php if (isset($menu_item['url'])) : ?>
                    <a href="<?php echo $menu_item['url']; ?>">
                        <?php echo $menu_item['label']; ?>
                    </a>
                <?php else : ?>
                    <?php echo $menu_item['label']; ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
