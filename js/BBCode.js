// Startup variables

var txt = '';
var form_name = 'body';
var text_name = 'message';
var Capspos = false;
var theSelection = false;

// Check for Browser & Platform for PC & IE specific bits
// More details from: http://www.mozilla.org/docs/web-developer/sniffer/browser_type.html

var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version
var is_ie = ((clientPC.indexOf('msie') != -1) && (clientPC.indexOf('opera') == -1));
var is_win = ((clientPC.indexOf('win') != -1) || (clientPC.indexOf('16bit') != -1));
var baseHeight;

// window.onload = initInsertions;

// Fix a bug involving the TextRange object. From
// http://www.frostjedi.com/terra/scripts/demo/caretBug.html

function initInsertions() 
{
	var doc;

	if (document.forms[form_name])
	{
		doc = document;
	}
	else 
	{
		doc = opener.document;
	}

	var textarea = doc.forms[form_name].elements[text_name];

	if (is_ie && typeof(baseHeight) != 'number')
	{
		textarea.focus();
		baseHeight = doc.selection.createRange().duplicate().boundingHeight;

		if (!document.forms[form_name])
		{
			document.body.focus();
		}
	}
}

// Apply bbcodes. Code from phpBB
// http://phpbb.com/

function bbcode(bbopen, bbclose)
{
	theSelection = false;

	var textarea = document.forms[form_name].elements[text_name];

	textarea.focus();

	if ((clientVer >= 4) && is_ie && is_win)
	{
		// Get text selection
		theSelection = document.selection.createRange().text;

		if (theSelection)
		{
			// Add tags around selection
			document.selection.createRange().text = bbopen + theSelection + bbclose;
			document.forms[form_name].elements[text_name].focus();
			theSelection = '';
			return;
		}
	}
	else if (document.forms[form_name].elements[text_name].selectionEnd && (document.forms[form_name].elements[text_name].selectionEnd - document.forms[form_name].elements[text_name].selectionStart > 0))
	{
		mozWrap(document.forms[form_name].elements[text_name], bbopen, bbclose);
		document.forms[form_name].elements[text_name].focus();
		theSelection = '';
		return;
	}
	
	//The new position for the cursor after adding the bbcode
	var caret_pos = getCaretPosition(textarea).start;
	var new_pos = caret_pos + bbopen.length;		

	// Open tag
	insert(bbopen + bbclose);

	// Center the cursor when we don't have a selection
	// Gecko and proper browsers
	if (!isNaN(textarea.selectionStart))
	{
		textarea.selectionStart = new_pos;
		textarea.selectionEnd = new_pos;
	}	
	// IE
	else if (document.selection)
	{
		var range = textarea.createTextRange(); 
		range.move("character", new_pos); 
		range.select();
		storeCaret(textarea);
	}

	textarea.focus();
	return;
}

// Insert text at position. Code from phpBB
// http://phpbb.com/

function insert(text, spaces, popup)
{
	var textarea;
	
	if (!popup) 
	{
		textarea = document.forms[form_name].elements[text_name];
	} 
	else 
	{
		textarea = opener.document.forms[form_name].elements[text_name];
	}
	if (spaces) 
	{
		text = ' ' + text + ' ';
	}
	
	if (!isNaN(textarea.selectionStart))
	{
		var sel_start = textarea.selectionStart;
		var sel_end = textarea.selectionEnd;

		mozWrap(textarea, text, '')
		textarea.selectionStart = sel_start + text.length;
		textarea.selectionEnd = sel_end + text.length;
	}
	else if (textarea.createTextRange && textarea.caretPos)
	{
		if (baseHeight != textarea.caretPos.boundingHeight) 
		{
			textarea.focus();
			storeCaret(textarea);
		}

		var caret_pos = textarea.caretPos;
		caret_pos.text = caret_pos.text.charAt(caret_pos.text.length - 1) == ' ' ? caret_pos.text + text + ' ' : caret_pos.text + text;
	}
	else
	{
		textarea.value = textarea.value + text;
	}
	if (!popup) 
	{
		textarea.focus();
	}
}

// From http://www.massless.org/mozedit/

function mozWrap(txtarea, open, close)
{
	var selLength = txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	var scrollTop = txtarea.scrollTop;

	if (selEnd == 1 || selEnd == 2) 
	{
		selEnd = selLength;
	}

	var s1 = (txtarea.value).substring(0,selStart);
	var s2 = (txtarea.value).substring(selStart, selEnd)
	var s3 = (txtarea.value).substring(selEnd, selLength);

	txtarea.value = s1 + open + s2 + close + s3;
	txtarea.selectionStart = selEnd + open.length + close.length;
	txtarea.selectionEnd = txtarea.selectionStart;
	txtarea.focus();
	txtarea.scrollTop = scrollTop;

	return;
}

// Insert at Caret position. Code from
// http://www.faqts.com/knowledge_base/view.phtml/aid/1052/fid/130

function storeCaret(textEl)
{
	if (textEl.createTextRange)
	{
		textEl.caretPos = document.selection.createRange().duplicate();
	}
}

// Caret Position object. Code from phpBB
// http://phpbb.com/

function caretPosition()
{
	var start = null;
	var end = null;
}

// Get the caret position in an textarea. Code from phpBB
// http://phpbb.com/

function getCaretPosition(txtarea)
{
	var caretPos = new caretPosition();
	
	// simple Gecko/Opera way
	if(txtarea.selectionStart || txtarea.selectionStart == 0)
	{
		caretPos.start = txtarea.selectionStart;
		caretPos.end = txtarea.selectionEnd;
	}
	// dirty and slow IE way
	else if(document.selection)
	{
	
		// get current selection
		var range = document.selection.createRange();

		// a new selection of the whole textarea
		var range_all = document.body.createTextRange();
		range_all.moveToElementText(txtarea);
		
		// calculate selection start point by moving beginning of range_all to beginning of range
		var sel_start;
		for (sel_start = 0; range_all.compareEndPoints('StartToStart', range) < 0; sel_start++)
		{		
			range_all.moveStart('character', 1);
		}
	
		txtarea.sel_start = sel_start;
	
		// we ignore the end value for IE, this is already dirty enough and we don't need it
		caretPos.start = txtarea.sel_start;
		caretPos.end = txtarea.sel_start;			
	}

	return caretPos;
}

function smile(code, popup)
{
	return insert(code, true, popup);
}

function changeVisibility(id)
{
	var obj = document.getElementById(id);
	
	if (obj == null || typeof(obj) == "undefined")
		return;
	
	var current = obj.style.display;
	var change = {
		"none": { "display": "block" },
		"block": { "display": "none" }
	}
	
	obj.style.display = change[current]["display"];
	
	return;
}

function to(username)
{
	insert('[b]' + username + '[/b]' + '\n');
}

function quote(username)
{
	var txt = '';
	
	if (window.getSelection)
	{
		txt = window.getSelection().toString();
	}
	else if (document.getSelection)
	{
		txt = document.getSelection();
	}
	else if (document.selection)
	{
		txt = document.selection.createRange().text;
	}
	
	if (txt == null || typeof(txt) == "undefined" || txt == '')
	{
		alert('Не выделен текст для цитирования');
		return;
	}
	else
	{
		insert('[quote=' + username + ']' + txt + '[/quote]' + '\n');
	}
}

function tag_url()
{
	var FoundErrors = '';
	var enterURL = prompt("Поместите ссылку веб-страницы", "http://");
	var enterTITLE = prompt("Введите название ссылки", "Поситите мой сайт");
	if (!enterURL)
	{
		FoundErrors += " " + error_no_url;
	}
	if (!enterTITLE)
	{
		FoundErrors += " " + error_no_title;
	}
	if (FoundErrors)
	{
		alert("Ошибка!" + FoundErrors);
		return;
	}
	insert('[url=' + enterURL + ']' + enterTITLE + '[/url]');
}

function tag_image()
{
	var FoundErrors = '';
	var enterURL = prompt("Поместите ссылку изображения", "http://");
	if (!enterURL)
	{
		FoundErrors += " " + error_no_url;
	}
	if (FoundErrors)
	{
		alert("Ошибка!" + FoundErrors);
		return;
	}
	insert('[img]' + enterURL + '[/img]');
}

function tag_email()
{
	var emailAddress = prompt("Поместите e-mail адрес", "");
	if (!emailAddress)
	{
		alert(error_no_email);
		return;
	}
	insert('[email]' + emailAddress + '[/email]');
}

function keyboard_code(value)
{
	if (value == 'Caps')
		Capspos = !(Capspos)
	else
	{
		var txt = document.getElementById('main-reply').value;
		if (value == 'Back')
			txt = txt.substr(0, txt.length - 1);
		else
			txt = txt + value;
		document.getElementById('main-reply').value = txt;
	}
}

// Опросы

var max_id = 0;
var p_in_l = new Array (); // индекс массива - id эелемента в базе, значение - на каком месте находится в списке
var val = new Array (); // индекс массива - id эелемента в базе, значение - выводимый текст
var l_in_p = new Array (); // здесь наоборот, индекс - место в списке, значение - id элемента, который на это место поставлен

// Формируем массив, соответствующий последовательности отображения элементов на экране:

drawBlock(); // отобразить формочки

function drawBlock()
{
	last_pos = (l_in_p.length == 0) ? 0 : l_in_p.length - 1; // кол-во элементов

	for (i=1; i<l_in_p.length; i++)
	{
		if (l_in_p[i] && l_in_p[i] > max_id) max_id = l_in_p[i];
			drawElement(i);
	}
}

function add_element()
{
	last_pos = (l_in_p.length == 0) ? 0 : l_in_p.length - 1; // кол-во элементов

	max_id = max_id + 1
	new_elm_id = max_id;
	last_pos = last_pos+1;

	// задаем значения в массивах для нового элемента
	l_in_p[last_pos] = new_elm_id;
	p_in_l[new_elm_id] = last_pos;
	val[new_elm_id] = '';

	draw_element(last_pos);

	return true;
}

function draw_element(i)
{
	// i - это индекс в массиве, где значение элементов массива есть id
	var id = l_in_p[i];
	var id_elm = 'row_' + id;
	var new_elm = '<label><strong>Вариант ' + id + '</strong><br /><input type="text" name="poll_option[' + id + ']" value="' + val[id] + '" size="70" maxlength="55" /><br /></label>';
	document.getElementById('variants').innerHTML = document.getElementById('variants').innerHTML + new_elm;

	return true;
}