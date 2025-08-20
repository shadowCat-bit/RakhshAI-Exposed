const form = document.querySelector('#loginForm');

form.addEventListener('submit', (event) => {
    $('.submit-btn-text').addClass('d-none');
    $('.spinner').removeClass('d-none');
    $('#loginForm').find('button[type=submit]').attr("disabled", "disabled");
});

var persianNumbers = [/۰/g, /۱/g, /۲/g, /۳/g, /۴/g, /۵/g, /۶/g, /۷/g, /۸/g, /۹/g];
var arabicNumbers = [/٠/g, /١/g, /٢/g, /٣/g, /٤/g, /٥/g, /٦/g, /٧/g, /٨/g, /٩/g];

    function fixNumbers(str) {
        if (typeof str === 'string') {
            for (var i = 0; i < 10; i++) {
                str = str.replace(persianNumbers[i], i).replace(arabicNumbers[i], i);
            }
        }
        return str;
    };

    $('.convert-to-en-num').on('input', function () {
        $(this).attr('value', fixNumbers($(this).val()));
        $(this).val(fixNumbers($(this).val()));
    });

// document.getElementById('mobile').addEventListener("input", function(){
//     if($('.mobile-hidden').val().length > 10){
//         this.value = this.value.slice(0, 13);
//         return false;
//     }
//     var txt=this.value;
//     console.log(this.value)
//     console.log(this.value.trim());
//     $('.mobile-hidden').val(this.value.replace(/ /g, ""));
//     if (txt.length==4 || txt.length==8){
//         this.value=this.value+" ";
//     }
// });

var isRegStep2 = $('.register-step-2');

if(isRegStep2.length > 0){
    var usernameRelaod = sessionStorage.getItem('username_reload');
    var passwordReload = sessionStorage.getItem('password_reload');

    if(usernameRelaod){
        document.getElementById('username').value = usernameRelaod;
        sessionStorage.removeItem('username_reload');
    } else {
        $('input[name=username]').focus();
    }

    if(passwordReload){
        document.getElementById('password').value = passwordReload;
        sessionStorage.removeItem('password_reload');
    }

    if(usernameRelaod && passwordReload){
        $('input[name=verify_code]').focus();
    }

    $('.step2-register-form').find('input[name=verify_code]').on('input' , function (){
        if($(this).val().length >= 4){
            var usernameInput = document.getElementById('username');
            var passwordInput = document.getElementById('password');

            if(usernameInput.value !== '' && passwordInput !== ''){
                sessionStorage.setItem('username_reload' , usernameInput.value);
                sessionStorage.setItem('password_reload' , passwordInput.value);

                $('.submit-btn-text').addClass('d-none');
                $('.spinner').removeClass('d-none');
                document.getElementById('loginForm').submit();
            }
        }
    })
}

$('.visibility').on('click' , function (){
    $(this).find('img').toggleClass('d-none');
    var passInput = $(this).parents('.toggle-password').find('.pass-input');
    if(passInput.attr('type') == 'password'){
        passInput.attr('type' , 'text');
    } else {
        passInput.attr('type' , 'password');
    }
})

$('.btn-edit-number').on('click' , function (){
    sessionStorage.setItem('mobile_for_edit' , $('input[name=mobile]').val());
    window.location.href = "/auth/register";
})

var isRegStep1 = $('.register-step-1');

if(isRegStep1.length > 0){
    console.log('step 1')
    var mobileForEdit = sessionStorage.getItem('mobile_for_edit');
    if(mobileForEdit){
        $('input[name=mobile]').val(mobileForEdit);
        sessionStorage.removeItem('mobile_for_edit');
    }
}


// const inputElements = [...document.querySelectorAll('input.code-input')]
//
// inputElements.forEach((ele,index)=>{
//     ele.addEventListener('keydown',(e)=>{
//         // if the keycode is backspace & the current field is empty
//         // focus the input before the current. Then the event happens
//         // which will clear the "before" input box.
//         if(e.keyCode === 8 && e.target.value==='') inputElements[Math.max(0,index-1)].focus()
//     })
//     ele.addEventListener('input',(e)=>{
//         // take the first character of the input
//         // this actually breaks if you input an emoji like 👨‍👩‍👧‍👦....
//         // but I'm willing to overlook insane security code practices.
//         const [first,...rest] = e.target.value
//         e.target.value = first ?? '' // first will be undefined when backspace was entered, so set the input to ""
//         const lastInputBox = index===inputElements.length-1
//         const didInsertContent = first!==undefined
//         if(didInsertContent && !lastInputBox) {
//             // continue to input the rest of the string
//             inputElements[index+1].focus()
//             inputElements[index+1].value = rest.join('')
//             inputElements[index+1].dispatchEvent(new Event('input'))
//         }
//         if(lastInputBox && didInsertContent){
//             var inputs = document.querySelectorAll('.code-input');
//             var allFilled = true;
//
//             for (var i = 0; i < inputs.length; i++) {
//                 if (inputs[i].value === '') {
//                     allFilled = false;
//                     break;
//                 }
//             }
//
//             if (allFilled) {
//                 var usernameInput = document.getElementById('username');
//                 var passwordInput = document.getElementById('password');
//
//                 if(usernameInput.value !== '' && passwordInput !== ''){
//                     sessionStorage.setItem('username_reload' , usernameInput.value);
//                     sessionStorage.setItem('password_reload' , passwordInput.value);
//                     $('.submit-btn-text').addClass('d-none');
//                     $('.spinner').removeClass('d-none');
//                     document.getElementById('loginForm').submit();
//                 }
//             }
//         }
//     })
// })


// mini example on how to pull the data on submit of the form
// function onSubmit(e){
//     e.preventDefault()
//     const code = inputElements.map(({value})=>value).join('')
//     console.log(code)
// }
