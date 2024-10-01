<?php

use wsytesTheme\helpers\MenuHelper;

$menu_items = MenuHelper::get_header_menu_items();

if ( empty( $menu_items ) ) {
	return;
}
?>
<nav>
    <ul>
		<?php
		foreach ( $menu_items as $menu_item ) { ?>
            <li>
                <a href="<?php
				echo esc_url( $menu_item->url ); ?>" class="<?php
				echo esc_attr( MenuHelper::get_is_active_class( $menu_item ) ); ?>">
					<?php
					echo esc_html( $menu_item->title ); ?>
                </a>

				<?php
				if ( ! empty( $menu_item->sub ) ) { ?>
                    <ul>
						<?php
						foreach ( $menu_item->sub as $menu_item_sub ) { ?>
                            <li>
                                <a href="<?php
								echo esc_url( $menu_item_sub->url ); ?>" class="<?php
								echo esc_attr( MenuHelper::get_is_active_class( $menu_item_sub ) ); ?>">
									<?php
									echo esc_html( $menu_item_sub->title ); ?>
                                </a>
                            </li>
						<?php
						} ?>
                    </ul>
				<?php
				} ?>
            </li>
			<?php
		} ?>
    </ul>
</nav>