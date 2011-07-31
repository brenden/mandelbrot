<?php include('mandelbrot.php') ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 plus MathML 2.0 plus SVG 1.1//EN" "http://www.w3.org/2002/04/xhtml-math-svg/xhtml-math-svg.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:svg="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:lang="en">

	<head>

		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
		<title>SVG Mandelbrot Set</title>
		<script type="text/javascript" src="jquery.js"></script>
                <script type="text/javascript" src="ui.js"></script>
		<link rel="stylesheet" type="text/css" href="style.css"/>

	</head>

	<body>

		<h1>SVG Mandelbrot Set</h1>

		<a id="help-icon" href="#">?</a>

		<div id="information">
			
			<h2>Information</h2>

                        <p>The Mandelbrot set is a set of complex numbers. It is defined as all complex numbers c for which the recurrence relation z_n+1 = (z_n)^2+c does not grow to infinty. A visualization of the Mandelbrot set can be created by plotting the real and imaginary components of each constituent complex number along the x and y axes.
                        </p>
                        <p>The Mandelbrot picture below is a Scalable Vector Graphic (SVG), not a raster image. Fractals are costly to render using SVGs because each point in the fractal must be represented by an SVG element. I tried to esacape this problem by grouping contiguous points into single-element blocks, thus greatly reducing the total amount of markup required. Clicking on each block will load a zoomed image of the points in that block, perhaps revealing details hidden at the previous resolution.
                        </p>
		</div>

		<div id="options">	
		
			<br />
			<br />	                   

			<form>

				<button id="clear">Initialize</button>

                        </form>

                        <br />
		</div>

		<div id="result">

			<?php 
                                draw_mandelbrot($set, $resolution, $from); 
			?>
		</div>
	</body>
</html>
