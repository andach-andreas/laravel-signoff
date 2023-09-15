//******************************************************************
// Signature Pad
//
// This is required for the Signoffable object, so the end user can
// sign on a phone or tablet screen (or by using the mouse).
//
// It relies on the <x-form including class="e-signpad" and the
// submit button including class="sign-pad-button-submit".
//******************************************************************

import SignaturePad from 'signature_pad';

const eSignpads = document.querySelectorAll('.e-signpad');

let submitted = false;

eSignpads.forEach(function(eSignpad) {
    let signaturePad = new SignaturePad(eSignpad.querySelector('canvas')),
        submit = eSignpad.querySelector('.sign-pad-button-submit'),
        clear = eSignpad.querySelector('.sign-pad-button-clear'),
        disabledWithoutSignature = parseInt(eSignpad.getAttribute('data-disabled-without-signature'));

    signaturePad.addEventListener("beginStroke", () => {
        if(disabledWithoutSignature) {
            submit.removeAttribute('disabled');
        }
    });

    submit.addEventListener('click', (event) => {
        if (submitted) {
            event.preventDefault();
        }
        submitted = true;
        eSignpad.querySelector('.sign').value = signaturePad.toDataURL();
    });

    clear.addEventListener('click', () => {
        signaturePad.clear();
        if(disabledWithoutSignature) {
            submit.setAttribute('disabled', 'disabled');
        }
    })

});
