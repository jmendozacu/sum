<div class="container-fluid">
	<div class="home-testimonials">
		<h2 class="title">WHAT OUR USERS SAY</h2>
		
		<div class="row" id="testim-slider">
			<div class="col">
				<div class="item">
					<img src="<?php echo $this->getUrl('pub/media'); ?>/wysiwyg/home/users_01.jpg" alt="" />
					<p>Our products don’t leave a gross film that leaves you feeling sticky throughout the day. They are refreshingly light-weight and fast absorbing.</p>
					<div class="name">BRANDON LEE</div>
					<div class="position">CUSTOMER</div>
				</div>
			</div>
			<div class="col">
				<div class="item">
					<img src="<?php echo $this->getUrl('pub/media'); ?>/wysiwyg/home/users_02.jpg" alt="" />
					<p>Our products don’t leave a gross film that leaves you feeling sticky throughout the day. They are refreshingly light-weight and fast absorbing.</p>
					<div class="name">JOHN SMITH</div>
					<div class="position">CUSTOMER</div>
				</div>
			</div>
			<div class="col">
				<div class="item">
					<img src="<?php echo $this->getUrl('pub/media'); ?>/wysiwyg/home/users_03.jpg" alt="" />
					<p>Our products don’t leave a gross film that leaves you feeling sticky throughout the day. They are refreshingly light-weight and fast absorbing.</p>
					<div class="name">DAVID BRYANT</div>
					<div class="position">CUSTOMER</div>
				</div>
			</div>
			<div class="col">
				<div class="item">
					<img src="<?php echo $this->getUrl('pub/media'); ?>/wysiwyg/home/users_04.jpg" alt="" />
					<p>Our products don’t leave a gross film that leaves you feeling sticky throughout the day. They are refreshingly light-weight and fast absorbing.</p>
					<div class="name">MICHAEL DOE</div>
					<div class="position">CUSTOMER</div>
				</div>
			</div>
		</div>
	
	</div>
</div>

<script type="text/javascript">
	
	require([
			'jquery',
			'owlcarousel'
		],
		function($) {
			
			var owl = $('#testim-slider'),
				owlOptions = {
					loop: true,
					margin: 0,
					navText: ['<i class="icon-angle-left"></i>', '<i class="icon-angle-right"></i>'],
					responsiveClass: true,
					responsive: {
						0: {
							items: 1,
							nav: true
						}
					}
				};
			
			if ( $(window).width() < 768 ) {
				owl.addClass('owl-carousel').owlCarousel(owlOptions);
			}
			
			$(window).resize(function() {
				if ( $(window).width() < 768 ) {
					if ( ! owl.hasClass('owl-carousel') ) {
						owl.addClass('owl-carousel').owlCarousel(owlOptions);
					}
				} else {
					if ( owl.hasClass('owl-carousel') ) {
						owl.removeClass('owl-carousel').trigger('destroy.owl.carousel');
						owl.find('.owl-stage-outer').children(':eq(0)').unwrap();
					}
				}
			});
			
		}
	);
	
</script>