//log off function. Sets input type as 'logoff' and reloads the page.
function logoff(){
    form = document.createElement('form');
    form.setAttribute('method', 'POST');
    form.setAttribute('action', 'homepage.php');
    myvar = document.createElement('input');
    myvar.setAttribute('name', 'infoType');
    myvar.setAttribute('type', 'hidden');
    myvar.setAttribute('value', 'logoff');
    form.appendChild(myvar);
    document.body.appendChild(form);
    form.submit(); 
}