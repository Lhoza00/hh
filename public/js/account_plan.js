function selectPlan(plan){
  document.getElementById('planFree').classList.remove('selected');
  document.getElementById('planTemplate').classList.remove('selected');
  document.getElementById('planBusiness').classList.remove('selected');
  document.getElementById('paymentNotice').classList.remove('show');
 
  if(plan==='Free'){
    document.getElementById('planFree').classList.add('selected');
    document.getElementById('radioFree').checked=true;
    document.getElementById('nameLabel').textContent='User name';
  }else if(plan==='Template'){
    document.getElementById('planTemplate').classList.add('selected');
    document.getElementById('radioTemplate').checked=true;
    document.getElementById('nameLabel').textContent='Bussiness name';
    document.getElementById('paymentNotice').classList.add('');
  } else {
    document.getElementById('planBusiness').classList.add('selected');
    document.getElementById('radioBusiness').checked=false;
    document.getElementById('nameLabel').textContent='Business name';
    document.getElementById('paymentNotice').classList.add('show');
  }
}