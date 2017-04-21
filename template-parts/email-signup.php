<?php
/**
* Template partial that displays the email signup form.
*
* @package techcamp
*/
?>

<form class="email-signup">
	<label for="email-signup-name" class="element-invisible">Name (Required)</label>
	<input id="email-signup-name" class="email-signup__input" type="text" name="name" placeholder="Name (Required)" value="" />
	<label for="email-signup-email" class="element-invisible">Email Address (Required)</label>
	<input id="email-signup-email" class="email-signup__input" type="text" name="email" placeholder="Email Address (Required)" value="" />
	<input class="email-signup__submit" type="submit" value="Sign Up" />
</form>
