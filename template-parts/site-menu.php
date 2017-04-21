<?php
/**
 * Override the corona template to avoid outputting the mobile menu toggler
 * and secondary menu.
 *
 * @package techcamp
 */

if ( has_nav_menu( 'primary' ) ) : ?>
  <nav id="nav-primary" class="nav-primary" role="navigation">

    <?php corona_menu_top( 'primary' ); ?>
    <?php corona_get_menu( 'primary' ); ?>
    <?php corona_menu_bottom( 'primary' ); ?>

  </nav><!-- .nav-primary -->
<?php endif; ?>
