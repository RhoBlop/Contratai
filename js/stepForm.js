let btnPrev = document.getElementById('btnPrev');
let btnNext = document.getElementById('btnNext');
let btnSubmit = document.getElementById('btnSubmit');
let step = document.getElementsByClassName('step');
let form = document.getElementsByTagName('form')[0];


let current_step = 0;
let step_count = 1;
step[current_step].classList.add('d-block');
if (current_step == 0) {
    btnPrev.classList.add('d-none');
    btnSubmit.classList.add('d-none');
    btnNext.classList.add('d-inline-block');
}

btnNext.addEventListener('click', () => {
    current_step++;
    let previous_step = current_step - 1;
    if ((current_step > 0) && (current_step <= step_count)) {
        btnPrev.classList.remove('d-none');
        btnPrev.classList.add('d-inline-block');
        step[current_step].classList.remove('d-none');
        step[current_step].classList.add('d-block');
        step[previous_step].classList.add('d-block');
        step[previous_step].classList.add('d-none');
        if (current_step == step_count) {
            btnSubmit.classList.remove('d-none');
            btnSubmit.classList.add('d-inline-block');
            btnNext.classList.remove('d-inline-block');
            btnNext.classList.add('d-none');
        }
    } else {
        if (current_step > step_count) {
            form.onsubmit = () => {
                return true
            }
        }
    }
});

btnPrev.addEventListener('click', () => {
    if (current_step > 0) {
        current_step--;
        let previous_step = current_step + 1;
        btnPrev.classList.add('d-none');
        btnPrev.classList.add('d-inline-block');
        step[current_step].classList.remove('d-none');
        step[current_step].classList.add('d-block')
        step[previous_step].classList.remove('d-block');
        step[previous_step].classList.add('d-none');
        if (current_step < step_count) {
            btnSubmit.classList.remove('d-inline-block');
            btnSubmit.classList.add('d-none');
            btnNext.classList.remove('d-none');
            btnNext.classList.add('d-inline-block');
            btnPrev.classList.remove('d-none');
            btnPrev.classList.add('d-inline-block');
        }
    }
 
    if (current_step == 0) {
        btnPrev.classList.remove('d-inline-block');
        btnPrev.classList.add('d-none');
    }
});
 
 
btnSubmit.addEventListener('click', () => {
    preloader.classList.add('d-block');
 
    const timer = ms => new Promise(res => setTimeout(res, ms));
 
    timer(3000).then(() => {
            bodyElement.classList.add('loaded');
        }).then(() => {
            step[step_count].classList.remove('d-block');
            step[step_count].classList.add('d-none');
            btnPrev.classList.remove('d-inline-block');
            btnPrev.classList.add('d-none');
            btnSubmit.classList.remove('d-inline-block');
            btnSubmit.classList.add('d-none');
            succcessDiv.classList.remove('d-none');
            succcessDiv.classList.add('d-block');
        })
});