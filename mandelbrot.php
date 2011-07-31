<?php

	/* SVG Mandelbrot Set
	   Brenden Kokoszka */
	
	//XHTML Content Type
	header('content-type: application/xhtml+xml; charset=UTF-8');

        $from = new complex();
	$to = new complex();

	if ($_GET['bsize']!=NULL && $_GET['real']!=NULL && $_GET['imaginary']!=NULL) {
	
		$from->real = $_GET['real'];
		$from->imaginary = $_GET['imaginary'];
		$to->real = $_GET['real']+$_GET['bsize'];
                $to->imaginary = $_GET['imaginary']+$_GET['bsize'];
	        $resolution = 1.0*$_GET['bsize']/200;
	}
	else {

	        $from->real = -1.6;
        	$from->imaginary = -1;
	        $to->real = 1;
                $to->imaginary = 1;
	        $resolution = .01;
        }

	//echo $from->real;
	//echo $resolution;
	//$resolution = .01;
	//echo $resolution;
	$escape_depth = 15;
        $set = define_set($from, $to, $resolution, $escape_depth);

	//Representation of a complex number
	class complex {
	
		//A complex number has a real and imaginary part
		public $real = 0;
		public $imaginary = 0;

		//Returns the product of two complex numbers
		public function times($other) {

			$result = new complex();
			$result->real = ($this->real*$other->real) - ($this->imaginary*$other->imaginary);
			$result->imaginary = ($this->real*$other->imaginary) + ($this->imaginary*$other->real);

			return $result;
		}

		//Returns the sum of two complex numbers
		public function plus($other) {

                        $result = new complex();
			$result->real = $this->real+$other->real;
			$result->imaginary = $this->imaginary+$other->imaginary;

			return $result;
		}

		//Returns the Euclidean distance between the complex number and the origin on the complex plane
		public function magnitude() {

                	return sqrt(pow($this->real, 2)+pow($this->imaginary, 2));	
		}
	}

	//Returns of set of complex points within the Mandelbrot set
	function define_set($min, $max, $resolution, $escape_depth) {
	
		$set = array();

		for ($r = $min->real; $r<$max->real; $r+=$resolution) {

			$set[$r] = array();

			for ($i = $min->imaginary; $i<$max->imaginary; $i+=$resolution) {

				$current = new complex();
				$current->real = $r;
				$current->imaginary = $i;
				$set[round($r, 7).""][round($i, 7).""] = in_mandelbrot($current, $escape_depth);
			}
		}

		return $set;
	}

	//Returns a 0 if point is in set (given escape depth); if not in set, returns the number of iterations before escaping
	function in_mandelbrot($point, $escape_depth) {
	
		$mandelbrot = function($z ,$c) {return $z->times($z)->plus($c);};

		$zn = new complex();
		$zn->real = 0;
		$zn->imaginary = 0;

		for ($i=0; $i<$escape_depth; $i++) {

			$zn = $mandelbrot($zn, $point);

			if ($zn->magnitude()>=2) {

				return $i;
			}
		}

		return 0;
	}

	//Echo the SVG XML of a Mandelbrot set
	function draw_mandelbrot($points, $resolution, $init) {	

		$reals = array_keys($points);
		$imaginaries = array_keys($points[$reals[0]]);
                $drawing_space = 800;

		//Parameters for the drawing algorithm
		$block = 3;   //The side length of the square used to represent a single point
		$max_sub = 15; //The max number of points to try to group together for drawing
		$min_sub = 0;  //The min number of points to try to group together for drawing
		$step = 3;     //The step size down from $max_sub to $min_sub

                ?>
                        <svg 
				width="<?php echo $drawing_space; ?>" 
				height="<?php echo $drawing_space; ?>" 
				version="1.1" xmlns="http://www.w3.org/2000/svg"
			>
                <?php	

		$t = 0;
		$colors = array('red', 'black', 'green', 'blue', 'orange', 'yellow', 'pink', 'brown');

		for ($size=$max_sub; $size>=$min_sub; $size-=$step) {

			$size = ($size==0) ? 1 : $size;	
			$points = fill_blocks($points, $size, $reals, $imaginaries, $block, $resolution, $init);
			$t++;
		}

		echo "</svg>";
	}

	//Fill in large uniform blocks
	function fill_blocks($points, $size, $reals, $imaginaries, $block, $resolution, $init) {

		for ($r=0; $r<sizeof($reals); $r+=$size) {

		        for ($i=0; $i<sizeof($imaginaries); $i+=$size) {

				//If the block is connected...
		        	$connected = 1;

		                for ($row=$r; $row<$r+$size; $row++) {

		                	for ($col=$i; $col<$i+$size; $col++) {

		                        	if ($points[$reals[$row]][$imaginaries[$col]]!=0) {

		                                	$connected = 0;
		                                        break;
		                                }
		                        }
		                }

				//...then spit out an SVG for the block and mark the block as drawn
		                if ($connected) {

			                for ($row=$r; $row<$r+$size; $row++) {
						
						for ($col=$i; $col<$i+$size; $col++) {
							
							$points[$reals[$row]][$imaginaries[$col]] = -1;
						}
					}

					draw_block($row, $col, $size, $block, $resolution, $init);
        	                }
        		}
		}

		return $points;
	}

	//Echo out SVG code for a block
	function draw_block($row, $col, $size, $block, $resolution, $init) {

        	?>
	        	<rect 
                                x="<?php echo $row*$block-$block*$size; ?>"
                                y="<?php echo $col*$block-$block*$size; ?>"
                                width="<?php echo $size*$block; ?>"
                        	height="<?php echo $size*$block; ?>"
                		style="<?php echo "fill:gray; stroke-width:1; stroke:black;" ?>"
				id="<?php echo "$row-$col-$size" ?>"
				data-real="<?php echo 1.0*$init->real+$row*$resolution-$size*$resolution ?>"
				data-imaginary="<?php echo 1.0*$init->imaginary+$col*$resolution-$size*$resolution ?>"
				data-bsize="<?php echo 1.0*$resolution*$size?>"
        		/>
		<?php
	}
?>
