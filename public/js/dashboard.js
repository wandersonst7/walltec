window.addEventListener('DOMContentLoaded', event => {
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

function showActivePage(){
    let url_atual = window.location.href;
    let linkTopics = document.querySelectorAll('#topics a');
    
    for(i = 0; i < linkTopics.length; i++){
        let link = linkTopics[i].href;
        if(url_atual.indexOf(link) != -1 && url_atual == link){
            linkTopics[i].classList.toggle('active')
        }
    }
}

addEventListener('load', showActivePage);




var pendingFormConfirmation;

function confirmDeleteModal(button){
    var confModal = new bootstrap.Modal(document.getElementById('confirm_modal'))
    confModal.show('fast');
    pendingFormConfirmation = button.parentElement;
}

function confirmButton(){
    pendingFormConfirmation.submit();
}

var form = document.getElementById('form-search');
var search = document.getElementById('input-search');

function borderColor(){
    form.classList.add('focus');
}

function removeborderColor(){
    form.classList.remove('focus');
}
