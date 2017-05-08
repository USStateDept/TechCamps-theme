<?php
/**
 * The top sticky bar. Has many forms.
 *
 * @package techcamp
 */

// get main menu
$main_menu = wp_nav_menu( array(
	'theme_location'  => 'header-sticky-nav',
	'container_class' => 'top-bar__nav',
	'menu_id'         => false,
	'container_id'    => false,
	'fallback_cb'     => '',
	'echo'            => false,
) );

// get utility menu (contact link)
$utility_menu = wp_nav_menu( array(
	'theme_location'  => 'header-utility',
	'container_class' => 'top-bar__menu utility-menu',
	'menu_id'         => false,
	'container_id'    => false,
	'fallback_cb'     => '',
	'echo'            => false,
) );

// get social menu
$social_menu = wp_nav_menu( array(
	'theme_location'  => 'header-social',
	'container_class' => 'top-bar__social social-menu',
	'menu_id'         => false,
	'container_id'    => false,
	'link_before'     => '<span class="element-invisible">',
	'link_after'      => '</span>',
	'fallback_cb'     => '',
	'echo'            => false,
) );

?>

<div class="top-bar top" id="top-bar">
	<div class="container container--top-bar">
		<div class="top-bar__logo">
			<?php if ( is_front_page() ) { echo '<h1>'; } ?>
				<a class="top-bar__t" href="<?php echo site_url(); ?>">
					<?php get_template_part( 'template-parts/logo.svg' ); ?>
					<span class="top-bar__t__center"></span>
					<span class="element-invisible">TechCamp</span>
				</a>
			<?php if ( is_front_page() ) { echo '</h1>'; } ?>
		</div>
		<?php echo $social_menu; ?>
		<div class="top-bar__utility">
			<div class="top-bar__search top-search">
				<form id="header-search-form" class="top-search__form" action="<?php echo site_url(); ?>">
					<label class="element-invisible" for="top-search-submit">Search</label>
					<input id="top-search-submit" class="top-search__input" name="s" type="text" placeholder="Type here&hellip;" value="<?php echo esc_attr( get_search_query() ); ?>" />
					<input class="top-search__submit" type="submit" value="Go" />
				</form>
				<a href="#" id="header-search-toggle" class="top-search__toggle">Search</a>
			</div>
			<?php echo $utility_menu; ?>
			<?php echo $main_menu; ?>
		</div>
		<div class="mobile-toggle top-bar__mobile-toggle" aria-controls="mobile-expand" aria-expanded="false">
			<button class="hamburger hamburger--3dy" type="button">
				<span class="element-invisible">Toggle Menu</span>
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</button>
		</div>
	</div>

	<div id="mobile-expand" class="mobile-expand" aria-expanded="false">
		<?php echo $main_menu; ?>
		<form id="mobile-search-form" class="top-search__form" action="<?php echo site_url(); ?>">
			<label class="element-invisible" for="mobile-search-submit">Search</label>
			<input id="mobile-search-submit" class="top-search__input" name="s" type="text" placeholder="Type here&hellip;" value="<?php echo esc_attr( get_search_query() ); ?>" />
			<input class="top-search__submit" type="submit" value="Go" />
		</form>
		<?php echo $utility_menu; ?>
		<?php echo $social_menu; ?>
	</div>

</div>
<div class="header">
	<div class="container container--header">
