<?php
/**
 * Part for displaying Entry Pagination
 *
 * @package Fold
 */

declare(strict_types=1);

if ( is_singular() ) {
	wp_link_pages(
		array(
			// HTML or text to prepend to each link. Default is <p> Pages:.
			'before'         => '<nav class="link-pages-nav" aria-label="' . esc_attr__( 'Pagination', 'fold' ) . '"><ul class="pagination justify-content-center">',
			// HTML or text to append to each link. Default is </p>.
			'after'          => '</ul></nav>',
			// HTML or text to prepend to each link, inside the <a> tag. Also prepended to the current item, which is not linked.
			// 'link_before'      => '<span> </span>',
			// HTML or text to append to each Pages link inside the <a> tag. Also appended to the current item, which is not linked.
			// 'link_after'       =>
			// The value for the aria-current attribute. Possible values are 'page', 'step', 'location', 'date', 'time', 'true', 'false'. Default is 'page'.
			// 'aria_current'     =>
			// Indicates whether page numbers should be used. Valid values are number and next. Default is 'number'.
			'next_or_number' => 'number',
			// Text between pagination links. Default is ‘ ‘.
			// 'separator'        =>
			// Link text for the next page link, if available. Default is ‘Next Page’.
			// 'nextpagelink'     => esc_html__( 'Next', 'fold' ),
			// Link text for the previous page link, if available. Default is ‘Previous Page’.
			// 'previouspagelink' => esc_html__( 'Previous', 'fold' ),
			// Format string for page numbers. The % in the parameter string will be replaced with the page number, so ‘Page %’ generates "Page 1", "Page 2", etc.
			// Defaults to '%', just the page number.
			// 'pagelink'         => '%',
			// Whether to echo or not. Accepts 1|true or 0|false. Default 1|true.
			// 'echo'             => true,

		)
	);
}//end if
