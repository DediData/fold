<?php
/**
 * Part for displaying Popup Search
 *
 * @package Fold
 */

?>
<div class="modal fade transition" id="searchModal" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content bg-transparent border-0 shadow-none">
			<div class="modal-body text-center">
				<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<input type="search" class="form-control form-control-lg text-center rounded-pill <?php echo esc_attr( FOLD()->primary_bg_mode ); ?>" placeholder="<?php esc_attr_e( 'Search...', 'fold' ); ?>" value="<?php echo get_search_query(); ?>" name="s" autofocus="autofocus" />
				</form>
			</div>
		</div>
	</div>
</div>