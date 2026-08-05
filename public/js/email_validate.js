var NewsEmail=document.getElementById('NewsEmail');
var userEmail=document.getElementById('UserEmail');
function validateEmail(email){
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}
function NewsEmailFunction(){
  var email=NewsEmail.value;
  
  if(validateEmail(email)){
    NewsEmail.style.background='rgba(255,255,255,0.35)';
    NewsEmail.style.border='2px solid rgba(255,255,255,0.8)';
    alert('Subscribed! Welcome to Linkspam.');
  } else {
    NewsEmail.style.background='rgba(255,80,80,0.25)';
    NewsEmail.style.border='2px solid rgba(255,80,80,0.7)';
    NewsEmail.value='';
    NewsEmail.placeholder='Enter a valid email';
  }
}
userEmail.addEventListener('blur', function () {
    if (!validateEmail(userEmail.value.trim())) {
        userEmail.value = '';
        userEmail.style.border='2px solid rgba(255,80,80,0.7)';
        userEmail.placeholder = 'Enter a valid email';
    }
});