<?php
/**
 * Template Name: Live Search
 */

get_header(); ?>

<style type="text/css">
	#car-clubs-list {
		position: absolute;
		margin: 0;
		background: #efeaea;
		z-index: 9;
		list-style: none;
		padding: 0;
		width: 100%;
		max-height: 300px;
		overflow-y: auto;
		box-shadow: 1px 5px 10px #8c8c8c;
	}
	#car-clubs-list li {
		padding: 5px;
		cursor: pointer;
		font-size: 14px;
		width: 90%;
	}
	#car-clubs-list li:not(:last-child){
		border-bottom: 1px solid #1f1c17;
	}
	#car-clubs-list li:hover {
		background-color: #1f1c17;
		color: #fff;
	}
	#car-clubs-label {
		cursor: pointer;
	}
</style>

<div id="primary" class="content-area">
	<div id="content" class="site-content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'page' ); ?>

			<?php if ( comments_open() || '0' != get_comments_number() ) : ?>
				<?php comments_template( '', true ); ?>
			<?php endif; ?>

		<?php endwhile; // end of the loop. ?>

	</div><!-- #content .site-content -->
</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		var json_path = '<?php echo get_site_url(); ?>/wp-content/themes/vantage-child-bundanoon/assets/json/car-clubs.json'; // get json source
		var json_data = '';
		$.getJSON(json_path, function(data) { json_data = data; });
		$('#car-clubs-field').after('<ul id="car-clubs-list" style="display: none;"></ul>');
		$('#car-clubs-field').keyup(function() { initSearch(); });
		$('#car-clubs-field').on('click', function() { initSearch(); });
		$('#car-clubs-list').on('click', 'li', function() {
			var click_text = $(this).text().split('|');
			$('#car-clubs-field').val($.trim(click_text[0]));
			$('#car-clubs-label').html('Car Club');
			$('#car-clubs-list').slideUp();
			$("#car-clubs-list").html('');
		});
		$('#car-clubs-label').on('click', function() {
			$('#car-clubs-label').html('Car Club');
			$('#car-clubs-list').slideUp();
			$("#car-clubs-list").html('');
		});
		const initSearch = () => {
			$('#car-clubs-list').html('');
			var searchField = $('#car-clubs-field').val();
			var expression = new RegExp(searchField, "i");
			$.each(json_data, function(key, value) {
				if (value.name.search(expression) != -1) {
					$('#car-clubs-list').append('<li>'+value.name+'</li>');
				}
			});   
			$('#car-clubs-list').fadeIn();
			$('#car-clubs-label').html('Car Club <strong>[Close]</strong>');
		};
	});
</script>

<?php get_footer(); ?>