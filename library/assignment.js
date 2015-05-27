// JavaScript Document
function checkAssignForm()
{	
	with (window.document.frmAddUser) {
		if (isEmpty(vendor, 'Choose a Vendor')) {
			return;
		} else if (isEmpty(category, 'Choose a Product')) {
			return;
		} else {
			submit();
		}
	}
}

function assignAsset()
{
	//alert('assign');
	window.location.href = '../view.php?v=assign';
}

function addProduct()
{
	//alert('assign');
	window.location.href = '../view.php?v=addhardware';
}

function changePassword(userId)
{
	window.location.href = 'index.php?view=modify&userId=' + userId;
}

function deleteHw(id)
{
	if (confirm('Delete this Hardware?')) {
		window.location.href = 'hardware/processHardware.php?action=delete&id=' + id;
	}
}

