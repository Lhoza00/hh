const menuBtn=document.getElementById('menu-btn');
const miniNav=document.getElementById('mini-navbar');
menuBtn.addEventListener('click',function(e){
  e.stopPropagation();
  const open=miniNav.classList.toggle('open');
  menuBtn.setAttribute('aria-expanded',open);
  miniNav.setAttribute('aria-hidden',!open);
  menuBtn.innerHTML=open?'<i class="fas fa-times"></i>':'<i class="fas fa-bars"></i>';
});
document.addEventListener('click',function(e){
  if(!menuBtn.contains(e.target)&&!miniNav.contains(e.target)){
    miniNav.classList.remove('open');
    menuBtn.setAttribute('aria-expanded','false');
    miniNav.setAttribute('aria-hidden','true');
    menuBtn.innerHTML='<i class="fas fa-bars"></i>';
  }
});

window.addEventListener('load',function(){
  setTimeout(function(){
    document.getElementById('prog').style.width='68%';
    document.querySelectorAll('.ch-fill').forEach(function(el){el.style.width=el.dataset.w+'%'});
  },400);
});