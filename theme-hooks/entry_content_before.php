<?php if ( is_singular( 'bio' ) ) { ?>

	<div class="bio-card">
		<div class="bio-card__container">

			<div class="bio-card__portrait">
				<?php the_post_thumbnail( 'portrait' ); ?>
			</div>

			<div class="bio-card__text">

				<h2 class="bio-card__heading"><?php echo esc_html( techcamp_get_setting( 'contact_label', 'bio' ) ); ?></h2>

				<?php
				$position     = get_post_meta( get_the_ID(), 'position', true );
				$organization = get_post_meta( get_the_ID(), 'organization', true );
				$output       = '';
				if ( $position && $organization ) {
					$output = $position . ', ' . $organization;
				} else if ( $position ) {
					$output = $position;
				} else if ( $organization ) {
					$output = $organization;
				}
				if ( $output ) { ?>
					<div class="bio-card__position">
						<?php echo esc_html( $output ); ?>
					</div>
				<?php } ?>

				<div class="bio-card__contact">
					<?php $contact = get_post_meta( get_the_ID(), 'contact', true );
					if ( $contact ) { ?>
						<ul>
						<?php foreach( $contact as $link ) {
							if ( is_email( $link ) ) { ?>
								<li><a href="mailto:<?php echo esc_attr( sanitize_email( $link ) ); ?>">Email</a></li>
							<?php } else {
								$parsed_url = parse_url( $link );
								$parsed_url = wp_parse_args( $parsed_url, array(
									'host' => ''
								) );
								$host = esc_html( $parsed_url['host'] );
								if ( substr( $host, 0, 4 ) === 'www.' ) {
									$host = substr( $host, 4 );
								}
								if ( strpos( $host, 'facebook.com' ) !== false )
									$host = 'Facebook';
								if ( strpos( $host, 'twitter.com' ) !== false )
									$host = 'Twitter';
								if ( strpos( $host, 'linkedin.com' ) !== false )
									$host = 'LinkedIn';
								if ( strpos( $host, 'youtube.com' ) !== false )
									$host = 'YouTube';
								if ( strpos( $host, 'medium.com' ) !== false )
									$host = 'Medium';
								if ( strpos( $host, 'instagram.com' ) !== false )
									$host = 'Instagram'; ?>
								<li><a target="_blank" href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $host ); ?></a></li>
							<?php } ?>
						<?php } ?>
						</ul>
					<?php } ?>

				</div>

			</div>

		</div>
	</div>

<?php } ?>

<?php if ( is_post_type_archive() || is_search() ) { ?>

	<?php if ( get_post_type() === 'event' ) { ?>

		<div class="archive-entry__meta">
			<div class="archive-entry__location detail-meta__location">
				<?php echo esc_html( techcamp_location() ); ?>
			</div>
			<div class="archive-entry__date detail-meta__date">
				<?php echo esc_html( techcamp_event_date() ); ?>
			</div>
		</div>

	<?php } ?>

<?php } ?>
