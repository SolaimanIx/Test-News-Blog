<?php echo view('front.layouts.header', ['title'=>trans('main.home')]); ?>
<?php
$latest = db_first('news', 'order by id desc');
?>
<div class="p-4 p-md-5 mb-4 rounded text-body-emphasis bg-body-secondary">
	<div class="col-lg-6 px-0">
		<h1 class="display-4 fst-italic"><?php echo $latest['title']; ?></h1>
		<p class="lead my-3"><?php echo $latest['description']; ?></p>
		<p class="lead mb-0">
			<a href="<?php echo  url('news?category_id='.$latest['category_id'].'&id='.$latest['id']) ; ?>"
				class="text-body-emphasis fw-bold">
				<?php echo  trans('main.readmore') ; ?>

			</a>
		</p>
	</div>
</div>

<?php

$news1 = db_first('news', 'JOIN categories on news.category_id = categories.id

   order by news.id desc', "
   categories.name as cat_name,
   categories.id as cat_id,
   news.title, 
   news.id, 
   news.description, 
   news.created_at, 
   news.image
   ");


$news2 = db_first('news', 'JOIN categories on news.category_id = categories.id 
where news.category_id!="' . $news1['cat_id'] . '"

   order by news.id desc', "
   categories.name as cat_name,
   categories.id as cat_id,
   news.title, 
   news.id, 
   news.description, 
   news.created_at, 
   news.image
   ");



?>
<div class="row mb-2">


	<?php if(!empty($news1)): ?>
	<div class="col-md-6">
		<div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
			<div class="col p-4 d-flex flex-column position-static">
				<strong class="d-inline-block mb-2 text-primary-emphasis"><?php echo $news1['cat_name']; ?></strong>
				<h3 class="mb-0"><?php echo $news1['title']; ?></h3>
				<div class="mb-1 text-body-secondary"><?php echo  $news1['created_at'] ; ?></div>
				<p class="card-text mb-auto"><?php echo  $news1['description'] ; ?></p>

				<a href="<?php echo  url('news?category_id='.$news1['cat_id'].'&id='.$news1['id']) ; ?>"
					class="icon-link gap-1 icon-link-hover stretched-link">
					<?php echo  trans('main.readmore') ; ?>
					<svg class="bi">
						<use xlink:href="#chevron-right" />
					</svg>
				</a>
			</div>
			<div class="col-auto d-none d-lg-block">
				<?php
       if (!empty($news1['image'])) {
           $img = url('storage/' . $news1['image']);
       } else {
           $img = url('assets/images/icon.jpeg');
       }
?>
				<img src="<?php echo $img; ?>" class="bd-placeholder-img" style="width:200px;height:250px;" />



			</div>
		</div>
	</div>
	<?php endif; ?>
	<?php if(!empty($news2)): ?>
	<div class="col-md-6">
		<div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
			<div class="col p-4 d-flex flex-column position-static">
				<strong class="d-inline-block mb-2 text-primary-emphasis"><?php echo $news2['cat_name']; ?></strong>
				<h3 class="mb-0"><?php echo $news2['title']; ?></h3>
				<div class="mb-1 text-body-secondary"><?php echo  $news2['created_at'] ; ?></div>
				<p class="card-text mb-auto"><?php echo  $news2['description'] ; ?></p>

				<a href="<?php echo  url('news?category_id='.$news2['cat_id'].'&id='.$news2['id']) ; ?>"
					class="icon-link gap-1 icon-link-hover stretched-link">
					<?php echo  trans('main.readmore') ; ?>
					<svg class="bi">
						<use xlink:href="#chevron-right" />
					</svg>
				</a>
			</div>
			<div class="col-auto d-none d-lg-block">
				<?php
if (!empty($news2['image'])) {
    $img = url('storage/' . $news2['image']);
} else {
    $img = url('assets/images/icon.jpeg');
}
?>
				<img src="<?php echo $img; ?>" class="bd-placeholder-img" style="width:200px;height:250px;" />



			</div>
		</div>
	</div>
	<?php endif; ?>

</div>


		<nav class="blog-pagination" aria-label="Pagination">
			<a class="btn btn-outline-primary rounded-pill" href="#">Older</a>
			<a class="btn btn-outline-secondary rounded-pill disabled" aria-disabled="true">Newer</a>
		</nav>


	<div class="col-md-4">
		<div class="position-sticky" style="top: 2rem;">
		 
<?php 
$latest_newes = db_get('news',"order BY id desc limit 10"); 
?>
			<div>
				<h4 class="fst-italic"><?php echo trans('main.latest_news'); ?></h4>
				<ul class="list-unstyled">
          <?php while($news = mysqli_fetch_assoc($latest_newes['query'])): ?>
					<li>
						<a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top"
							href="<?php echo  url('news?category_id='.$news['category_id'].'&id='.$news['id']) ; ?>">
              <?php
if (!empty($news['image'])) {
    $img = url('storage/' . $news['image']);
} else {
    $img = url('assets/images/icon.jpeg');
}
?>
				<img src="<?php echo $img; ?>" class="bd-placeholder-img" style="width:100%;height:96px;" />

							<div class="col-lg-8">
								<h6 class="mb-0"><?php echo $news['title']; ?></h6>
								<small class="text-body-secondary"><?php echo $news['created_at']; ?></small>
							</div>
						</a>
					</li>
			  <?php endwhile; ?>
				</ul>
			</div>
<?php
$years = db_get('news', ' GROUP BY YEAR(created_at)');
?>
			<div class="p-4">
				<h4 class="fst-italic"><?php echo trans('main.archives'); ?></h4>
				<ol class="list-unstyled mb-0">
        <?php while($year = mysqli_fetch_assoc($years['query'])): 
          $news_year = date('Y', strtotime($year['created_at']));
          ?>
					<li><a href="<?php echo url('news/archive?year='.$news_year); ?>"><?php echo  $news_year ; ?></a></li>
        <?php endwhile; ?>  
				</ol>
			</div>

			<div class="p-4">
				<h4 class="fst-italic">Elsewhere</h4>
				<ol class="list-unstyled">
					<li><a href="#">GitHub</a></li>
					<li><a href="#">Twitter</a></li>
					<li><a href="#">Facebook</a></li>
				</ol>
			</div>
		</div>
	</div>
</div>
<?php echo view('front.layouts.footer'); ?>