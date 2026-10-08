<?php
/** 
 * WordPress classic theme
 * search.php
 * @link https://github/...
 * @package BootCMS
 * @since 2.0
 */

get_header();

/**
 * Create search snippets from matching content.
 *
 * @param string $content Post content.
 * @param string $search  Search term.
 * @return array
 */
function bootcms_search_snippets( $content, $search ) {
  $content = strip_shortcodes( $content );
  $content = wp_strip_all_tags( $content );
  $content = preg_replace( '/\s+/', ' ', $content );
  $content = trim( $content );
  if ( empty( $content ) || empty( $search ) ) { return array(); }
  // Split the search query into individual words.
  $words = preg_split( '/\s+/', trim( $search ) );
  $pattern = implode( '|',
	array_map(
	  function ( $word ) {
		return preg_quote( $word, '/' );
	  },
	  $words
  ) );
  // Find all occurrences.
  preg_match_all( '/' . $pattern . '/iu', $content, $matches, PREG_OFFSET_CAPTURE );
  $occurrences = count( $matches[0] );
  if ( ! $occurrences ) { return array(); }
  $snippets = array();
  // Use the first two occurrences for the displayed snippets.
  $used_sentences = array();
  foreach ( $matches[0] as $match ) {
	$position = $match[1];
	// Find the beginning of the sentence.
	$before = substr( $content, 0, $position );
	$sentence_start = max(
	  strrpos( $before, '.' ),
	  strrpos( $before, '!' ),
	  strrpos( $before, '?' )
	);
	$sentence_start = false === $sentence_start ? 0 : $sentence_start + 1;
	// Find the end of the sentence.
	$after = substr( $content, $position );
	preg_match(
	  '/[.!?](?:\s|$)/',
	  $after,
	  $end_match,
	  PREG_OFFSET_CAPTURE
	);
	if ( ! empty( $end_match ) ) {
	  $sentence_end = $position + $end_match[0][1] + 1;
	} else {
	  $sentence_end = strlen( $content ); }
	$snippet = trim(
	  substr(
		$content,
		$sentence_start,
		$sentence_end - $sentence_start
	) );
	$sentence_key = $sentence_start . '-' . $sentence_end;
	if ( in_array( $sentence_key, $used_sentences, true ) ) { continue; }
	$used_sentences[] = $sentence_key;		
	// Limit very long sentences.
	if ( mb_strlen( $snippet ) > 250 ) {
	  $snippet = mb_substr( $snippet, 0, 250 );
	  $snippet = preg_replace( '/\s+\S*$/u', '', $snippet );
	  $snippet .= '...'; }
	// Highlight the search term.
	$snippet = esc_html( $snippet );
	$snippet = preg_replace(
	  '/' . $pattern . '/iu',
	  '<mark>$0</mark>',
	  $snippet );
	$snippets[] = $snippet;
	if ( count( $snippets ) >= 2 ) { break; }
  }
  return array(
	'count'    => $occurrences,
	'snippets' => $snippets,
  );
}
?>
<div class="pages-main-section">
<div class="section-wrapper">
<?php $main_tag_classes = get_theme_mod( 'main_tag_classes', '' );
  if ( $main_tag_classes ) { $main_tag_class = $main_tag_classes;} else {$main_tag_class = 'main-tag';} ?>
<main id="main" class="<?php echo esc_attr( $main_tag_class ); ?>" itemprop="mainContentOfPage" itemscope itemtype="https://schema.org/WebPageElement">
  <header class="page-header">
	<h2 class="page-title">
	<?php
	  printf(
		esc_html__( 'Search results for: %s', 'bootcms' ),
		'<span>' . esc_html( get_search_query() ) . '</span>' );
	?>
	</h2>
	<div class="search-form">
	  <?php echo do_shortcode( '[bootcms_search]' ); ?>
	</div>		
  </header>
  <?php if ( have_posts() ) : ?>
  <div class="search-results">
  <?php
  while ( have_posts() ) :
	the_post();
	$search_data = bootcms_search_snippets(
	get_the_content(),
	get_search_query()
  ); ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class( 'search-result' ); ?> >
	<h3 class="entry-title">
	  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</h3>
	<?php if ( ! empty( $search_data ) ) : ?>
	<div class="search-occurrences">
	<?php
	  printf(
		esc_html(
		  _n(
			'%d occurrence',
			'%d occurrences',
			$search_data['count'],
			'bootcms'
		) ),
		$search_data['count']
	  );
	?>
	</div>
	<div class="search-snippets">
	  <p class="search-snippet">
		<?php foreach ( $search_data['snippets'] as $snippet ) : ?>
		<span> ... </span><?php echo wp_kses( $snippet, array( 'mark' => array() ) ); ?><span> ... </span><br>                               
		<?php endforeach; ?>
		<?php if ( $search_data['count'] > 2 ) : ?>
		<span class="search-more">... ... ...</span>
		<?php endif; ?>
	  </p>
	</div>
	<?php endif; ?>
  </article>
  <?php endwhile; ?>
  </div>
  <?php the_posts_pagination();
  else : ?>
  <p>
	<?php esc_html_e( 'No results found.', 'bootcms' ); ?>
  </p>
  <?php endif; ?>
</main>

<?php if ( is_active_sidebar( 'pages-right-sidebar' ) ) : ?>
<aside class="right-sidebar" aria-label="Page sidebar" itemprop="hasPart" itemscope itemtype="https://schema.org/WPSideBar">
  <?php dynamic_sidebar( 'pages-right-sidebar' ); ?>
</aside>
<?php endif; ?>
</div>
</div>

<?php get_footer(); ?>