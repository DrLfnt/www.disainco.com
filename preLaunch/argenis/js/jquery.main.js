// page init
jQuery(window).load(function() {
	initBackgroundResize();
	initSectionHeight();
	initTouchHover();
	ininSetTileSize();
	initAjaxBlocksLoad();
});

function ininSetTileSize() {
	var win = jQuery(window);
	var holders = jQuery('.tile-container');
	var resizeTimer;
	var resizeDelay = 200;
	var loadingClass = 'loading';

	win.off('resize.tizeSize orientationchange.tizeSize').on('resize.tizeSize orientationchange.tizeSize', function() {
		holders.addClass(loadingClass);
		if(resizeTimer) {
			clearTimeout(resizeTimer);
		}
		resizeTimer = setTimeout(function() {
			setSizes();
			holders.removeClass(loadingClass);
		}, resizeDelay);
	});

	setSizes();
	function setSizes(){
		holders.each(function() {
			var holder = jQuery(this);
			var squares = holder.find('.square');
			holder.css({
				width:''
			});
			squares.css({
				width:''
			});
			var squareWidth = squares.first().width();
			if(!squareWidth % 2 == 0) {
				squareWidth++;
			}
			squares.css({
				width:squareWidth
			});
			holder.css({
				width:squareWidth * 3
			});
			
			squares.each(function() {
				var square = jQuery(this);
				var tiles = square.find('.tile-item');
				tiles.css({
					height:'',
					width:''
				});;
				tiles.each(function() {
					var tile = jQuery(this);
					if(tile.hasClass('small-square')) {
						tile.css({
							width: squareWidth/2,
							height: squareWidth/2
						});
					}
					if(tile.hasClass('rectangle-horz')) {
						tile.css({
							width: squareWidth,
							height: squareWidth/2
						});
					}
					if(tile.hasClass('rectangle-vert')) {
						tile.css({
							width: squareWidth/2,
							height: squareWidth
						});
					}
					imageScale(tile);
				});
			});
		});
	}
}

function initTouchHover() {
	var isTouchDevice = /MSIE 10.*Touch/.test(navigator.userAgent) || ('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch;
	var hoverClass = 'hover';
	var items = jQuery('.tile-container .tile-item a');
	items.each(function() {
		var item = jQuery(this);

		if(isTouchDevice) {
			item.off('click.hover').on('click.hover', function(e) {
				if(!item.hasClass(hoverClass)) {
					e.preventDefault();
					item.addClass(hoverClass);
					items.not(item).removeClass(hoverClass);
				}
			});
		} else {
			item.off('mouseenter.hover').on('mouseenter.hover', function() {
				item.addClass(hoverClass);
			}).off('mouseleave.hover').on('mouseleave.hover', function() {
				item.removeClass(hoverClass);
			});
		}
	});
}

function initSectionHeight(){
	var win = jQuery(window);
	var holders = jQuery('.visual-section');

	win.on('resize orientationchange', function() {
		setSize();
	});
	setSize();
	function setSize() {
		holders.each(function() {
			var holder = jQuery(this);
			var colImg = holder.find('.col-img');
			var colInfo = holder.find('.col-info');
			var imgArea = colInfo.find('.img-area');
			var imgBig = colImg.find('img');

			// reset
			imgArea.css({
				marginTop:''
			});
			colImg.css({
				height:''
			});
			imgBig.css({
				margin:'',
				width:'',
				height:''
			});

			if(colImg.height() > colInfo.height()) {
				imgArea.css({
					marginTop: colImg.height() - colInfo.height()
				});
			}
			if(colImg.height() < colInfo.height()) {
				colImg.css({
					height:colInfo.height()
				});
				imageScale(colImg);
			}
			
		});
	}
}

function imageScale(slide) {
	var image = slide.find('img');
	image.css({
		width: '100%',
		height: 'auto'
	});

	var imageHeight = image.height();
	var frameHeight = slide.height();

	if (imageHeight >= frameHeight) {
		image.css({
			marginLeft:'',
			marginTop: (frameHeight - imageHeight)/2
		})
	} else {
		image.css({
			width: 'auto',
			height: '100%',
			marginTop:''
		});
		image.css({
			marginLeft: (slide.width() - image.width())/2
		});
	}
}

// stretch background to fill blocks
function initBackgroundResize() {
	jQuery('.bg-stretch').each(function() {
		ImageStretcher.add({
			container: this,
			image: 'img'
		});
	});
}