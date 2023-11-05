var form = document.getElementById('form-search');
var search = document.getElementById('input-search');

function borderColor(){
    form.classList.add('focus');
}

function removeborderColor(){
    form.classList.remove('focus');
}

function showActivePage(){
    let url_atual = window.location.href;
    let itemTopics = document.querySelectorAll('#topics li');
    let linkTopics = document.querySelectorAll('#topics li a');
    
    for(i = 0; i < itemTopics.length; i++){
        let link = linkTopics[i].href;
        if(url_atual.indexOf(link) != -1 && url_atual == link){
            itemTopics[i].classList.toggle('active')
        }
    }
}

// Função para escrever letra por letra
'use strict';

function typeWriter(el) {
    const textArray = el.innerHTML.split('');
    el.innerHTML = '';
    textArray.forEach((letter, i) =>
        setTimeout(() => (el.innerHTML += letter), 20 * i)
        
    );
    
}

if(document.getElementById('welcome') != null){
    typeWriter(welcome);
}

addEventListener('load', showActivePage);
search.addEventListener('focus', borderColor);
search.addEventListener('blur', removeborderColor);









