<?php
include_once 'template.php';

echo pageHeader('Test Page');

?>

<div class="box">
	<p>Some Content Here.</p>
	<table>
		<tr><th>first column</th><th>Second Column</th></tr>
		<tr><td>1</td><td>2</td></tr>
		<tr><td>2</td><td>4</td></tr>
		<tr><td>3</td><td>6</td></tr>
		<tr><td>4</td><td>8</td></tr>
	</table>
</div>

<?= pageFooter(__FILE__);