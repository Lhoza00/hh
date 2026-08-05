function togglePw(inputId, buttonId){
  const inp = document.getElementById(inputId);
  const btn = document.getElementById(buttonId);

  if(inp.type === 'password'){
    inp.type = 'text';
    btn.textContent = 'Hide';
  } else {
    inp.type = 'password';
    btn.textContent = 'Show';
  }
}