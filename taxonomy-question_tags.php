<?php get_header();
	$vbegy_sidebar_all = vpanel_options("sidebar_layout");
	$tag_description   = tag_description();
	$tax_slug          = get_term_by('slug',get_query_var('term'),esc_attr(get_query_var('taxonomy')));
	$paged             = (get_query_var("paged") != ""?(int)get_query_var("paged"):(get_query_var("page") != ""?(int)get_query_var("page"):1));
	$sticky_questions  = get_option('sticky_questions');
	$active_sticky     = true;
	if (!empty($tag_description)) {?>
		<article class="post clearfix">
			<div class="post-inner">
		        <h2 class="post-title"><?php echo esc_html__("Tag","vbegy")." : ".esc_attr(single_tag_title("", false));?></a></h2>
		        <div class="post-content">
		            <?php echo $tag_description?>
		        </div><!-- End post-content -->
		    </div><!-- End post-inner -->
		</article><!-- End article.post -->
	<?php }
	$custom_args = array('tax_query' => array(array('taxonomy' => 'question_tags','field' => 'slug','terms' => $tax_slug->slug)));
	include("sticky-question.php");
	
	$user_id_query = array("key" => "user_id","compare" => "NOT EXISTS");
	$args = array_merge($custom_args,$post__not_in,array("paged" => $paged,"meta_query" => array($user_id_query)));
	query_posts($args);
	$active_sticky = false;
	get_template_part("loop-question","category");
	vpanel_pagination();
get_footer();?>