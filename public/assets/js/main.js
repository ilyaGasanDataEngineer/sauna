// Smooth anchor scroll
document.querySelectorAll('a[href^="/#"], a[href^="#"]').forEach(a=>{
  a.addEventListener('click', e=>{
    const id = a.getAttribute('href').replace('/','');
    const el = document.querySelector(id);
    if(el){ e.preventDefault(); window.scrollTo({top: el.offsetTop-70, behavior:'smooth'}); }
  });
});

// GLightbox
const lightbox = GLightbox({ touchNavigation: true });

// Swiper on project page
if (document.querySelector('.project-swiper')) {
  new Swiper('.project-swiper', {
    loop: true,
    spaceBetween: 8,
    slidesPerView: 1,
    pagination: { el: '.swiper-pagination', clickable: true },
    navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }
  });
}

// Inputmask + validation
document.querySelectorAll('input[name="phone"]').forEach(i=>{
  try{ new Inputmask('+7 (999) 999-99-99').mask(i); }catch(e){}
});
function attachValidation(form){
  const v = new window.JustValidate(form, { focusInvalidField: true, errorFieldCssClass: 'is-invalid' });
  v.addField('[name="name"]', [{ rule:'minLength', value:2 }]);
  v.addField('[name="phone"]', [{ rule:'required' }]);
  v.onSuccess(async (ev)=>{
    ev.preventDefault();
    const data = new FormData(form);
    const res = await fetch('/send.php', { method:'POST', body:data });
    const json = await res.json().catch(()=>({ok:false,msg:'Ошибка'}));
    const box = form.querySelector('#formMsg') || document.getElementById('formMsg');
    if(json.ok){ box.textContent = json.msg; form.reset(); }
    else { box.textContent = json.msg || 'Не удалось отправить'; }
  });
}
document.querySelectorAll('form#contactForm').forEach(attachValidation);
