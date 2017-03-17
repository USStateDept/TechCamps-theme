<div class="top-bar">
	<div class="container container--top-bar">
		<?php wp_nav_menu( array(
			'theme_location'  => 'header-social',
			'container_class' => 'top-bar__social social-menu',
			'link_before'     => '<span class="element-invisible">',
			'link_after'      => '</span>',
			'fallback_cb'     => ''
		) ); ?>
		<div class="top-bar__utility">
			<div class="top-bar__search top-search">
				<form id="header-search-form" class="top-search__form">
					<input name="s" type="text" placeholder="Type here&hellip;" />
					<input type="submit" value="Go" />
				</form>
				<a href="#" id="headersearchtoggle" class="top-search__toggle">Search</a>
			</div>
			<?php wp_nav_menu( array(
				'theme_location'  => 'header-utility',
				'container_class' => 'top-bar__menu utility-menu',
				'fallback_cb'     => ''
			) ); ?>
		</div>
	</div>
</div>
<div class="header">
	<div class="container container--header">
