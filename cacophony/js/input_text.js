// Effects to request viewer input.

var input_thanks,
	input_save_to,
	input_jump_to,
	input_options = [],
	input_value = 'Default',
	input_choice = false,
	input_autocomplete;

// Request viewer input as a single-line text box. The `jump_to`
// option will optionally call `cacophony.jumpTo()` after the
// form has been submitted, allowing you to create a loop while
// the form is being shown that is then broken out of afterwards.
// The `save_to` option will send the choice to the URL specified,
// accessible via `$_POST['input']`. The value is also accessible
// to subsequent effects via the global input_value variable.
//
// Usage:
//
//     {a:'input_text_lp', d:{
//         msg: 'Please enter your name',
//         thanks: 'Thanks for your input',
//         value: 'Initial value',
//         save_to: '/save_input.php',
//			top: 300,
//			left:300
//     }}
//
// Auto-complete is also possible, but you must include your own
// copy of jQuery UI. This way, Cacophony avoids conflicts with
// existing sites should we provide our own.
//
// Usage:
//
//     {a:'input_text', d:{
//         msg: 'Please enter your city',
//         save_to: '/save_input.php',
//         jump_to: 10,
//         autocomplete: list_of_cities
//     }}
function input_text (data) {
	cacophony.input = true;
	input_thanks = data.thanks;
	input_save_to = data.save_to;
	input_jump_to = data.jump_to;
	if (! data.value) {
		data.value = '';
	}

	if (data.autocomplete) {
		input_autocomplete = data.autocomplete;
		autocomplete = 'onfocus="$(this).autocomplete ({source: input_autocomplete})"';
	} else {
		autocomplete = '';
	}

	cacophony.html (
		'<div style="width: ' + Math.round (cacophony.width * .7) + 'px; height: ' + Math.round (cacophony.height * .35) + 'px; background-color: rgba(255, 255, 255, .7); padding: 20px; text-align: left; border-radius: 10px">' +
		'<form onsubmit="return input_save (this)" style="display: inline">' +
		'<p>' + data.msg + '</p>' +
		'<p><input type="text" id="input-field" name="input-field" value="' + data.value + '" ' + autocomplete + ' style="border: 1px solid #666; width: 70%; height: 20px" />' +
		'&nbsp;<input type="submit" value="Enregistrer" />&nbsp;<input type="button" onclick="return input_cancel ()" value="Annuler" ></p>' +
		'</form></div>',data.top,data.left);
}


// Handles the input for `input_text` and `input_textarea`.
function input_save () {
	cacophony.input = false;
	input_value = $('#input-field').get (0).value;
	$.post (input_save_to, { input: input_value });
	cacophony.html (
		'<div style="width: ' + Math.round (cacophony.width * .6) + 'px; height: ' + Math.round (cacophony.height * .35) + 'px; background-color: rgba(255, 255, 255, .7); padding: 20px; text-align: left; border-radius: 10px">' +
		'<p style="width: 100%">' + input_thanks + '</p>' +
		'</div>');
	setTimeout ('cacophony.html ();', 3000);
	if (input_jump_to) {
		cacophony.jumpTo (input_jump_to);
		input_jump_to = false;
	}
	return false;
}

function input_cancel () {
	cacophony.input = false;
	input_value = false;
	cacophony.html ();
	if (input_jump_to) {
		cacophony.jumpTo (input_jump_to);
		input_jump_to = false;
	}
	return false;
}

// Register all effects.
_e['input_text_lp'] = input_text;
