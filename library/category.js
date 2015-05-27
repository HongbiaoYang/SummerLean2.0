// JavaScript Document
function checkAddCatForm()
{	
	alert('inside checkaddcatform');
	with (window.document.frmAddUser) {
		if (isEmpty(txtCname, 'Enter Category name')) {
			return;
		} else if (isEmpty(txtType, 'Enter Type')) {
			return;
		} else if (isEmpty(txtDesc, 'Enter Category Description 2')) {
			return;
		} else {
			submit();
		}
	}
}

function addCategory()
{
	window.location.href = '../view.php?v=addcat';
}

function changePassword(userId)
{
	window.location.href = 'index.php?view=modify&userId=' + userId;
}

function deleteCategory(id)
{
	if (confirm('Delete this Category?')) {
		window.location.href = '../category/processCat.php?action=delete&id=' + id;
	}
}

