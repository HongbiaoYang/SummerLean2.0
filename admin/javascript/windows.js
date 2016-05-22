function open_new_window(url, window_name)
{
	new_window = window.open(url, window_name,'toolbar=0,menubar=0,resizable=0,dependent=0,status=0,width=780,height=700,left=25,top=25')
}


function jumpto(x) {
	if (document.form1.jumpmenu.value != "null") {
		document.location.href = x;
	}
}
