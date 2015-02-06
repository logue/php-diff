<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>PHP LibDiff - Examples</title>
		<link rel="stylesheet" href="styles.css" type="text/css" charset="utf-8"/>
	</head>
	<body>
		<h1>PHP LibDiff - Examples</h1>
		<hr />
		<?php

		// Include the diff class
spl_autoload_register(function($class) {
	$parts = explode('\\', $class);

	# Support for non-namespaced classes.
	$parts[] = str_replace('_', DIRECTORY_SEPARATOR, array_pop($parts));

	//$path = implode(DIRECTORY_SEPARATOR, $parts);
	$path = '../lib/' . implode(DIRECTORY_SEPARATOR, $parts);

	$file = stream_resolve_include_path($path.'.php');
	if($file !== false) {
		require $file;
	}
});

		// Include two sample files for comparison
		$a = explode("\n", file_get_contents(dirname(__FILE__).'/a.txt'));
		$b = explode("\n", file_get_contents(dirname(__FILE__).'/b.txt'));

		// Options for generating the diff
		$options = array(
			//'ignoreWhitespace' => true,
			//'ignoreCase' => true,
			'title_a'=>'旧',
			'title_b'=>'新',
			'labelDifferences'=>'差分'
		);

		// Initialize the diff class
		$diff = new \Diff($a, $b, $options);

		?>
		<h2>Side by Side Diff</h2>
		<?php

		// Generate a side by side diff
		$renderer = new \Diff\Renderer\Html\SideBySide;
		echo $diff->Render($renderer);

		?>
		<h2>Inline Diff</h2>
		<?php

		// Generate an inline diff
		$renderer = new \Diff\Renderer\Html\Inline;
		echo $diff->render($renderer);

		?>
		<h2>Unified Diff</h2>
		<pre><?php

		// Generate a unified diff
		$renderer = new \Diff\Renderer\Text\Unified;
		echo htmlspecialchars($diff->render($renderer));

		?>
		</pre>
		<h2>Context Diff</h2>
		<pre><?php

		// Generate a context diff
		$renderer = new \Diff\Renderer\Text\Context;
		echo htmlspecialchars($diff->render($renderer));
		?>
		</pre>
	</body>
</html>