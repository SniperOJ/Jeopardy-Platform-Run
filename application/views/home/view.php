<link rel="stylesheet" type="text/css" href="./assets/css/normalize.css" />
<link rel="stylesheet" type="text/css" href="./assets/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="./assets/css/sidebar.css" />
<link rel="stylesheet" href="./assets/css/style.css">

<script src="./asstes/js/modernizr.js"></script>
<script src="./assets/js/right.js"></script>
<script src="./assets/js/snap.svg-min.js"></script>
<script src="./assets/js/tether.js"></script>



<nav id="menu" class="menu">
	<button class="menu__handle"><span>Menu</span></button>
	<div class="menu__inner">
		<ul>
			<li><a href="index.html#"><span ><p align=center ><font size='5'>主页<span></font></p></a></li>
			<li><a href="index.html#"><span ><p align=center ><font size='5'>挑战<span></font></p></a></li>
			<li><a href="index.html#"><span ><p align=center ><font size='5'>新闻<span></font></p></a></li>
			<li><a href="index.html#"><span ><p align=center ><font size='5'>我的<span></font></p></a></li>
			<li><a href="index.html#"><span ><p align=center ><font size='5'>设置<span></font></p></a></li>
		</ul>
	</div>
	<div class="morph-shape" data-morph-open="M300-10c0,0,295,164,295,410c0,232-295,410-295,410" data-morph-close="M300-10C300-10,5,154,5,400c0,232,295,410,295,410">
		<svg width="100%" height="100%" viewBox="0 0 600 800" preserveAspectRatio="none">
			<path fill="none" d="M300-10c0,0,0,164,0,410c0,232,0,410,0,410"/>
		</svg>
	</div>
</nav>


<div class="main">
	<header class="codrops-header">
	<a id="cd-menu-trigger" href="index.html#0"><span class="cd-menu-text">Menu</span><span class="cd-menu-icon"></span></a>
	
	</header>
</div>
	
<script src="/assets/js/classie.js"></script>
<script>
	(function() {
		function SVGMenu( el, options ) {
			this.el = el;
			this.init();
		}
		SVGMenu.prototype.init = function() {
			this.trigger = this.el.querySelector( 'button.menu__handle' );
			this.shapeEl = this.el.querySelector( 'div.morph-shape' );
			var s = Snap( this.shapeEl.querySelector( 'svg' ) );
			this.pathEl = s.select( 'path' );
			this.paths = {
				reset : this.pathEl.attr( 'd' ),
				open : this.shapeEl.getAttribute( 'data-morph-open' ),
				close : this.shapeEl.getAttribute( 'data-morph-close' )
			};
			this.isOpen = false;
			this.initEvents();
		};
		SVGMenu.prototype.initEvents = function() {
			this.trigger.addEventListener( 'click', this.toggle.bind(this) );
		};
		SVGMenu.prototype.toggle = function() {
			var self = this;
			if( this.isOpen ) {
				classie.remove( self.el, 'menu--anim' );
					setTimeout( function() { classie.remove( self.el, 'menu--open' );	}, 250 );
			}
			else {
				classie.add( self.el, 'menu--anim' );
					setTimeout( function() { classie.add( self.el, 'menu--open' );	}, 250 );
			}
			this.pathEl.stop().animate( { 'path' : this.isOpen ? this.paths.close : this.paths.open }, 350, mina.easeout, function() {
				self.pathEl.stop().animate( { 'path' : self.paths.reset }, 800, mina.elastic );
			} );
			
			this.isOpen = !this.isOpen;
		};
		new SVGMenu( document.getElementById( 'menu' ) );
	})();
</script>

<nav id="cd-lateral-nav">
</nav>
