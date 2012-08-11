<?php
namespace pecs;

class MochaFormatter extends Formatter {
    static $colors = array(
        'bold'    => 1,
        'black'   => 30,
        'red'     => 31,
        'green'   => 32,
        'yellow'  => 33,
        'blue'    => 34,
        'magenta' => 35,
        'cyan'    => 36,
        'white'   => 37
    );

	var $failed = 0;

    function color($string, $color) {
        return sprintf("\033[%dm%s\033[0m", self::$colors[$color], $string);
    }

    function before() {
        $this->startTime = microtime(true);
		$this->failed = 0;
    }

    function beforeSuite($suite) {
        if ($suite instanceof \pecs\Runner) {
            return;
        }
        if (!empty($suite->specs)) {
            echo $this->color("\n  {$suite->description}\n", 'bold');
        }
    }

    function beforeSpec($spec) {
        // echo "- {$spec->description}: ";
    }

    function afterSpec($spec) {
        if ($spec->passed()) {
            echo $this->color('    ✓ ', 'green') . $spec->description . "\n";
        } else {
			$this->failed++;
			echo $this->color('    ' . $this->failed . ') ' . $spec->description, 'red') . "\n";
        }
    }

    function afterSuite($suite) {
    }

    function after() {
        $this->endTime = microtime(true);
        $this->runTime = $this->endTime - $this->startTime;

        $passed = $failed = $total = 0;
        foreach (runner()->specs as $spec) {
			$total++;
            if ($spec->failed()) {
                $count = count($spec->failures);
                $failed += $count;
                $passed += $spec->assertions - $count;
            } else {
                $passed += $spec->assertions;
            }
        }

		if ($failed) {
			echo "\n\n" . $this->color('  ✖ ' . $failed . ' of ' . $total . ' failed: ', 'red') . "\n\n";
		} else {
			$elapsed = number_format($this->runTime * 1000, 1);

			echo "\n\n" . $this->color('  ✓ ' . $total . ' test' . ($total === 1 ? '' : 's') . ' complete', 'green') .
				          $this->color(" ($elapsed ms)\n\n", 'white');
		}

		$failedNum = 0;
        foreach (runner()->specs as $spec) {
            if ($spec->failed()) {
                foreach ($spec->failures as $failure) {
					$failedNum++;
					$description = $spec->description;

					$parent = $spec->parent;
					while (!empty($parent)) {
						$description = $parent->description . ' ' . $description;
						$parent = $parent->parent;
					}

					echo '  ' . $failedNum . ') ' . $description .  ":\n";
                    echo $this->color('     ' . $failure->getMessage()."\n", 'red');
                    echo $this->color($this->indent($failure->getTraceAsString(), 4) ."\n\n", 'white');
                }
            }
        }

        $this->endTime = microtime(true);
        $this->runTime = $this->endTime - $this->startTime;
        $this->banner($passed, $failed);
    }


	function indent($str, $level = 1) {
		return str_repeat('  ', $level) . str_replace("\n", "\n" . str_repeat("  ", $level), $str);
	}

    function banner($passed, $failed) {
		/*
        echo "\nFinished in ".number_format($this->runTime, 4)." seconds\n\n";
        echo $this->color('Passed: ', 'bold');
        echo $this->color($passed, 'green');
        echo $this->color(' Failed: ', 'bold');
        echo $this->color($failed, 'red');
        echo "\n\n";
		 */
    }
}
