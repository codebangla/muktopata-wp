<?php
/* Template Name: Portfolio */


get_header(); 

query_posts('post_type=portfolio&posts_per_page=9');


?>

<div id="content" class="group"> 

<h2>Portfolio of Work</h2>

<div class="group">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<?php
		$title= str_ireplace('"', '', trim(get_the_title()));
		$desc= str_ireplace('"', '', trim(get_the_content()));
	?>	

	<div class="item">
				<div class="img"><a title="<?=$title?>: <?=$desc?>" rel="lightbox[work]" href="<?php print  portfolio_thumbnail_url($post->ID) ?>"><?php the_post_thumbnail(); ?></a></div>
				<p><strong><?=$title?>:</strong> <?php print get_the_excerpt(); ?> <a title="<?=$title?>: <?=$desc?>" rel="lightbox[work]" href="<?php print  portfolio_thumbnail_url($post->ID) ?>">(more)</a></p>
				<?php $site= get_post_custom_values('projLink'); 
					if($site[0] != ""){
				
				?>
					<p><a href="<?=$site[0]?>">Visit the Site</a></p>
					
				<?php }else{ ?>
					<p><em>Live Link Unavailable</em></p>
				<?php } ?>
			</div>

		
<?php endwhile; endif; ?>

</div>

</div>

<?php get_footer(); ?>