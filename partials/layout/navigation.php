<?php

use wsytesTheme\helpers\MenuHelper;

$menu_items = MenuHelper::get_header_menu_items();

if ( empty( $menu_items ) ) {
	return;
}
?>
<div class="o-navigation">
    <div class="o-container">
        <div class="c-navigation">
            <nav>
                <ul class="c-navigation__list">
					<?php
					foreach ( $menu_items as $menu_item ) { ?>
                        <li class="c-navigation__item-wrapper <?php
						echo esc_attr( MenuHelper::get_has_active_class( $menu_item ) ); ?>">
                            <a href="<?php
							echo esc_url( $menu_item->url ); ?>" class="c-navigation__item">
								<?php
								echo esc_html( $menu_item->title ); ?>
                            </a>

							<?php
							if ( ! empty( $menu_item->sub ) ) { ?>
                                <ul class="c-navigation__sublist">
									<?php
									foreach ( $menu_item->sub as $menu_item_sub ) { ?>
                                        <li class="c-navigation__sublist-item-wrapper <?php
										echo esc_attr( MenuHelper::get_is_active_class( $menu_item_sub ) ); ?>">
                                            <a href="<?php
											echo esc_url( $menu_item_sub->url ); ?>" class="c-navigation__sublist-item">
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
        </div>
    </div>
</div>