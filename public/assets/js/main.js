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

// Scroll reveal
const io = new IntersectionObserver((entries)=>{
  entries.forEach(e=>{
    if(e.isIntersecting){ e.target.classList.add('is-visible'); io.unobserve(e.target); }
  })
},{ threshold: 0.2 });
document.querySelectorAll('.reveal').forEach(el=> io.observe(el));

// header scroll shadow (1.3)
(function(){
  const nav = document.querySelector('.choco-nav');
  if (!nav) return;
  const onScroll = () => {
    if (window.scrollY > 10) nav.classList.add('scrolled');
    else nav.classList.remove('scrolled');
  };
  onScroll();
  window.addEventListener('scroll', onScroll, { passive: true });
})();

// === About Benefit Modal ===
(function(){
  const root = document.getElementById('aboutModal');
  if(!root) return;

  const dlg = root.querySelector('.about-modal__dialog');
  const btnClose = root.querySelector('.about-modal__close');
  const img = root.querySelector('#aboutModalImg');
  const title = root.querySelector('#aboutModalTitle');
  const text = root.querySelector('#aboutModalText');
  let lastFocus = null;

  function open(data){
    lastFocus = document.activeElement;
    img.src = data.img || '';
    img.alt = data.title || '';
    title.textContent = data.title || '';
    text.textContent = data.text || '';
    root.classList.add('is-open');
    document.body.style.overflow = 'hidden';
    btnClose.focus();
    document.addEventListener('keydown', onKey);
  }
  function close(){
    root.classList.remove('is-open');
    document.body.style.overflow = '';
    document.removeEventListener('keydown', onKey);
    if(lastFocus) { try{ lastFocus.focus(); }catch(_){} }
  }
  function onKey(e){
    if(e.key === 'Escape' || e.key === 'Esc') { e.preventDefault(); close(); }
    if(e.key === 'Tab'){ // примитивный фокус-трап на close
      if(document.activeElement !== btnClose){ e.preventDefault(); btnClose.focus(); }
    }
  }

  root.addEventListener('click', (e)=>{
    if(e.target.classList.contains('js-about-close') || e.target === root){ close(); }
  });
  btnClose.addEventListener('click', close);

  document.addEventListener('click', (e)=>{
    const t = e.target.closest('.ben-modal-trigger');
    if(!t) return;
    e.preventDefault();
    open({
      img: t.dataset.img || '',
      title: t.dataset.title || '',
      text: t.dataset.text || ''
    });
  });

  // клавиатура: открыть по Enter/Space на фокусной карточке
  document.addEventListener('keydown', (e)=>{
    if(e.target && e.target.classList && e.target.classList.contains('ben-modal-trigger')){
      if(e.key === 'Enter' || e.key === ' '){
        e.preventDefault();
        const t = e.target;
        open({ img:t.dataset.img, title:t.dataset.title, text:t.dataset.text });
      }
    }
  });
})();

// === Timeline progress on /process ===
(function(){
  const tl = document.querySelector('.timeline');
  const prog = document.querySelector('.timeline-progress');
  if(!tl || !prog) return;
  const update = () => {
    const rect = tl.getBoundingClientRect();
    const h = Math.min(rect.height, Math.max(0, window.innerHeight - rect.top));
    prog.style.height = Math.max(0, h) + 'px';
  };
  update();
  document.addEventListener('scroll', update, {passive:true});
  window.addEventListener('resize', update);
})();

// === Step Modal ===
(function(){
  const root = document.getElementById('stepModal');
  if(!root) return;

  const dlg = root.querySelector('.step-modal__dialog');
  const btnClose = root.querySelector('.step-modal__close');
  const img = root.querySelector('#stepModalImg');
  const title = root.querySelector('#stepModalTitle');
  const text = root.querySelector('#stepModalText');
  let lastFocus = null;

  function open(data){
    lastFocus = document.activeElement;
    img.src = data.img || '';
    img.alt = data.title || '';
    title.textContent = data.title || '';
    text.textContent = data.text || '';
    root.classList.add('is-open');
    document.body.style.overflow = 'hidden';
    btnClose.focus();
    document.addEventListener('keydown', onKey);
  }
  function close(){
    root.classList.remove('is-open');
    document.body.style.overflow = '';
    document.removeEventListener('keydown', onKey);
    if(lastFocus) { try{ lastFocus.focus(); }catch(_){} }
  }
  function onKey(e){
    if(e.key === 'Escape' || e.key === 'Esc') { e.preventDefault(); close(); }
    if(e.key === 'Tab'){ // примитивный фокус-трап
      if(document.activeElement !== btnClose){ e.preventDefault(); btnClose.focus(); }
    }
  }

  root.addEventListener('click', (e)=>{
    if(e.target.classList.contains('js-step-close') || e.target === root){ close(); }
  });
  btnClose.addEventListener('click', close);

  document.addEventListener('click', (e)=>{
    const t = e.target.closest('.step-modal-trigger');
    if(!t) return;
    e.preventDefault();
    open({
      img: t.dataset.img || '',
      title: t.dataset.title || '',
      text: t.dataset.text || ''
    });
  });

  // клавиатура: открыть по Enter/Space на фокусной карточке
  document.addEventListener('keydown', (e)=>{
    if(e.target && e.target.classList && e.target.classList.contains('timeline-card')){
      if(e.key === 'Enter' || e.key === ' '){
        e.preventDefault();
        const t = e.target;
        open({ img:t.dataset.img, title:t.dataset.title, text:t.dataset.text });
      }
    }
  });
})();

// === Project Quick View Modal ===
(function(){
  const root = document.getElementById('projectModal');
  if(!root) return;

  const btnClose = root.querySelector('.project-modal__close');
  const img = root.querySelector('#projectModalImg');
  const title = root.querySelector('#projectModalTitle');
  const text = root.querySelector('#projectModalText');
  const link = root.querySelector('#projectModalLink');
  let lastFocus = null;

  function open(data){
    lastFocus = document.activeElement;
    img.src = data.img || '';
    img.alt = data.title || '';
    title.textContent = data.title || '';
    text.textContent = data.text || '';
    link.href = data.link || '#';
    root.classList.add('is-open');
    document.body.style.overflow = 'hidden';
    btnClose.focus();
    document.addEventListener('keydown', onKey);
  }
  function close(){
    root.classList.remove('is-open');
    document.body.style.overflow = '';
    document.removeEventListener('keydown', onKey);
    if(lastFocus) { try{ lastFocus.focus(); }catch(_){} }
  }
  function onKey(e){
    if(e.key === 'Escape' || e.key === 'Esc') { e.preventDefault(); close(); }
    if(e.key === 'Tab'){ if(document.activeElement !== btnClose){ e.preventDefault(); btnClose.focus(); } }
  }

  root.addEventListener('click', (e)=>{
    if(e.target.classList.contains('js-project-close') || e.target === root){ close(); }
  });
  btnClose.addEventListener('click', close);

  // Открытие по клику по карточке (кроме ссылок с data-stop)
  document.addEventListener('click', (e)=>{
    const stop = e.target.closest('a[data-stop]');
    if (stop) return; // позволяем переход по ссылке "Страница проекта"
    const t = e.target.closest('.project-modal-trigger');
    if(!t) return;
    e.preventDefault();
    open({
      img: t.dataset.img || '',
      title: t.dataset.title || '',
      text: t.dataset.text || '',
      link: t.dataset.link || '#'
    });
  });

  // Клавиатура: Enter/Space на карточке
  document.addEventListener('keydown', (e)=>{
    if(e.target && e.target.classList && e.target.classList.contains('project-modal-trigger')){
      if(e.key === 'Enter' || e.key === ' '){
        e.preventDefault();
        const t = e.target;
        open({ img:t.dataset.img, title:t.dataset.title, text:t.dataset.text, link:t.dataset.link });
      }
    }
  });
})();
