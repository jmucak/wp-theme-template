<?php
/**
 * @var int $current_page
 * @var int $max_pages
 * @var array $params
 * @var string $query
 * @var string $url
 */

use wsytesTheme\helpers\PaginationHelper;

if ( ! empty( $max_pages ) && ! empty( $current_page ) && $max_pages > 1 ) {
	$prev_page = PaginationHelper::get_pagination_start_page( $current_page );
	$next_page = PaginationHelper::get_pagination_end_page( $current_page, $max_pages );
	?>
    <div class="o-pagination">
        <div class="o-container">
            <ul class="c-pagination u-b0">

                <li class="c-pagination__item">
                    <a href="<?php
					echo sprintf( '%spage/%s%s', $url, $current_page - 1, $query ) ?>" data-val="<?php
					echo $current_page > 1 ? $current_page - 1 : ''; ?>"
                       class="c-pagination-arrow c-pagination-arrow--previous js-pagination-item <?php
					   echo $current_page > $prev_page ? '' : 'is-disabled'; ?>">
						<?php
						echo get_icon( 'arrow-right' ); ?>
                        <span class="">Prev</span>
                    </a>
                </li>

				<?php
				if ( $prev_page > 1 ) { ?>
                    <li class="c-pagination__item">
                        <a href="<?php
						echo sprintf( '%spage/%s%s', $url, 1, $query ) ?>" data-val="1" id="1"
                           class="c-pagination-number <?php
						   echo $prev_page === $current_page ? 'is-active' : '' ?> js-pagination-item">
                            <span>1</span>
                        </a>
                    </li>
                    <li class="c-pagination__item">
                    <span class="c-pagination-separator">
                        ...
                    </span>
                    </li>
					<?php
				}
				for ( $i = $prev_page; $i < $next_page; $i ++ ) {
					?>
                    <li class="c-pagination__item">
                        <a href="<?php
						echo sprintf( '%spage/%s%s', $url, $i, $query ) ?>" data-val="<?php
						echo $i; ?>" id="<?php
						echo $i; ?>"
                           class="c-pagination-number <?php
						   echo $i === $current_page ? 'is-active' : '' ?> js-pagination-item">
							<?= $i ?>
                        </a>
                    </li>
					<?php
				}
				if ( $next_page < $max_pages ) { ?>
                    <li class="c-pagination__item">
                    <span class="c-pagination-separator">
                        ...
                    </span>
                    </li>
                    <li class="c-pagination__item">
                        <a href="<?php
						echo sprintf( '%spage/%s%s', $url, $max_pages, $query ) ?>" data-val="<?php
						echo $max_pages ?>" id="<?php
						echo $max_pages ?>"
                           class="c-pagination-number <?php
						   echo $max_pages === $current_page ? 'is-active' : '' ?>js-pagination-item">
							<?php
							echo $max_pages; ?>
                        </a>
                    </li>
					<?php
				}
				?>

                <li class="c-pagination__item">
                    <a href="<?php
					echo sprintf( '%spage/%s%s', $url, $current_page + 1, $query ) ?>" data-val="<?php
					echo $current_page < $max_pages ? $current_page + 1 : ''; ?>"
                       class="c-pagination-arrow c-pagination-arrow--next <?= $current_page < $max_pages ? '' : 'is-disabled'; ?> js-pagination-item">
                        <span class="">Next</span>
						<?php
						echo get_icon( 'arrow-right' ); ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
	<?php
}
