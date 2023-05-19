let title = document.getElementById('article_form_title');
let errorNode = document.createElement('span');
let textNode = document.createTextNode('Не используйте цифры');
let hasError = false;

title.addEventListener('input', (e) => {
  if (/\d/.test(title.value)) {
    errorNode.appendChild(textNode);
    errorNode.style.color = 'red';
    title.classList.add('is-invalid');
    title.parentNode.appendChild(errorNode);
    hasError = true;
  } else {
      if (hasError) {
        title.classList.remove('is-invalid');
        title.parentNode.removeChild(errorNode);
        hasError = false
      }
  }
});
