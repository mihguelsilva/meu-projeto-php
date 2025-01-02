document.addEventListener('DOMContentLoaded', () => {
    let tdCpfCnpj = document.querySelector('td#td-cpf-cnpj');
    let cpfCnpj = document.querySelector('td#cpf-cnpj');
    let altTel = document.querySelectorAll('button.alterar-telefone');
    altTel.forEach((element, index) => {
	element.addEventListener('click', (e) => {
	    desabilitarBotaoEditar(document.querySelectorAll('button.alterar-telefone'));
	    let tagName = e.target.parentElement.tagName;
	    let parent = e.target.parentElement;
	    if (tagName == "TD") {
		setGetForm(parent)
	    } else if (tagName == 'BUTTON') {
		setGetForm(parent.parentElement);
	    }
	    function setGetForm(parent) {
		let id_tel = parent.getAttribute('id');
		let db_fld = parent.getAttribute('name');
		parent.innerHTML = '';
		let getForm = document.createElement('form');
		getForm.setAttribute('method', 'GET');
		getForm.setAttribute('class', 'was-validated');
		getForm.setAttribute('action', '/alterar/usuario.php');
		let input_id = document.createElement('input');
		input_id.setAttribute('name', 'id');
		input_id.setAttribute('value', id_tel);
		input_id.setAttribute('readonly', true);
		input_id.setAttribute('style', 'display:none;');
		let input_name = document.createElement('input');
		input_name.setAttribute('name', 'type');
		input_name.setAttribute('value', db_fld);
		input_name.setAttribute('readonly', true);
		input_name.setAttribute('style', 'display:none;');
		let input_fld = document.createElement('input');
		input_fld.setAttribute('name', 'fld');
		input_fld.setAttribute('value', 'telefone');
		input_fld.setAttribute('readonly', true);
		input_fld.setAttribute('style', 'display:none;');
		let input_ctt = document.createElement('input');
		input_ctt.setAttribute('onkeyup', 'verificarTelefone(this)');
		input_ctt.setAttribute('name', 'ctt');
		input_ctt.setAttribute('class', 'form-control');
		if (db_fld == 'HOME' || db_fld == 'BUSINESS') {
		    input_ctt.setAttribute('maxlength', '11');
		} else if (db_fld == 'CELL') {
		    input_ctt.setAttribute('maxlength', '12');
		}
		let button = document.createElement('button');
		button.setAttribute('type', 'submit');
		button.setAttribute('class', 'btn btn-outline-primary');
		button.setAttribute('name', 'action');
		button.setAttribute('value', 'atualizar')
		button.append('Alterar');
		getForm.append(input_id);
		getForm.append(input_name);
		getForm.append(input_fld);
		getForm.append(input_ctt);
		getForm.append(button);
		parent.append(getForm);
	    }
	});
    });
    function desabilitarBotaoEditar(e) {
	e.forEach((element, index) => {
	    element.setAttribute('disabled', 'true');
	})
    }
});

function verificarTelefone(e) {
    let v = e.value;
    if(!v.match(/^\d+$/)) {
	Swal.fire({
	    title: 'Erro!',
	    text: 'O campo só pode ser preenchido com números!',
	    icon: 'error',
	    confirmButtonText: 'Fechar'
	});
	e.value = '';
    };
}
